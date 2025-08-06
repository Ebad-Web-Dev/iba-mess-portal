<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_no',
        'room_no',
        'name',
        'class',
        'batch',
        'erp_id',
    ];

    protected $table = 'residents_list';
}
