<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable = ['name_ar', 'name_en', 'image', 'description_ar', 'description_en', 'dough_type_id', 'dough_type_2_id'];
    protected $hidden = ["dough_type_id", 'dough_type_2_id'];

    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }

    public function extras()
    {
        return $this->hasMany('App\Models\Extra');
    }

    public function doughTypes()
    {
        return $this->hasMany('App\Models\DoughType');
    }

    public function withouts()
    {
        return $this->hasMany('App\Models\Without');
    }

    public function getImageAttribute($value)
    {
        if (!empty($value) && file_exists(public_path($value))) {
            return url($value);
        } else {
            return 'http://via.placeholder.com/200x200?text=No+Image';
        }
    }
}
