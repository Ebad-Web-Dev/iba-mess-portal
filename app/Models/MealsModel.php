<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealsModel extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    protected $table = 'menu_type'; 
    public function rate()
    {
        return $this->hasOne(MenuRateModel::class, 'menu_id', 'id');
    }
}