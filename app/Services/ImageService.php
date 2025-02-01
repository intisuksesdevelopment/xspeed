<?php
namespace App\Services;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\AlreadyExistException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    public static function saveAll(Request $request, $ref, $refId)
    {
        try {
            $data   = $request->all();
            $images = [];

            // Iterate over the request data
            foreach ($data as $key => $value) {
                if (strpos($key, 'image') === 0 && ! is_null($value) && $value !== '') {
                    $imageUrl = $value;

                    // Create a new image instance
                    $image         = new Image();
                    $image->uuid   = (string) Str::uuid();
                    $image->ref_id = $refId;
                    $image->ref    = $ref;
                    $image->path   = $imageUrl;
                    $image->source   = 'web';
                    $image->index   = $key;

                    if (self::isValidImageUrl($imageUrl)) {
                        // Set the path and extension based on the image URL
                        $image->name  = self::getImageFilename($imageUrl);
                        $image->ext  = self::getImageExtension($imageUrl);

                        // Save the image to the database
                        $image->save();
                        $images[] = $image;
                    }
                }
            }

            return response()->json(['success' => true, 'message' => 'Add successfully!']);
        } catch (AlreadyExistException $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred. Please try again later.']);
        }
    }

    public static function isValidImageUrl($url)
    {
        // Check if URL is valid
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        // Get image headers
        $headers = @get_headers($url, 1);

        // Check if headers are available and contain content type
        if (! $headers || ! isset($headers['Content-Type'])) {
            return false;
        }

        // Check if content type is an image
        $contentType = is_array($headers['Content-Type']) ? $headers['Content-Type'][0] : $headers['Content-Type'];
        return (strpos($contentType, 'image/') === 0);
    }

    public static function getImageExtension($url)
    {
        $path = parse_url($url, PHP_URL_PATH);
        return pathinfo($path, PATHINFO_EXTENSION);
    }
    public static function getImageFilename($url)
    {
        $path = parse_url($url, PHP_URL_PATH);
        return pathinfo($path, PATHINFO_FILENAME);
    }

    public static function storeImage($url, $filename)
    {
        if (self::isValidImageUrl($url)) {
            // Download and save the image
            $imageContent = file_get_contents($url);
            $filePath     = 'images/' . $filename;
            Storage::put($filePath, $imageContent);
            return $filePath;
        } else {
            return null;
        }
    }
}
