<?php

namespace App\Models;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;
    protected $table = 'payments';
    protected $fillable = [
        'id',
        'status',
        'message',
        'payment_id',
        'customer_id',
        'order_id',
        'total_paid',
        'data',
        'hash',
    ];
    public $timestamps = true;

    protected $hidden = ['data', 'hash'];

    public function order()
    {
        $this->belongsTo(Order::class, 'order_id');
    }

    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }
}
