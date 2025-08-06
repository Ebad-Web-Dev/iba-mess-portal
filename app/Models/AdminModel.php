<?php

// app/Models/AdminModel.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rule;

class AdminModel extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin';
    
    protected $fillable = [
        'username',
        'email',
        'password'
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Validation rules for admin creation
    public static function rules($id = null)
    {
        return [
            'username' => 'required|string|max:255|unique:admin_models,username,'.$id,
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:admin_models,email,'.$id,
                'regex:/^[^@]+@iba\.edu\.pk$/i'
            ],
            'password' => 'required|string|min:8',
        ];
    }
}
