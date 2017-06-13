<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $fillable = [
        'name', 'email', 'password', 'username', 'phone_number', 'gender', 'address', 'is_active'
    ];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
