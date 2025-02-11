<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
        'role',
        'name',
        'phone',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'join_at',
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
            'password'          => 'hashed',
        ];
    }

    public function validateAttributes($attributes)
    {
        $validator = Validator::make($attributes, [
            'uuid'     => 'required|uuid|unique:users,uuid',
            'nik'      => 'required|string|max:50|unique:users,nik',
            'username' => 'required|string|max:50',
            'role'     => 'nullable|string|max:50',
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|max:20',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\W_]).+$/',
                function ($attribute, $value, $fail) {
                    if (! preg_match('/^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\W_]).+$/', $value)) {
                        return $fail('The ' . $attribute . ' must be at least 8 characters long and include at least one letter, one number, and one special character.');
                    }
                },
            ],

        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return true;
    }

    public function isAvailable()
    {
        return $this['status'] == 0 ? 'Available' : 'Not Available';
    }
}
