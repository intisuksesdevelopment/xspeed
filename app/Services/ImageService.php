<?php

namespace App\Services;

use App\Models\Image; // Make sure you import your Image model
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request; // Using the user's provided namespace for this exception
use App\Exceptions\AlreadyExistException;
use Illuminate\Support\Facades\Log; // Included as per user's full class
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    /**
     * Saves all images from the request for a given reference.
     * This method will first delete all existing images for the reference
     * and then save the new ones provided in the request.
     *
     * @param  Request  $request  The incoming HTTP request.
     * @param  string  $ref  The reference type (e.g., 'items', 'products').
     * @param  int  $refId  The ID of the referenced item.
     * @return JsonResponse
     */
    public static function saveAll(Request $request, $ref, $refId)
    {
        try {
            $data = $request->all();

            // --- IMPORTANT FIX START ---
            // 1. Delete all existing images for this ref and refId.
            // This ensures that when new images are saved, old ones are removed,
            // preventing duplication during an edit operation.
            Image::where('ref', $ref)
                ->where('ref_id', $refId)
                ->delete();
            // --- IMPORTANT FIX END ---

            $images = [];

            // Iterate over the request data to find image fields
            foreach ($data as $key => $value) {
                // Check if the key starts with 'image' and the value is not null or empty
                if (strpos($key, 'image') === 0 && ! is_null($value) && $value !== '') {
                    $imageUrl = $value;

                    // Create a new image instance
                    $image = new Image;
                    $image->uuid = (string) Str::uuid();
                    $image->ref_id = $refId;
                    $image->ref = $ref;
                    $image->path = $imageUrl;
                    $image->source = 'web'; // Assuming 'web' as a default source

                    // Extract index from the key using regex (e.g., 'image1' -> index 0)
                    if (preg_match('/image(\d+)/', $key, $matches)) {
                        // Subtract 1 to make it 0-indexed if your frontend uses 1-indexed names (image1, image2)
                        $image->index = (int) $matches[1] - 1;
                    } else {
                        // If no number, assign a default or handle as needed, e.g., null or 0
                        $image->index = null;
                    }

                    // Validate if it's a valid image URL before saving
                    if (self::isValidImageUrl($imageUrl)) {
                        $image->name = self::getImageFilename($imageUrl);
                        $image->ext = self::getImageExtension($imageUrl);

                        // Save the new image to the database
                        $image->save();
                        $images[] = $image; // Add to array if you need to return them
                    } else {
                        Log::warning("Invalid image URL skipped: {$imageUrl} for ref: {$ref}, refId: {$refId}");
                    }
                }
            }

            // You might want to return the saved images or a more specific message
            return response()->json(['success' => true, 'message' => 'Images updated successfully!']);
        } catch (AlreadyExistException $e) { // Using the user's provided exception
            Log::error('Error in ImageService::saveAll (AlreadyExistException): '.$e->getMessage(), ['exception' => $e]);

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        } catch (\Exception $e) {
            Log::error('Error in ImageService::saveAll: '.$e->getMessage(), ['exception' => $e]);

            // Return a generic error message to the user for security/simplicity
            return response()->json(['success' => false, 'message' => 'An error occurred while updating images. Please try again later.']);
        }
    }

    /**
     * Retrieves the first image URL found in the request.
     *
     * @param  Request  $request  The incoming HTTP request.
     * @return string|null The image URL or null if not found.
     */
    public static function getCoverImage(Request $request)
    {
        // Note: Iterating directly over $request can be problematic for file uploads.
        // Consider using $request->input() or $request->file() more explicitly.
        foreach ($request->all() as $key => $value) { // Use $request->all() to iterate over all input
            if (strpos($key, 'image') === 0 && ! is_null($value) && $value !== '') {
                return $value;
            }
        }

        return null; // Return null if no image is found
    }

    /**
     * Validates if a given URL is a valid image URL.
     * This method performs an HTTP request to check content type.
     *
     * @param  string  $url  The URL to validate.
     * @return bool True if the URL is a valid image URL, false otherwise.
     */
    public static function isValidImageUrl($url)
    {
        // Check if URL is valid format
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        // Get image headers - Note: This can be slow and might fail for local paths or base64.
        // For local storage paths (e.g., /storage/images/...), this check might not be suitable.
        // Consider alternative validation if images are stored locally or are base64 encoded.
        $headers = @get_headers($url, 1);

        // Check if headers are available and contain content type
        if (! $headers || ! isset($headers['Content-Type'])) {
            return false;
        }

        // Check if content type is an image
        $contentType = is_array($headers['Content-Type']) ? $headers['Content-Type'][0] : $headers['Content-Type'];

        return strpos($contentType, 'image/') === 0;
    }

    /**
     * Extracts the file extension from a URL.
     *
     * @param  string  $url  The URL.
     * @return string The file extension.
     */
    public static function getImageExtension($url)
    {
        $path = parse_url($url, PHP_URL_PATH);

        return pathinfo($path, PATHINFO_EXTENSION);
    }

    /**
     * Extracts the filename (without extension) from a URL.
     *
     * @param  string  $url  The URL.
     * @return string The filename.
     */
    public static function getImageFilename($url)
    {
        $path = parse_url($url, PHP_URL_PATH);

        return pathinfo($path, PATHINFO_FILENAME);
    }

    /**
     * Downloads an image from a URL and stores it locally.
     *
     * @param  string  $url  The URL of the image to store.
     * @param  string  $filename  The desired filename for the stored image.
     * @return string|null The path to the stored image, or null if validation fails.
     */
    public static function storeImage($url, $filename)
    {
        if (self::isValidImageUrl($url)) {
            // Download and save the image
            $imageContent = file_get_contents($url);
            $filePath = 'images/'.$filename; // Saves to storage/app/images/
            Storage::put($filePath, $imageContent);

            return $filePath;
        } else {
            return null;
        }
    }
}
