<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\SoftDeletes;

class Extra extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    protected $appends = ['price_without_tax'];
    
    public function getPriceWithoutTaxAttribute()
    {
        return round($this->price / 1.15, 2);
    }

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }
    
    public function items()
    {
        return $this->belongsToMany('App\Models\Item');
    }

    public function getImageAttribute($value)
    {
        if (!empty($value) && file_exists(public_path($value))) {
            return url($value);
        } else {
            return 'http://via.placeholder.com/200x200?text=No+Image';
        }
    }


public function scopeFilter($query, QueryFilter $filters) {
    return $filters->apply($query);
}


}
