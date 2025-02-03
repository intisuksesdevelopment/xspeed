<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'nik',
        'username',
        'name',
        'phone',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'created_at',
        'updated_at',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function validateAttributes($attributes)
    {
        $validator = Validator::make($attributes, [
            'uuid'           => 'required|uuid|unique:users,uuid',
            'nik'            => 'required|string|max:50|unique:users,nik',
            'username'       => 'required|string|max:50',
            'name'           => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'email'          => 'required|string|email|max:255|unique:users,email',
            'password'       => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return true;
    }
}
