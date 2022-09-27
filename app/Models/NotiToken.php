<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotiToken extends Model
{
    /** @const FCM_URL string */
    const FCM_URL = 'https://fcm.googleapis.com/fcm/send';
    /** @const FCM_AUTH_KEY string */
    const FCM_AUTH_KEY = 'AIzaSyD7P_2ebS_75Ipug4RKuWUh30O8SVVqHLg';
    protected $fillable = ['user_id', 'platform', 'token'];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
