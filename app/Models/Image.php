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

    public function item() {
        return $this->belongsTo(Item::class, 'ref_id') ->where('ref', 'items');
    }
}
