<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuRateModel extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    protected $table = 'menu_rates';

    /**
     * Relationship to the MealsModel (menu)
     */
    public function menu()
    {
        return $this->belongsTo(MealsModel::class, 'menu_id', 'id');
    }
}
