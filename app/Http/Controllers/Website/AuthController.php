<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\activateSMS;
use App\Notifications\SignupActivate;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client;

class AuthController extends Controller
{
    use GeneralTrait;

    public function get_login()
    {
        return view('website.login');
    }

    public function get_sign_up()
    {

        return view('website.signup');
    }

    public function sign_up(Request $request)
    {
        // return $request;

        //    return $validator = Validator::make($request->all(), );
        //     //, 'unique:users,first_phone'
        //     if ($validator->fails()) {
        //         return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        //     }

        $message = str_replace('characters', 'numbers', __('validation.size.string'));
        if (app()->getLocale() === 'ar') {
            $message = preg_replace("/حروفٍ\/حرفًا/", "رقماُ", __('validation.size.string'));
        }

        $req = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['required', 'string', 'max:10', 'unique:users,first_phone']
        ], [
            'size' => [
                'string' => $message,
            ]
        ]);
        try {
            $name = explode(" ", $request->name);
            if (count($name) < 2) {
                return redirect()->back()->withErrors(['errors' => __('auth.last_name_not_included')])->withInput();
            }

            // DB::beginTransaction();

            $request->merge([
                'first_name' => $name[0],
                'last_name' => $name[1],
                'password' => bcrypt($request->password),
                'first_phone' => '966' . $request->phone,
                'age' => $request->age,
                'activation_token' => mt_rand(100000, 999999)
            ]);

            $user = User::create($request->all());
            $user->attachRole(3);

            $user->token = $user->createToken('AppName')->accessToken;
            $user->email_verified_at = now();
            $user->active = true;
            $user->save();

            auth('web')->login($user);

            return redirect()->route('home.page');

            // Mail::to($user->email)->send();
            // try {
            //     // $user->notify(new SignupActivate);
            // } catch (\Exception $e) {
            // }

            try {
                $this->sendMessage(
                    $user->first_phone,
                    "KOP\nThanks for signup!\n Please before you begin, you must confirm your account. Your Code is:" . $user->activation_token . "\n\n شكرا على تسجيلك! من فضلك قبل أن تبدأ ، يجب عليك تأكيد حسابك. رمزك هو:" . $user->activation_token
                );
                // return redirect()->back()->with(['success'=>__('auth.Sent SMS successfully.')]);
            } catch (\Exception $e) {
                // DB::rollBack();
                // dd($e->getMessage());

                // return redirect()->back()->withErrors(['errors' => __('auth.phone_number_error')]);
            }

            // session(['user' => [
            //     'email' => $user->email,
            //     'phone' => $user->first_phone,
            //     'id' => $user->id
            // ]]);

            // session()->flash('success', __('general.user_updated'));

            // return redirect()->route('home.page');

            // return redirect(route('verifyCode.page'))->with(['success' => __('general.created', ['key' => __('auth.user_account')]), 'email' => $user->email]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => __('general.error')]);
        }
        // DB::commit();
    }

    public function login(Request $request)
    {
        $validation_rules = [
            'email' => 'required',
            'password' => 'required'
        ];
        $validatedData = $request->validate($validation_rules);


        $credentials = [
            'email' => request('email'),
            'password' => request('password')
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->status) {
                if ($user->email_verified_at == null) {
                    // return $user->id;
                    $phone = $user->first_phone;
                    $user_id = $user->id;
                    $password = request('password');
                    auth()->logout();
                    session()->flush();
                    $this->sendMessage(
                        $user->first_phone,
                        "KOP\nThanks for signup!\n Please before you begin, you must confirm your account. Your Code is:" . $user->activation_token . "\n\n شكرا على تسجيلك! من فضلك قبل أن تبدأ ، يجب عليك تأكيد حسابك. رمزك هو:" . $user->activation_token
                    );

                    session(['user' => [
                        'email' => $user->email,
                        'phone' => $user->first_phone,
                        'id' => $user->id
                    ]]);

                    session()->flash('error', __('auth.verify'));

                    return redirect()->route('verifyCode.page');
                }

                auth()->user()->carts()->delete();


                $user->branches; //??                    
                return redirect()->route('home.page');
            } else {
                auth()->logout();
                session()->flush();
            }
        }
        return redirect()->back()->with(['error' => __('session_messages.Unauthorized! Please Check Your Credentials')]);
    }

    public function logout()
    {
        auth()->user()->carts()->delete();
        auth()->logout();
        session()->flush();
        return redirect()->route('home.page');
    }

    /* for verification */
    public function get_code()
    {
        return view('website.verification-code');
    }

    public function setVerificationCode(Request $request)
    {
        $user = User::where('id', $request->user_id)->where('first_phone', $request->phone)->first();

        abort_unless($user, 404);

        if ($user->activation_token !== $request->token) {
            session()->flash('error', __('auth.invalid_otp'));
            return redirect()->back();
        }

        $user->token = $user->createToken('AppName')->accessToken;

        $user->email_verified_at = now();
        $user->active = true;
        $user->save();

        session()->forget('user');

        $user->branches; //?? 

        Auth::login($user);

        return redirect()->route('home.page');
    }

    public function resendVerificationCode(Request $request)
    {
        $user = User::where('id', $request->user_id)->where('first_phone', $request->phone)->first();

        abort_unless($user, 404);

        try {
            // $user->notify(new SignupActivate);

            $this->sendMessage(
                $user->first_phone,
                "KOP\nThanks for signup!\n Please before you begin, you must confirm your account. Your Code is:" . $user->activation_token . "\n\n شكرا على تسجيلك! من فضلك قبل أن تبدأ ، يجب عليك تأكيد حسابك. رمزك هو:" . $user->activation_token
            );
            return redirect()->back()->with(['success' => __('auth.Sent SMS successfully.')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('auth.Try again later.')]);


            //echo "Error: " . $e->getMessage();
        }
    }
}
