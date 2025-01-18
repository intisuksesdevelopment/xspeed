<?php
namespace App\Models;

use App\Models\Rack;
use App\Models\Brand;
use App\Models\Image;
use App\Models\Category;
use App\Models\Warehouse;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'category_id',
        'subcategory_id',
        'brand_id',
        'warehouse_id',
        'rack_id',
        'basic_price',
        'sell_price',
        'description',
        'quantity',
        'unit',
        'color',
        'stock',
        'stock_min',
        'currency',
        'sku',
        'desc',
        'image_url',
        'status',
        'created_by',
        'updated_by',
        'history_log',
    ];

    public function validateAttributes($attributes)
    {
        $validator = Validator::make($attributes, [
            'uuid' => 'required|uuid|unique:items,uuid',
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'subcategory_id' => 'required|integer',
            'warehouse_id' => 'required|integer',
            'rack_id' => 'required|integer',
            'basic_price' => 'required|numeric',
            'sell_price' => 'required|numeric',
            'quantity' => 'required|integer',
            'unit' => 'required|string|max:50',
            'color' => 'nullable|string|max:50',
            'stock' => 'required|integer',
            'stock_min' => 'required|integer',
            'currency' => 'required|string|max:3',
            'sku' => 'nullable|string|max:50',
            'desc' => 'nullable|string',
            'image_url' => 'nullable|string|max:255',
            'status' => 'required|string|max:50',
            'created_by' => 'required|integer',
            'updated_by' => 'nullable|integer',
            'history_log' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return true;
    }
    public function getWithoutId(bool $hideId = false) {
        $array = $this->toArray();
        if ($hideId) { unset($array['id']); }
        return $array;
    }
    public function images() {
        return $this->hasMany(Image::class, 'ref_id') ->where('ref', 'items');
    }
    public function category() {
        return $this->belongsTo(Category::class);
    }
    public function subcategory() {
         return $this->belongsTo(SubCategory::class);
    }
    public function brand() {
         return $this->belongsTo(Brand::class);
    }
    public function warehouse() {
         return $this->belongsTo(Warehouse::class);
    }
    public function rack() {
         return $this->belongsTo(Rack::class);
    }
    public function isAvailable() {
        return $this['status'] == 0 ? 'Tersedia' : 'Tidak Tersedia';
    }
}
