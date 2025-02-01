<?php
namespace App\Services;

use App\Constants\CommonConstants;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\NotFoundException;
use Illuminate\Support\Str;

class ImageService
{
    public static function getPaginated(Request $request)
    {
        $perPage = $request->input('per_page', CommonConstants::PAGE);
        // Default to 10 per page if not provided
        $sortBy = $request->input('sortBy', CommonConstants::SORT);
        // Default to 'id' if not provided
        $sortDirection = $request->input('sortDirection', CommonConstants::DIRECTION);
        // Default to 'asc' if not provided
        return Image::orderBy($sortBy, $sortDirection)->paginate($perPage);
    }
    public static function getDetail($uuid)
    {
        $image = Image::where('uuid', $uuid)->first();
        if (! $image) {
            throw new NotFoundException("uuid : {$uuid}");
        }
        return $image;
    }
    public static function save(Request $request)
    {
        $data  = $request->all();
        $image = new Image();
        $image->fill($data);
        $image->save();
        return $image;
    }
    public static function saveAll(Request $request, String $ref, $ref_id)
    {
        $data   = $request->all();
        $images = [];
        foreach ($data as $key => $value) {
            if (strpos($key, 'image') === 0 && ! is_null($value) && $value !== '') {

                $image = new Image();
                $image->fill([
                    'uuid'   => Str::uuid(),
                    'ref'    => $ref,
                    'ref_id' => $ref_id,
                    'source' => 'web',
                    'index'  => $key,
                    'status' => 0,
                ]);
                if ($image->isValidImageUrl($value)) {
                    $image->path = $value;
                    $image->ext = $image->getExtension($value);
                    $image->type = $image->mapRefToType($ref);
                    $image->save();
                    $images[] = $image;
                }
            }
        }
        return $images;
    }
    public static function update(Request $request)
    {
        $data  = $request->all();
        $image = Image::where('uuid', $data['uuid'])->first();
        if (! $image) {
            throw new NotFoundException("uuid : {$data['uuid']}");
        }
        $image->fill($data);
        $image->save();
        return $image;
    }
    public static function delete($uuid)
    {
        $image = Image::where('uuid', $uuid)->first();
        if (! $image) {
            throw new NotFoundException("uuid : {$uuid}");
        }
        $image->delete();
        return $image;
    }
}
