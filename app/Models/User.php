<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens, EntrustUserTrait;

    protected $dates = ['created_at', 'deleted_at'];

    protected $fillable = [
        'name',
        'first_name',
        'middle_name',
        'last_name',
        'first_phone',
        'second_phone',
        'email',
        'age',
        'password',
        'active',
        'activation_token',
        'device_token',
        'first_offer_available',
        'image',
        'token',
        'status',
        'cancellation_reason',
        'reason_id'
    ];

    protected $hidden = [
        'password', 'remember_token', 'activation_token', 'token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'status' => 'boolean'
    ];

    public function createdBy()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function updatedBy()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\Address', 'customer_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'customer_id', 'id');
    }

    // NOT USED
    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function carts()
    {
        return $this->hasMany('App\Models\Cart');
    }

    public function points_transactions()
    {
        return $this->hasMany('App\Models\PointsTransaction');
    }

    public function gifts_orders()
    {
        return $this->hasMany('App\Models\GiftsOrder');
    }

    public function branches()
    {
        return $this->belongsToMany('App\Models\Branch', 'branch_user');
    }

    public function contacts()
    {
        return $this->hasMany('App\Models\Contact');
    }

    public function getImageAttribute($value)
    {
        if (!empty($value) && file_exists(public_path($value))) {
            return url($value);
        } else {
            return 'http://via.placeholder.com/200x200?text=No+Image';
        }
    }


    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }


    public function routeNotificationForPlivo()
    {
        // Country code, area code and number without symbols or spaces

        //if (strlen($this->first_phone) == 9) {
        //    return "+966$this->first_phone";
        //} else {
        //    return $this->first_phone
        //}

        // return "+201143688608";

        //return "+201027226644";
        return "+201018618608";

        // return preg_replace('/\D+/', '', $this->first_phone);
    }

    /**
     * define favourite items relationship
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favourites(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'favourite_item');
    }

    /**
     * add an item to favourites
     *
     * @param Item $item
     * @return void
     */
    public function addToFavourites(Item $item)
    {
        $this->favourites()->attach($item);
    }

    /**
     * remove an item from favourites
     *
     * @param Item $item
     * @return void
     */
    public function removeFromFavourites(Item $item)
    {
        $this->favourites()->detach($item);
    }

    /**
     * clear all favourites
     *
     * @return integer number for removed favourites
     */
    public function clearFavourites(): int
    {
        return DB::table('favourite_item')->where('user_id', '=', $this->id)->delete();
    }

    /**
     * count all orders that has not been cancel or rejected
     *
     * @return boolean
     */
    public function hasNoOrders(): bool
    {
        return $this->orders()->count() == 0;
    }
}
