<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'configs';

    protected $fillable = [
        'code',
        'name',
        'value',
        'group',
        'type',
    ];

    public $timestamps = true;

    protected $casts = [
        'value' => 'string',
    ];
}