<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\Traits\GeneralTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client;

class PasswordResetController extends Controller
{
    use GeneralTrait;

    public function index()
    {
        return view('website.password-reset');
    }

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), ['email' => 'required|string|email']);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if (!$user)
            return redirect()->back()->with(['error' => __('general.We can\'t find a user with that e-mail address.')])->withInput();

        $data = [
            'email' => $user->email,
            'token' => mt_rand(100000, 999999)
        ];

        $passwordReset = DB::table('password_resets')->updateOrInsert($data);

        if ($user && $passwordReset) {
            // try {
            //     $this->sendMessage(
            //         $user->first_phone,
            //         "KOP\nThanks for signup!\n Please before you begin, you must confirm your account. Your Code is:" . $data['token'] . "\n\n شكرا على التسجيل! من فضلك قبل أن تبدأ ، يجب عليك تأكيد حسابك. رمزك هو:" . $data['token']
            //     );
            // } catch (\Exception $e) {
            //      return redirect()->back()->with(['error' => __('general.Something Went Wrong')])->withInput();
            // }

            $user->notify(new PasswordResetRequest($data['token']));
            return redirect(route('get.login'))->with(['success' => __('general.We have e-mailed your password reset link!')])->withInput();
        }
        return redirect()->back()->with(['error' => __('general.You are not a user')])->withInput();
    }

    public function get_code()
    {
        return view('website.password-get-code')->with(['success' => __('general.We have e-mailed your password reset Code!')]);
    }

    public function find(Request $request)
    {
        $token = $request->token;
        $passwordReset = DB::table('password_resets')->where('token', $token)->first();

        if (!$passwordReset)
            return redirect(route('get.code'))->with(['error' => __('general.This password reset token is invalid.')])->withInput();

        if (Carbon::parse($passwordReset->created_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return redirect()->back()->with(['error' => __('general.This password reset token is invalid.')])->withInput();
        }

        $email = $passwordReset->email;

        return view('website.change-password', compact('email', 'token'));
    }

    public function reset(Request $request)
    {

        $passwordReset = DB::table('password_resets')->where([['token', $request->token], ['email', $request->email]])->first();
        if (!$passwordReset) {
            // dd('sdg');
            return redirect()->back()->with(['error' => __('general.This password reset token is invalid.')]);
        }

        $user = User::where('email', $passwordReset->email)->first();

        if (!$user) {

            return redirect()->back()->with(['error' => __('general.You are not a user')])->withInput();
        }
        $user->update(['password' => bcrypt($request->password)]);

        DB::table('password_resets')->where([['token', $request->token], ['email', $request->email]])->delete();

        //        $user->notify(new PasswordResetSuccess($passwordReset));
        return redirect(route('get.login'))->with(['success' => __('general.Your Password Changed Successfully')]);
    }
}
