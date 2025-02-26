<?php
namespace App\Models;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Rack;
use App\Models\SubCategory;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
        'barcode',
        'image_url',
        'status',
        'created_by',
        'updated_by',
        'history_log',
    ];
    protected $hidden = [
        'id','basic_price'
    ];
    public function validateAttributes($attributes, $id = null)
    {
        $validator = Validator::make($attributes, [
            'uuid'           => 'required|uuid|unique:items,uuid,' . $id,
            'name'           => 'required|string',
            'category_id'    => 'required|integer',
            'subcategory_id' => 'nullable|integer',
            'warehouse_id'   => 'required|integer',
            'rack_id'        => 'required|integer',
            'basic_price'    => 'required|numeric',
            'sell_price'     => 'required|numeric',
            'unit'           => 'required|string|max:50',
            'stock'          => 'required|integer',
            'stock_min'      => 'required|integer',
            'currency'       => 'required|string|max:3',
            'sku'            => 'nullable|string|max:50',
            'barcode'        => 'nullable|string|max:50',
            'description'    => 'nullable|string',
            'image_url'      => 'nullable|string|max:255',
            'status'         => 'required|string|max:50',
            'created_by'     => 'nullable|integer',
            'updated_by'     => 'nullable|integer',
            'history_log'    => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return true;
    }
    public function getWithoutId(bool $hideId = false)
    {
        $array = $this->toArray();
        if ($hideId) {unset($array['id']);}
        return $array;
    }
    public function images()
    {
        return $this->hasMany(Image::class, 'ref_id')->where('ref', 'items');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function rack()
    {
        return $this->belongsTo(Rack::class);
    }
    public function isAvailable()
    {
        switch ($this['status']) {
            case 0:
                return 'Available';
            case 1:
                return 'Deleted';
            case 2:
                return 'Not Active';
            default:
                return 'Unknown Status';
        }
    }
}
