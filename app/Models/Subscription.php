<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'subscription';
    protected $dates = ['start_date', 'end_date'];
    // In Subscription model
public function scopeActive($query) {
    return $query->where('end_date', '>=', now());
}

    public function menuType()
    {
    return $this->belongsTo(MealsModel::class, 'menu_type_id');
    }
    public function menuRate()
    {
    return $this->belongsTo(MenuRateModel::class, 'menu_rate_id');
    }
    public function student()
    {
    return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}
