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
            'phone' => ['required', 'string', 'size:12', 'unique:users,first_phone']
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
                'first_phone' => $request->phone,
                'age' => $request->age,
                'activation_token' => mt_rand(100000, 999999)
            ]);

            $user = User::create($request->all());
            $user->attachRole(3);

            // Mail::to($user->email)->send();
            try {
                // $user->notify(new SignupActivate);
            } catch (\Exception $e) {

            }

            try {
                $this->sendMessage(
                    $user->first_phone,
                    "KOP\nThanks for signup!\n Please before you begin, you must confirm your account. Your Code is:" . $user->activation_token . "\n\n شكرا على التسجيل! من فضلك قبل أن تبدأ ، يجب عليك تأكيد حسابك. رمزك هو:" . $user->activation_token
                );
                // return redirect()->back()->with(['success'=>__('auth.Sent SMS successfully.')]);
            } catch (\Exception $e) {
                // DB::rollBack();
                // dd($e->getMessage());

                // return redirect()->back()->withErrors(['errors' => __('auth.phone_number_error')]);
            }

            return redirect(route('get.login'))->with(['success' => __('general.created', ['key' => __('auth.user_account')]), 'email' => $user->email]);
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

        $user=User::where('email',request('email'))->first();
        if($user){
        // if ($user->hasRole('customer')) {
            if ($user->email_verified_at == null) {
                // return $user->id;
                $phone=$user->first_phone;
                $user_id=$user->id;
                $password=request('password');
                        return view('website.verification-code',compact('phone','user_id','password'));
                    }
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                    $user->branches; //??                    
                    return redirect()->route('home.page');
                }
            }
        // }
        return redirect()->back()->with(['error' => __('session_messages.Unauthorized! Please Check Your Credentials')]);
    }

    public function logout()
    {
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
        $validator = Validator::make($request->all(), [
            'verify' => 'required',
            'user_id' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            redirect()->back()->with([
                'error' => $validator->errors()
            ]);
        }
        
        $user=User::find($request->user_id);

     
        $user->email_verified_at = now();
        $user->save();

        $credentials = [
            'email' => $user->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
                $user->branches; //??                    
                return redirect()->route('home.page');
            }

            return redirect()->back()->withErrors(['errors' => __('general.error')]);
    }

    public function resendVerificationCode()
    {        
        try {
            // auth()->user()->notify(new SignupActivate);
            
            $this->sendMessage(
                auth()->user()->first_phone,
                "KOP\nThanks for signup!\n Please before you begin, you must confirm your account. Your Code is:" . auth()->user()->activation_token . "\n\n شكرا على التسجيل! من فضلك قبل أن تبدأ ، يجب عليك تأكيد حسابك. رمزك هو:" . auth()->user()->activation_token
            );
            return redirect()->back()->with(['success' => __('auth.Sent SMS successfully.')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('auth.Try again later.')]);


            //echo "Error: " . $e->getMessage();
        }
    }
}
