<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\NotificationController;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\PointsTransaction;

use App\Notifications\SignupActivate;
use App\Notifications\activateSMS;
use App\Traits\GeneralTrait;

class AuthController extends BaseController
{
    //website
    //
    //

    use GeneralTrait;

    public function login(Request $request)
    {

        $credentials = [
            'email' => request('email'),
            'password' => request('password')
        ];
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->hasRole('customer')) {
                if ($user->email_verified_at == null) {
                    $data = [
                        'userData' => $user,
                        // 'token' => $user->createToken('AppName')->accessToken,
                        'token' => null,
                    ];
                    auth()->logout();

                    $this->sendMessage(
                        $user->first_phone,
                        "KOP\nThanks for signup!\n Please before you begin, you must confirm your account. Your Code is:" . $user->activation_token . "\n\n شكرا على تسجيلك! من فضلك قبل أن تبدأ ، يجب عليك تأكيد حسابك. رمزك هو:" . $user->activation_token
                    );

                    return $this->sendResponse($data, __('auth.verify'));
                }

                if ($request->has('device_token')) {
                    $user->device_token = $request->device_token;
                    $user->save();
                }

                $user->branches; //??

                $data = [
                    'userData' => $user,
                    // 'token' => $user->createToken('AppName')->accessToken,
                    'token' => $user->token,
                ];

                $setPushToken = new NotificationController();
                $request->request->add(['user_id' => $user->id]);
                $setPushToken->setPushToken($request);
                return $this->sendResponse($data, __('auth.logged'));
            }
        }

        return $this->sendError(__('auth.unauthorised!'), $credentials, 401);
    }

    public function loginCashier(Request $request)
    {

        $credentials = [
            'email' => request('email'),
            'password' => request('password')
        ];
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->hasRole('cashier')) {
                if ($user->email_verified_at == null) {
                    auth()->logout();
                    $data = [
                        'userData' => $user,
                        // 'token' => $user->createToken('AppName')->accessToken,
                        'token' => null,
                    ];
                    return $this->sendResponse($data, __('auth.verify'));
                }


                if ($request->has('device_token')) {
                    $user->device_token = $request->device_token;
                    $user->save();
                }
                $user->branches;


                $setPushToken = new NotificationController();
                $request->request->add(['user_id' => $user->id]);
                $setPushToken->setPushToken($request);

                $data = [
                    'userData' => $user,
                    // 'token' => $user->createToken('AppName')->accessToken,
                    'token' => $user->token,
                ];

                return $this->sendResponse($data, __('auth.logged'));
            }
        }
        return $this->sendError(__('auth.unauthorised'), $credentials, 401);
    }

    public function register(Request $request)
    {
        $message = str_replace('characters', 'numbers', __('validation.size.string'));
        if (app()->getLocale() === 'ar') {
            $message = preg_replace("/حروفٍ\/حرفًا/", "رقماُ", __('validation.size.string'));
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['required', 'string', 'size:12', 'unique:users,first_phone']
        ], [
            'size' => [
                'string' => $message,
            ]
        ]);
        //, 'unique:users,first_phone'
        if ($validator->fails()) {
            return response()->json(
                [
                    "success" => false,
                    'error' => $validator->errors(),
                ],
                401
            );
        }

        // DB::beginTransaction();

        $name = explode(" ", $request->name);
        if (count($name) < 2) {

            return response()->json([
                "success" => false,
                "message" => __('auth.last_name_not_included'),
            ], 400);
        }

        $request->merge([
            'first_name' => $name[0],
            'last_name' => $name[1],
            'password' => bcrypt($request->password),
            'first_phone' => $request->phone,
            'age' => $request->age,
            'activation_token' => mt_rand(100000, 999999)
        ]);

        if($request->token)
        {
            $request->merge([
                'device_token' =>$request->token
            ]);
        }

        $user = User::create($request->all());
        $user->attachRole(3); // customer

        // Auth::login($user);

        // $token = $user->createToken('AppName')->accessToken;

        $setPushToken = new NotificationController();
        $request->request->add(['user_id' => $user->id]);
        $setPushToken->setPushToken($request);

        $this->sendMessage(
            $user->first_phone,
            "KOP\nThanks for signup!\n Please before you begin, you must confirm your account. Your Code is:" . $user->activation_token . "\n\n شكرا على تسجيلك! من فضلك قبل أن تبدأ ، يجب عليك تأكيد حسابك. رمزك هو:" . $user->activation_token
        );

        return response()->json([
            "success" => true,
            'user_created' => true,
            'user' => $user->fresh(),
            // 'data' => $user,
            'token' => null,
            'message_sent' => true,
            "message" => __('general.created', ['key' => __('auth.user_account')]),
        ], 200);

        // try {
        //     // send mail to user
        //     // $user->notify(new SignupActivate);

        //     $this->sendMessage(
        //         $user->first_phone,
        //         "KOP\nThanks for signup!\n Please before you begin, you must confirm your account. Your Code is:" . $user->activation_token . "\n\n شكرا على التسجيل! من فضلك قبل أن تبدأ ، يجب عليك تأكيد حسابك. رمزك هو:" . $user->activation_token
        //     );

        //     // return $this->sendResponse($user, 'Successfully created user!');
        //     $pushNotifications=new NotificationController();
        //     $request->request->add(['user_id' =>$user->id]);
        //     $pushNotifications->pushNotifications($request);
        //     return response()->json([
        //         "success" => true,
        //         'user_created' => true,
        //         'user' => $user,
        //         'data' => $user,
        //         'token' => $token,
        //         'message_sent'=> true,
        //         "message" => __('general.created', ['key' => __('auth.user_account')]),
        //     ], 200);

        //     //            return $this->sendResponse($user, 'Successfully created user!');

        // } catch (\Exception $e) {
        //     // DB::rollBack();

        //     return response()->json([
        //         "success" => true,
        //         'user_created' => true,
        //         'user' => $user,
        //         'token' => $token,
        //         'message_sent'=> false,
        //         "message" => __('auth.twillo_err')
        //     ], 200);

        //     //echo "Error: " . $e->getMessage();
        // }

        // DB::commit();


        // $user->notify(new SignupActivate($user));

        // // Temprorary
        // $user->notify(new activateSMS($user));

        // $message = $user->activation_token;
        // $sms = AWS::createClient('sns');
        // $message = "Thanks for signup! Please before you begin, you must confirm your account. Your Code is: " . $user->activation_token;
        // $number = "+2" . $user->first_phone;
        // $x = $sms->publish([
        //     'Message' => $message,
        //     'PhoneNumber' => $number,
        //     'MessageAttributes' => [
        //         'AWS.SNS.SMS.SMSType'  => [
        //             'DataType'    => 'String',
        //             'StringValue' => 'Transactional',
        //         ]
        //     ],
        // ]);
        // temp

        //test twilio


        // $client = new Client($accountSid, $authToken);
        // try {
        //     // Use the client to do fun stuff like send text messages!
        //     $client->messages->create(
        //         // the number you'd like to send the message to
        //         $user->first_phone,
        //         array(
        //             // A Twilio phone number you purchased at twilio.com/console
        //             'from' => '+16196584381',
        //             // the body of the text message you'd like to send
        //             'body' => 'KOP:Thanks for signup! Please before you begin, you must confirm your account. Your Code is:' . $user->activation_token,
        //         )
        //     );
        //     return $this->sendResponse($user, 'Successfully created user!');
        // } catch (\Exception $e) {
        //     return response()->json([
        //         "success" => false,
        //         "message" => __('auth.twillo_err')
        //     ], 400);

        //echo "Error: " . $e->getMessage();
        // }
        //end test Twillo


    }
    /* for verification */
    public function setVerificationCode(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        if ($user->activation_token !== $request->otp) {
            return $this->sendError(__('auth.invalid_otp'));
        }

        $user->token = $user->createToken('AppName')->accessToken;
        $user->active = true;
        $user->email_verified_at = now();
        $user->save();

        Auth::login($user);

        return $this->sendResponse([
            'userData' => $user,
            'token' => $user->token,
        ], __('auth.verified'));
    }

    public function resendVerificationCode(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        try {
            $this->sendMessage(
                $user->first_phone,
                "KOP\nThanks for signup!\n Please before you begin, you must confirm your account. Your Code is:" . $user->activation_token . "\n\n شكرا على تسجيلك! من فضلك قبل أن تبدأ ، يجب عليك تأكيد حسابك. رمزك هو:" . $user->activation_token
            );
            return $this->sendResponse($user, __('auth.sent_sms'));
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => __('auth.twillo_err')
            ], 400);
            //echo "Error: " . $e->getMessage();
        }
    }


    public function logout(Request $request)
    {
        // $request->user()->token()->revoke();
        auth()->logout();
        return $this->sendResponse(null, __('auth.logged_out'));
    }

    public function getUser(Request $request)
    {
        return $this->sendResponse($request->user(), 'User data retrieved Successfully');
    }


    public function resendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id']
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }


        $user = User::find($request->user_id);

        if ($user->activation_token == '') {
            return $this->sendError(__('auth.activated'), 400);
        }

        // $user->notify(new SignupActivate($user));
        // wael remove comment
        $user->notify(new activateSMS($user));

        return $this->sendResponse($user, __('auth.code_resent'));
    }

    public function getUserPoints(Request $request)
    {
        // 0 --> order completed
        // 1 --> order canceled
        // 3 --> order rejected
        // 4 --> order canceled
        $validRefundedPoints = Auth::user()->points_transactions()->whereIn('status', [0])->get()->sum('points');
        $consumedCanceledPoints = Auth::user()->points_transactions()->whereIn('status', [2])->get()->sum('points');
        $completed = Order::where('state', 'completed')->where('customer_id', Auth::id())->sum('points');
        $consumedCanceledPoints += (double) $completed;
        try {
            $data = [
                //'user_points' => Auth::user()->points_transactions()->whereIn('status', [0, 2])->get()->sum('points'),
                'user_points' => $validRefundedPoints - $consumedCanceledPoints,
                'points_value' => DB::table('general')->where('key', 'pointsValue')->first()->value
            ];
        } catch (\Exception $ex) {
            $data = [
                'user_points' => $validRefundedPoints - $consumedCanceledPoints,
                'points_value' => 0
            ];
        }


        return $this->sendResponse($data, 'Points Retrieved Successfully');
    }

    public function changeUserPoints(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'points' => ['required', 'numeric']
        ]);

        $validRefundedPoints = Auth::user()->points_transactions()->whereIn('status', [0, 3, 4])->get()->sum('points');
        $consumedCanceledPoints = Auth::user()->points_transactions()->whereIn('status', [2])->get()->sum('points');
        $userPoints = $validRefundedPoints - $consumedCanceledPoints;

        if ($request->points > $userPoints) {
            return response()->json(['error' => __('validation.lte.numeric', [
                'attribute' => __('auth.points'),
                'value' => $request->points
            ])], 400);
        }

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $transaction = PointsTransaction::create([
            'points' => $request->points,
            'user_id' => Auth::user()->id,
            'status' => 2
        ]);
        return $this->sendResponse($transaction, __('auth.points_success'));
    }

    public function updateUser(Request $request)
    {

        $message = str_replace('characters', 'numbers', __('validation.size.string'));
        if (app()->getLocale() === 'ar') {
            $message = preg_replace("/حروفٍ\/حرفًا/", "رقماُ", __('validation.size.string'));
        }
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::user()->id],
            'password' => ['string', 'min:8'],
            'phone' => ['required', 'string', 'size:12', 'unique:users,first_phone,' . Auth::user()->id],
            'image' => 'image|max:5000'
        ], [
            'size' => [
                'string' => $message,
            ]
        ]);
        $request->merge(['first_phone' => $request->phone]);
        if ($request->password) {
            $request->merge(['password' => bcrypt($request->password)]);
        }
        if ($request->user()) {
            $user = $request->user();
        } else {
            if (auth('web')->user()) {
                $user = auth()->user();
            }
        }
        $user = $user->update($request->except(['image']));

        if ($request->hasFile('image')) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move(public_path('users'), $image_new_name);
            $user->image = '/users/' . $image_new_name;
            $user->save();
        }

        return $this->sendResponse($user, __('general.updated', ['key' => __('auth.user_account')]));
    }
    public function setFirstOfferFlag(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_offer_available' => ['required']
        ]);


        $user = $request->user();

        $user = $user->update($request->all());
        return $this->sendResponse($user, __('general.updated', ['key' => __('auth.user_account')]));
    }

    public function signupActivate($token)
    {
        $user = User::where('activation_token', $token)->first();

        if (!$user) {
            return $this->sendError(__('auth.invalid_otp'));
        }

        $user->active = true;
        $user->activation_token = '';
        $user->save();

        $user = Auth::loginUsingId($user->id, true);

        $data = [
            'userData' => $user,
            'token' => $user->createToken('AppName')->accessToken
        ];

        return $this->sendResponse($data, __('auth.logged'));
    }

    public function LoginWithGoogle(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user.id' => 'required',
            'user.givenName' => 'required',
            'user.familyName' => 'required',
            'user.email' => 'required|email',
        ]);

        if ($validator->fails())
            return $this->sendError("Validation errors", $validator->errors());

        $user_id = DB::table('third_party_user_ids')->where('google_user_id', $request->user['id'])->pluck('user_id')->first();

        if (!$user_id) {

            $user = User::where('email', $request->user['email'])->first();

            if (!$user) {
                $user = User::updateOrCreate([
                    'first_name' => $request->user['givenName'],
                    'last_name' => $request->user['familyName'],
                    'name' => $request->user['name'],
                    'email' => $request->user['email'],
                    'password' => '',
                    'image' => $request->user['photo'],
                    'activation_token' => mt_rand(100000, 999999),
                    'active' => 1
                ]);
                $user->attachRole(3);
            }

            DB::table('third_party_user_ids')->insert([
                'user_id' => $user->id,
                'google_user_id' => $request->user['id']
            ]);

            Auth::login($user, true);

            $data = [
                'userData' => $user,
                'token' => $user->createToken('AppName')->accessToken
            ];


            return $this->sendResponse($data, "User logged in successfully");
        }

        $user = Auth::loginUsingId($user_id, true);
        $data = [
            'userData' => $user,
            'token' => $user->createToken('AppName')->accessToken
        ];

        return $this->sendResponse($data, "User Loged in successfully");
    }


    public function loginWithFacebook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
        ]);

        if ($validator->fails())
            return $this->sendError("Validation errors", $validator->errors());

        $user_id = DB::table('third_party_user_ids')->where('facebook_user_id', $request->id)->pluck('user_id')->first();

        if (!$user_id) {

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                $user = User::updateOrCreate([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => '',
                    'activation_token' => mt_rand(100000, 999999),
                    'active' => 1
                ]);
                $user->attachRole(3);
            }

            DB::table('third_party_user_ids')->insert([
                'user_id' => $user->id,
                'facebook_user_id' => $request->id
            ]);

            Auth::login($user, true);

            $data = [
                'userData' => $user,
                'token' => $user->createToken('AppName')->accessToken
            ];

            return $this->sendResponse($data, "User logged in successfully");
        }

        $user = Auth::loginUsingId($user_id, true);
        $data = [
            'userData' => $user,
            'token' => $user->createToken('AppName')->accessToken
        ];

        return $this->sendResponse($data, "User Loged in successfully");
    }

    public function getUnAuth()
    {
        return response()->json([
            'message' => __('auth.unauthenticated'),
        ]);
    }

    public function activateUser(Request $request, $id)
    {
        // dd($request->all());
        // $req = (object) $request->validate([
        //     'verified' => 'required|boolean',
        // ]);

        $user = User::find($id);

        if (!$user) {
            return $this->sendError(
                __('auth.no_id'),
            );
        }
        $user->email_verified_at = now();
        $user->token = $user->createToken('AppName')->accessToken;
        // $user->save();

        // Auth::login($user);

        // return $this->sendResponse([
        //     'userData' => $user,
        //     'token' => $user->token,
        // ], __('auth.verified'));


        return $this->sendError([
            // 'user_verified' => false,
            'token' => null,
        ], [], 403);
    }
}
