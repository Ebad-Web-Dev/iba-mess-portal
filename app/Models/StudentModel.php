<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class StudentModel extends Model implements Authenticatable
{
 
 use AuthenticatableTrait;

    protected $table = 'students';
    protected $primaryKey = 'erp_id';
    public $incrementing = false;
    protected $keyType = 'string';

    // Required methods for Authenticatable
    public function getAuthIdentifierName()
    {
        return 'erp_id';
    }

    public function getAuthPassword()
    {
        return ''; // Return empty string since no password column exists
    }

    public function getRememberToken()
    {
        return null; // No remember token functionality
    }
}

