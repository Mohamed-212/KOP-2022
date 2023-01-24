<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    protected $fillable = [
        'customer_id',
        'branch_id',
        'service_type',
        'subtotal',
        'taxes',
        'delivery_fees',
        'total',
        'state',
        'cancellation_reason',
        'created_by',
        'updated_by',
        'address_id',
        'points_paid',
        'offer_type',
        'offer_value',
        'order_from',
        'points',
        'description_box',
        'payment_type',
        'is_first_order',
        'first_order_status',
        'total_before_discount'
    ];

    protected $casts = [
        'is_first_order' => 'boolean',
        // 'first_order_status' => 'boolean',
        'delivery_fees' => 'double'
    ];

    // public $appends = [
    //     'payment_type',
    // ];

    public $hidden = [
        'first_order_status'
    ];

    // public function getPaymentTypeAttribute()
    // {
    //     return Payment::where('order_id', $this->id)->exists() ? 'online' : 'cash';
    // }

    public function customer()
    {
        return $this->belongsTo('App\Models\User', 'customer_id');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch')->withTrashed();
    }

    public function address()
    {
        return $this->belongsTo('App\Models\Address','address_id')->withTrashed();
    }

    public function items()
    {
        return $this->belongsToMany('App\Models\Item', 'order_item')
            ->withPivot(['order_id', 'item_extras', 'item_withouts', 'dough_type_ar', 'dough_type_en', 'price', 'offer_price', 'quantity', 'offer_id']);
    }

    public function countOfItems()
    {
        return $this->items->count();
    }

    public function countOfExtras()
    {
        return $this->items->count();
    }

    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }
}
