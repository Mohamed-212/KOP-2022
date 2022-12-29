<?php

namespace App\Models;

use App\Models\Extra;
use Illuminate\Database\Eloquent\Model;
use App\Models\Without;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'item_id',
        'extras',
        'withouts',
        'dough_type_ar',
        'dough_type_en',
        'dough_type_2_ar',
        'dough_type_2_en',
        'quantity',
        'offer_id',
        'offer_price'
    ];

    public $appends = [
        'extras_objects',
        'withouts_objects',
        'price',
    ];

    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }

    public function getExtrasObjectsAttribute()
    {
        if (in_array('extras', $this->attributes) && is_array($this->attributes['extras'])) {
            return $this->attributes['extras'];
        }

        $objects = [];
        //return $objects= json_decode($this->attributes['extras']);
        if (isset($this->attributes['extras']) && $this->attributes['extras'] != 'null' && is_string($this->attributes['extras'])) {
            $ex = json_decode($this->attributes['extras']);
            if (is_iterable($ex)) {
                foreach ($ex as $extra) {
                    $extra = Extra::find($extra);
                    if ($extra) $objects[] = $extra;
                }
            }
        }

        return $objects;
    }

    public function getWithoutsObjectsAttribute()
    {
        if (in_array('withouts', $this->attributes) && is_array($this->attributes['withouts'])) {
            return $this->attributes['withouts'];
        }

        $objects = [];
        //return $objects = json_decode($this->attributes['withouts']);
        if (isset($this->attributes['withouts']) && $this->attributes['withouts'] != 'null' && is_string($this->attributes['withouts'])) {
            $ex = json_decode($this->attributes['withouts']);
            if (is_iterable($ex)) {
                foreach ($ex as $without) {
                    $without = Without::find($without);
                    if ($without) $objects[] = $without;
                }
            }
        }

        return $objects;
    }

    public function getPriceAttribute()
    {
        $itemPrice = $this->offer_id ? $this->offer_price : 0;
        if (isset($this->item)) {
            $itemPrice = $this->offer_id ? $this->offer_price : $this->item->price;
        }

        if (isset($this->extras_objects)) {
            return $itemPrice + collect($this->extras_objects)->sum('price');
        }

        return $itemPrice;
    }
}
