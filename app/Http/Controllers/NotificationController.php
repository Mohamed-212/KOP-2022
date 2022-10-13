<?php
/**
 * To Add New Notification
 *      1- execute "php artisan make:notification NotificationName" and stylize the toDatabase function with the data you need
 *      2- add the notification key to @self::parseNotificationView the and
 *      3- add the notification view to the views.notifications and render the single notification of this type.
 */


namespace App\Http\Controllers;

use Auth;
use App\Models\NotiToken;
use App\Models\User;
use App\Models\NotificationLog;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class NotificationController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    
    public function __construct () {
        parent::__construct();
    }

    /**
     * Push notifications to all users devices
     * @return void
     */
    public static function pushNotifications($user_id, $message, $type = "Notification", $data_message = null, $chat_id = null, $customer_id = null)
    {
        $tokens = NotiToken::where('user_id',$user_id)->get()->unique('token');
        $user = User::find($user_id);
        if ($user) {
            foreach($tokens as $token) {
                self::pushSingleNotification($token->token, $message, $type, $data_message, $chat_id, true, $user_id, $customer_id);
            }
        }
    }
    
    /**
     * Push notifications to specific token
     * @return void
     */
    public static function pushSingleNotification($token, $message, $type = "Notification", $data_message = null, $chat_id = null, $notification_sound = 1, $cashier_id, $customer_id = null)
    {

        // $response = $client->send($notification);
            $notification_sound = $notification_sound? true : false;
                
            /* Send notification */
            $fcmUrl = NotiToken::FCM_URL;
            $notification = [
                'body' => $message,
                'sound' => $notification_sound,
            ];
        
            $data = [
                'type' => $type, // Message / Notification.
                'message' => $data_message, //To display into the chat directly.
                'chat_id' => $chat_id
            ];
        
            $fcmNotification = [
                'to'        => $token,
                'notification' => $notification,
                'data'      => $data
            ];

            $headers = [
                'Authorization: key=' . NotiToken::FCM_AUTH_KEY,
                'Content-Type: application/json'
            ];
            
            NotificationLog::create([
                'user_id' => $cashier_id,
                'chat_id' => $chat_id,
                'body' => $message,
                'data' => $data_message,
                'type' => $type,
                'customer_id' => $customer_id,
            ]);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$fcmUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
            $result = curl_exec($ch);
            file_put_contents("test.txt", $result);
        
            curl_close($ch);
    }
    
    public static function pushAllNotification($message, $type = "Notification", $data_message = null, $chat_id = null, $customer_id = null)
    {
            $tokens = User::join('noti_tokens','noti_tokens.user_id','users.id')->whereHas('roles', function ($role) {
                $role->where('name', 'customer')->orWhere('name', 'cashier');
            })->get();
                foreach($tokens as $token) {
                    self::pushSingleNotification($token->token, $message, $type, $data_message, $chat_id, true, auth()->id(),$token->user_id);
                }
    }
    
}