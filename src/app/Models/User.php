<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int $role
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const
        USER_NAME = 'name',
        USER_EMAIL = 'email',
        USER_PASSWORD = 'password',
        USER_ROLE = 'role',
        USER_REMEMBER_TOKEN = 'remember_token',
        USER_EMAIL_VERIFIED_AT = 'email_verified_at';

    public const USER_ROLE_USER = 0, USER_ROLE_ADMIN = 1;

    protected $fillable = [
        self::USER_NAME,
        self::USER_EMAIL,
        self::USER_PASSWORD,
        self::USER_ROLE
    ];

    protected $hidden = [
        self::USER_PASSWORD,
        self::USER_REMEMBER_TOKEN,
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
