<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    protected $dates = ['date_from', 'date_to'];

    public function details() {

        if ($this->offer_type == 'buy-get') {
        	return $this->hasOne('App\Models\OfferBuyGet');
        }

        if ($this->offer_type == 'discount') {
            return $this->hasOne('App\Models\OfferDiscount');
        }

    }

    public function buyGet()
    {
    	return $this->hasOne('App\Models\OfferBuyGet');
    }

    public function discount()
    {
    	return $this->hasOne('App\Models\OfferDiscount');
    }

    public function scopeFilter($query, QueryFilter $filters) {
        return $filters->apply($query);
    }

    public function getImageAttribute($value)
    {
        if (!empty($value) && file_exists(public_path($value))) {
            return url($value);
        } else {
            return 'http://via.placeholder.com/200x200?text=No+Image';
        }
    }
    public function branches()
    {
        return $this->belongsToMany('App\Models\Branch', 'branch_offer');
    }


}
