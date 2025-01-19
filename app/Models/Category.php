<?php
namespace App\Models;


use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'description',
        'image_url',
        'status',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];
    
    public function validateAttributes($attributes)
    {
        $validator = Validator::make($attributes, [
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url'   => 'nullable|url',
            'status'      => 'required|integer|in:0,1'
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return true;
    }
    public function isAvailable()
    {
        return $this['status'] == 0 ? 'Tersedia' : 'Tidak Tersedia';
    }
}
