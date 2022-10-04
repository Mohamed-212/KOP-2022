<?php

namespace App\Http\Controllers\Api;

use App\Models\NotificationLog;
use App\Models\Messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetNotificationLogs extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $logs = NotificationLog::where('user_id', auth()->id());

        if (auth()->user()->hasRole('cashier')) {
            $logs = $logs->where('customer_id', '!=', null)->with('customer');
        }

        $logs = $logs->orderBy('created_at', 'desc')->get();

        return $this->sendResponse($logs, __('general.ret', ['key' => __('general.logs')]));
    }

    public function getAllNotification(Request $request)
    {
        $notifications=Messages::with('user')->orderBy('created_at', 'desc')->get();
        return $this->sendResponse($notifications, __('general.ret', ['key' => __('general.logs')]));
    }
}
