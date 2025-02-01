<?php
namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'ref_id',
        'ref',
        'name',
        'type',
        'description',
        'img_id',
        'path',
        'ext',
        'source',
        'status',
        'index',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'ref_id')->where('ref', 'items');
    }

    public function isValidImageUrl($url)
    {
        // Check if URL is valid
        if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
            return false;
        }

        // Get image headers
        $headers = @get_headers($url, 1);

        // Check if headers are available and contain content type
        if (!$headers || !isset($headers['Content-Type'])) {
            return false;
        }

        // Check if content type is an image
        $contentType = is_array($headers['Content-Type']) ? $headers['Content-Type'][0] : $headers['Content-Type'];
        return (strpos($contentType, 'image/') === 0);
    }

    public function getImageExtension($url)
    {
        $path = parse_url($url, PHP_URL_PATH);
        return pathinfo($path, PATHINFO_EXTENSION);
    }
}
