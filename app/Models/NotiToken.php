<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotiToken extends Model
{
    /** @const FCM_URL string */
    const FCM_URL = 'https://fcm.googleapis.com/fcm/send';
    /** @const FCM_AUTH_KEY string */
    const FCM_AUTH_KEY = 'AAAAL-i2Lz0:APA91bG80IvTG2ggBe4kaOKfRnRWx-dskewqFrapJn3i6p4z6OGk1SZZWlyFu4ymsGxaaL7CFZdabV-d5uAYRhx5VjBqnXL58_ETlyEPk-iYomLO2xmncz-5Ebb2EJT7QoG5UobDpOXw';
    protected $fillable = ['user_id', 'platform', 'token'];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
