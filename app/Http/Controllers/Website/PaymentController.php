<?php

namespace App\Http\Controllers\Website;


use App\Models\Payment;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Moyasar\Providers\PaymentService;

class PaymentController extends Controller
{


    public function index(Request $request)
    {
        abort_unless(session()->has('checkOut_details'), 404);

        $user = auth()->user();
        $amount = session()->has('checkOut_details') ? session('checkOut_details')['total'] : 0;

        if (session()->has('checkOut_details')) {
            $details = session('checkOut_details');
            $details['description'] = $request->description;
            session(['checkOut_details' => $details]);
        }

        return view('website.payment', compact('user', 'amount'));
    }

    public function get_payment(Request $request)
    {

        $validator_rules = [
            'source.name' => 'required',
            'source.cvc' => 'required|max:4|min:3',
            'source.number' => 'required|digits:16',
            'source.month' => 'required|in:01,02,03,04,05,06,07,08,09,10,11,12',
            'source.year' => 'required|digits:4|integer|min:' . (date('Y')),
        ];
        $validator_rules_messages = [
            'source.name.required' => 'The name is required',
            'source.cvc.required' => 'The cvc is required',
            'source.cvc.max' => 'The cvc is too long max is 4 numbers',
            'source.cvc.min' => 'The cvc is too short min is 3 numbers',
            'source.number.digits' => 'The cart number must be 16 digits',
            'source.number.required' => 'The cart number is required',
            'source.month.required' => 'The month is required',
            'source.month.in' => 'The month is not valid',
            'source.year.required' => 'The year is required',
            'source.year.min' => 'The year is Not Valid',
        ];


        // If validation fails, redirect to the settings page and send the errors
        //        $validatedData = $request->validate($validator_rules,$validator_rules_messages);
        $validatedData = Validator::Make($request->all(), $validator_rules, $validator_rules_messages);
        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData->getMessageBag())->withInput();
        }

        try {

            if (session()->has('checkOut_details')) {
                $amount = (session('checkOut_details')['total']);
                $request = $request->merge(['amount' => $amount * 100]);
                $request = $request->merge(['description' => '']);
                $request->request->remove('_token');
                $endpoint = "https://api.moyasar.com/v1/payments.html";
                $redir = [];
                $client = new Client(['allow_redirects' => true,]);
                $response = $client->request('POST', $endpoint, [
                    'form_params' => $request->all(),
                    'on_stats' => function (TransferStats $stats) use (&$redir) {
                        $redir[] = (string)$stats->getEffectiveUri();
                    }
                ]);

                if ($response->getStatusCode() == '200')
                    return redirect($redir[1]);
                return $statusCode = $response->getStatusCode();
            } else {
                session()->flash('error', __('general.error'));
                return redirect()->route('get_cart');
            }
        } catch (GuzzleException $exception) {
            //$responseBody = $exception->getResponse()->getBody(true)->getContents();
            $response = json_decode($exception->getResponse()->getBody(true)->getContents(), true);
            $errors = $response['errors'];
            if ($errors) {
                session()->flash('err', $errors);
            }
            return redirect(route('get.payment'))->withInput();
        }
    }

    public function store_payment(Request $request)
    {
        $payment = Payment::create([
            'payment_id' => $request->id,
            'customer_id' => Auth::id(),
            'total_paid' => $request->amount,
            'data' => json_encode($request->all()),
            'hash' => session('payment_hash', null),
        ]);

        if ($payment) {
            return response()->json([], 201);
        }

        return response(__('general.payment_not_found'), 404);
    }
}
