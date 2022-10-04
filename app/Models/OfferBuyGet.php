<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfferBuyGet extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    protected $table = 'offers_buy_get';

    protected $appends = ['offer_price_without_tax'];

    public function offer()
    {
        return $this->belongsTo('App\Models\Offer');
    }

    public function buyCategory()
    {
        return $this->belongsTo('App\Models\Category', 'buy_category_id');
    }

    public function buyItems()
    {
        return $this->belongsToMany('App\Models\Item', 'offer_buy_items', 'offer_id', 'item_id');
    }

    public function getItems()
    {
        return $this->belongsToMany('App\Models\Item', 'offer_get_items', 'offer_id', 'item_id');
    }

    public function getCategory()
    {
        return $this->belongsTo('App\Models\Category', 'get_category_id');
    }

    public function getOfferPriceWithoutTaxAttribute()
    {
        if (!$this->offer_price) {
            return null;
        }
        return round($this->offer_price / 1.15);
    }

}
