<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Api\BranchesController;
use App\Models\Address;
use App\Models\Branch;
use App\Models\Cart;
use App\Models\Offer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Category;
use App\Models\DoughType;
use App\Models\Item;
use App\Models\Order;
use App\Models\Payment;
use App\Traits\GeneralTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    use GeneralTrait;

    public function addCart(Request $request)
    {
        // check if cart has items with offers
        $cartHasOffers = false;
        $cart = collect();
        if (auth()->check()) {
            $cart = auth()->user()->carts;
            foreach ($cart as $item) {
                if ($item->offer_id) {
                    $offer = Offer::find($item->offer_id);
                    if ($offer && $offer->offer_type == 'buy-get') {
                        $cartHasOffers = true;
                        break;
                    }
                }
            }
        }

        if ($request->has('add_items_2') && $request->has('item55')) {
            $items = (is_array($request->add_items_2)) ? $request->add_items_2 : json_decode($request->add_items_2);
            // dd($items);
            foreach ($items as $index => $item) {
                if (is_string($item)) {
                    $item = json_decode($item, true);
                }

                // dd($item);
                $newRequest = new Request();
                $newRequest->merge(['item_id' => $request->item_id]);
                $newRequest->merge(['offer_id' => $request->offer_id ? $request->offer_id : null]);
                $newRequest->merge(['offer_price' => $request->offer_price ? $request->offer_price : null]);
                $newRequest->merge(['quantity' => 1]);

                if (isset($item->dough)) {
                    $dough = explode(',', $item->dough);
                    $newRequest->merge([
                        'dough_type_ar' => $dough[0],
                    ]);
                    $newRequest->merge([
                        'dough_type_en' => $dough[1],
                    ]);
                }

                if (isset($item->dough2)) {
                    $dough = explode(',', $item->dough2);
                    $newRequest->merge([
                        'dough_type_2_ar' => $dough[0],
                    ]);
                    $newRequest->merge([
                        'dough_type_2_en' => $dough[1],
                    ]);
                }

                $d2 = is_array($item) && isset($item['dough_type_2'])? $item['dough_type_2'] : [];
                if (is_object($item) && isset($item->dough_type_2)) {
                    $d2 = $item->dough_type_2;
                }


                if (!empty($d2)) {
                    $dough = $d2[0];
                    // dd($dough);
                    $newRequest->merge([
                        'dough_type_2_ar' => $dough['name_ar'],
                    ]);
                    $newRequest->merge([
                        'dough_type_2_en' => $dough['name_en'],
                    ]);
                }

                // dd($item);

                $cart = Cart::create([
                    'user_id' =>  Auth::user()->id,
                    'item_id' =>  $newRequest->item_id,
                    'extras' => (isset($item->extras)) ? json_encode($item->extras) : null,
                    'withouts' => (isset($item->withouts)) ? json_encode($item->withouts) : null,
                    'dough_type_ar' =>  $newRequest->has('dough_type_ar') ? $newRequest->dough_type_ar : null,
                    'dough_type_en' =>  $newRequest->has('dough_type_en') ? $newRequest->dough_type_en : null,
                    'dough_type_2_ar' =>  $newRequest->has('dough_type_2_ar') ? $newRequest->dough_type_2_ar : null,
                    'dough_type_2_en' =>  $newRequest->has('dough_type_2_en') ? $newRequest->dough_type_2_en : null,
                    'quantity' => isset($newRequest->quantity)? $newRequest->quantity : 1,
                    'offer_id' =>  $newRequest->offer_id,
                    'offer_price' =>  $newRequest->offer_price,
                ]);



            }
        }

        if ($request->has('add_items')) {
            //  dd(json_decode($request->add_items));
            $items = (is_array($request->add_items)) ? $request->add_items : json_decode($request->add_items);
            foreach ($items as $index => $item) {
                if (is_string($item)) {
                    $item = json_decode($item, true);
                }
                $newRequest = new Request();
                $newRequest->merge(['item_id' => $request->item_id]);
                $newRequest->merge(['offer_id' => $request->offer_id ? $request->offer_id : null]);
                $newRequest->merge(['offer_price' => $request->offer_price ? $request->offer_price : null]);
                $newRequest->merge(['quantity' => (isset($item->quantity)) ? $item->quantity : 1]);

                // dd($item);

                if (is_array($item)) {
                    if (isset($item['dough_type']) && isset($item['dough_type'][1])) {
                        // $dough_type = explode(',', $item['dough_type'][1]);
                        $request->merge([
                            'dough_type_ar' => $item['dough_type'][1]['name_ar'],
                        ]);
                        $request->merge([
                            'dough_type_en' => $item['dough_type'][1]['name_en'],
                        ]);
                    }
                }

                // dd(isset($item['dough_type']) && isset($item['dough_type'][1]), $request->all());

                // dd($item);

                if (isset($item->dough)) {
                    $dough = explode(',', $item->dough);
                    $request->merge([
                        'dough_type_ar' => $dough[0],
                    ]);
                    $request->merge([
                        'dough_type_en' => $dough[1],
                    ]);
                }

                if (isset($item->dough_type_2)) {
                    $dough = explode(',', $item->dough_type_2);
                    $request->merge([
                        'dough_type_2_ar' => $dough[0],
                    ]);
                    $request->merge([
                        'dough_type_2_en' => $dough[1],
                    ]);
                }

                $d2 = is_array($item) && isset($item['dough_type_2'])? $item['dough_type_2'] : [];
                if (is_object($item) && isset($item->dough_type_2)) {
                    $d2 = $item->dough_type_2;
                }


                if (!empty($d2)) {
                    $dough = $d2[0];
                    // dd($dough);
                    $request->merge([
                        'dough_type_2_ar' => $dough['name_ar'],
                    ]);
                    $request->merge([
                        'dough_type_2_en' => $dough['name_en'],
                    ]);
                }

                // dd($request->all(), $item->has('dough_type_2'), $item);

                // dump($item['quantity']);

                $return = (app(\App\Http\Controllers\Api\CartController::class)->getCart())->getOriginalContent();

                // dump($item['quantity']);

                foreach ($return['data'] as $item) {
                    if ($item->item_id == $request->item_id) {
                        if ($request->offer_id) {
                            $offer = Offer::findOrFail($request->offer_id);

                            // dd($offer);
    
                            if ($offer && $request->has('sa55')) {
                                $carti = Cart::find($item->id);
                                    
                                    if ($carti) {
                                        $carti->quantity += $request->quantity;
                                        $carti->save();
    
                                        return redirect()->route('menu.page');
                                    }
                            }
                        }
                        // if (($item->extras == $request->extras) && ($item->withouts == $request->withouts) && ($item->dough_type_en == $request->dough_type_en)) {
                           
                        //     return redirect()->route('menu.page');
                        // }
                    }
                }

                // dump($item['quantity']);

                // if ($request->has('sa55')) {

                // }


                // dd([
                //     'user_id' =>  Auth::user()->id,
                //     'item_id' =>  $request->item_id,
                //     'extras' =>  (isset($item->extras))?json_encode($item->extras):[],
                //     'withouts' =>  (isset($item->withouts))?json_encode($item->withouts):[],
                //     'dough_type_ar' =>  $request->dough_type_ar,
                //     'dough_type_en' =>  $request->dough_type_en,
                //     'quantity' =>  $request->quantity,
                //     'offer_id' =>  $request->offer_id,
                //     'offer_price' =>  $request->offer_price,
                // ]);

                // if ($request->offer_id && $cartHasOffers) continue;

                // dd($item);
                // $qty = is_array($item) && isset($item['quantity']) && $item['quantity'] > 0? $item['quantity'] : 1;
                // if (is_object($item) && isset($item->quantity)) {
                //     $qty = $item->quantity > 0 ? $item->quantity : 1;
                //     dd(request()->all());
                // }

                $cart = Cart::create([
                    'user_id' =>  Auth::user()->id,
                    'item_id' =>  $request->item_id,
                    'extras' => (isset($item->extras)) ? json_encode($item->extras) : null,
                    'withouts' => (isset($item->withouts)) ? json_encode($item->withouts) : null,
                    'dough_type_ar' =>  $request->has('dough_type_ar') ? $request->dough_type_ar : null,
                    'dough_type_en' =>  $request->has('dough_type_en') ? $request->dough_type_en : null,
                    'dough_type_2_ar' =>  $request->has('dough_type_2_ar') ? $request->dough_type_2_ar : null,
                    'dough_type_2_en' =>  $request->has('dough_type_2_en') ? $request->dough_type_2_en : null,
                    'quantity' => isset($request->quantity)? $request->quantity : 1,
                    'offer_id' =>  $request->offer_id,
                    'offer_price' =>  $request->offer_price,
                ]);

                // dump($cart);

            }
            return redirect()->route('menu.page');
        }
        if ($request->has('buy_items')) {
            foreach ($request->buy_items as $index => $buy_item) {
                $newRequest = new Request();
                $newRequest->merge(['item_id' => $buy_item]);
                $newRequest->merge(['offer_id' => $request->offer_id]);
                $newRequest->merge(['offer_price' => $request->offer_price[$index]]);
                $newRequest->merge(['quantity' => $request->quantity]);
                $i = Item::find($newRequest->item_id);
                if ($i) {
                    $c = Category::find($i->category_id);
                    if ($c) {
                        $d = DoughType::where('dough_type_id', $c->dough_type_id)->latest('id')->get()->first();
                        if ($d) {
                            $newRequest->merge(['dough_type_ar' => $d->name_ar, 'dough_type_en' => $d->name_en]);
                        }
                    }
                }
                
                // dd($d);
                if ($newRequest->offer_id && $cartHasOffers) continue;
                (app(\App\Http\Controllers\Api\CartController::class)->addCart($newRequest))->getOriginalContent();
            }
            foreach ($request->get_items as $get_item) {
                $newRequest = new Request();
                $newRequest->merge(['item_id' => $get_item]);
                $newRequest->merge(['offer_id' => $request->offer_id]);
                $newRequest->merge(['offer_price' => 0]);
                $newRequest->merge(['quantity' => $request->quantity]);
                $i = Item::find($newRequest->item_id);
                if ($i) {
                    $c = Category::find($i->category_id);
                    if ($c) {
                        $d = DoughType::where('dough_type_id', $c->dough_type_id)->latest('id')->get()->first();
                        if ($d) {
                            $newRequest->merge(['dough_type_ar' => $d->name_ar, 'dough_type_en' => $d->name_en]);
                        }
                    }
                }
                if ($newRequest->offer_id && $cartHasOffers) continue;
                (app(\App\Http\Controllers\Api\CartController::class)->addCart($newRequest))->getOriginalContent();
            }
            return redirect()->route('menu.page');
        }

        if ($request->has('dough_type')) {
            $dough_type = explode(',', $request->dough_type);
            $request->merge(['dough_type_ar' => $dough_type[0]]);
            $request->merge(['dough_type_en' => $dough_type[1]]);
        }

        $request->merge(['withouts' => json_encode($request->withouts)]);
        $request->merge(['extras' => json_encode($request->extras)]);
        $request->merge(['offer_price' => $request->offer_price]);

        $return = (app(\App\Http\Controllers\Api\CartController::class)->getCart())->getOriginalContent();

        
        if ($return['data']->count() > 0) {
            foreach ($return['data'] as $item) {
                if ($item->item_id == $request->item_id) {
                    if ($request->offer_id) {
                        $offer = Offer::findOrFail($request->offer_id);

                        if ($offer && $offer->offer_type == 'discount') {
                            $st = Carbon::createFromFormat("Y-m-d H:i:s", $offer->date_from);
                            $en = Carbon::createFromFormat("Y-m-d H:i:s", $offer->date_to);
    
                            if (now('Asia/Riyadh')->isBetween($st, $en)) {
                                $carti = Cart::find($item->id);
                                
                                if ($carti) {
                                    $carti->quantity += $request->quantity;
                                    $carti->save();

                                    return redirect()->route('menu.page');
                                }
                            }
                        }
                    }
                    // if (($item->extras == $request->extras) && ($item->withouts == $request->withouts) && ($item->dough_type_en == $request->dough_type_en)) {
                       
                    //     return redirect()->route('menu.page');
                    // }
                }
            }
        }

        if ($request->offer_id && !$cartHasOffers) {
            $return = (app(\App\Http\Controllers\Api\CartController::class)->addCart($request))->getOriginalContent();
        };

        if (isset($request->reorder_me)) {
            return redirect()->route('get.cart');
        }

        return redirect()->route('menu.page');
    }


    public function get_cart()
    {
        $return = (app(\App\Http\Controllers\Api\CartController::class)->getCart())->getOriginalContent();
        $request = new \Illuminate\Http\Request();

        if ($return['success'] == 'success') {
            $carts = $return['data'];
            $arr_check = $this->get_check();

            $firstDiscount = $firstDiscount = auth()->user()->hasNoOrders();

            // dd(auth()->user()->orders()->count());

            if (session()->has('point_claim_value')) {
                return view('website.cart', compact(['carts', 'arr_check', 'firstDiscount']));
            } else {
                return view('website.cart', compact(['carts', 'arr_check', 'firstDiscount']));
            }
        }
    }
    public function get_cart_res()
    {
        // $return = (app(\App\Http\Controllers\Api\CartController::class)->getCart())->getOriginalContent();

        // $count = count($return['data']);

        // if ($return['success'] == 'success') {
        return response()->json(['success' => true, 'data' => Auth::user()->carts()->sum('quantity')], 200);
        // }
    }

    public function delete_cart(Request $request)
    {
        $deleteCart = (app(\App\Http\Controllers\Api\CartController::class)->deleteCart($request))->getOriginalContent();
        $carts = $deleteCart['data'];
        $arr_check = $this->get_check();

        return response()->json([
            'carts' => $carts,
            'arr_check' => $arr_check,
        ]);
    }

    public function update_quantity(Request $request)
    {
        $return = (app(\App\Http\Controllers\Api\CartController::class)->updateQuantity($request))->getOriginalContent();
        $arr_check = $this->get_check();

        return response()->json($arr_check);
    }

    public function get_check()
    {
        $return = (app(\App\Http\Controllers\Api\CartController::class)->getCart())->getOriginalContent();
        $arr_data = [];
        $extras_price = 0;
        if ($return['success'] == 'success') {
            $carts = $return['data'];
            $final_item_price = 0;
            $final_item_price_without_offer = 0;
            foreach ($carts as $index => $cart) {
                $quantity = $cart->quantity;
                if ($cart->offer_id) {
                    $item_price = $cart->offer_price;
                } else {
                    $item_price = $cart->item->price;
                }
                $final_item_price += ($item_price * $quantity);
                $final_item_price_without_offer += ($cart->item->price * $quantity);

                if ($cart->ExtrasObjects) {
                    foreach ($cart->ExtrasObjects as $ExtrasObjects) {
                        $extras_price += $ExtrasObjects->price * $quantity;
                        $final_item_price += $extras_price;
                        $final_item_price_without_offer += $extras_price;
                    }
                }
                // dd($final_item_price, $final_item_price_without_offer);
            }

            // dd($final_item_price, $final_item_price_without_offer);


            // if (session()->has('loyality-points')) {
            // $loyality = session('loyality-points');
            // $value = $loyality['value'];
            // $points = $loyality['points'];
            // $arr_data['points'] = round($value, 2);
            // $arr_data['taxes'] = round($final_item_price / 1.15, 2);
            // $arr_data['delivery_fees'] = session()->get('service_type') == 'delivery' ? round($this->get_delivery_fees(session()->get('address_area_id')), 2) : 0;
            // $arr_data['subtotal'] = round($final_item_price, 2);
            // $final_item_price += ($arr_data['delivery_fees']) - $arr_data['points'];
            // $arr_data['total'] = round($final_item_price, 2);
            // return $arr_data;
            // }
            if (session()->has('point_claim_value')) {
                $arr_data['points'] = round(session()->get('point_claim_value'), 2);
                $arr_data['points_value'] = round(session()->get('points_value'), 2);
                $arr_data['taxes'] = round($final_item_price / 1.15, 2);
                $arr_data['delivery_fees'] = session()->get('service_type') == 'delivery' ? round($this->get_delivery_fees(session()->get('address_area_id')), 2) : 0;
                $arr_data['subtotal'] = round($final_item_price, 2);
                $arr_data['subtotal_without_offer'] = round($final_item_price_without_offer, 2);
                // $final_item_price += ($arr_data['taxes'] + $arr_data['delivery_fees']) - $arr_data['points'];
                // if ($arr_data['subtotal'] <= $arr_data['points']) {
                //     $arr_data['points'] = 0;
                // }
                $final_item_price += ($arr_data['delivery_fees']) - $arr_data['points'];
                $arr_data['total'] = round($final_item_price, 2);
                return $arr_data;
            } else {
                $arr_data['taxes'] = round($final_item_price / 1.15, 2);
                $arr_data['delivery_fees'] = session()->get('service_type') == 'delivery' ? round($this->get_delivery_fees(session()->get('address_area_id')), 2) : 0;
                $arr_data['subtotal'] = round($final_item_price, 2);
                $arr_data['subtotal_without_offer'] = round($final_item_price_without_offer, 2);
                // $final_item_price += $arr_data['taxes'] + $arr_data['delivery_fees'];
                $final_item_price += $arr_data['delivery_fees'];
                $arr_data['total'] = round($final_item_price, 2);
                return $arr_data;
            }
        }
    }

    public function get_checkout(Request $request)
    {
        session()->forget('direct_check');
        
        if (auth()->user()->carts()->get()->count() <= 0) {
            return redirect()->route('menu.page');
        }

        $payment = null;
        // dd(session()->all());
        // session()->forget('payment');
        if (session()->has('payment')) {
            $payment = (object) session('payment');

            if (null === $payment->status) {
                Payment::where('payment_id', $payment->payment_id)->delete();

                session()->forget('payment');
                // abort(404);
            } else {
                $request->merge(session('checkOut_details'));
            }
        }

        // dd($payment);

        if ($request['total'] <= 0 && isset($request['points_paid']) && $request['points_paid'] > 0) {
            return back()->with('loyality_not_used', __('general.loyality_not_used'));
        }

        $firstDiscount = auth()->user()->hasNoOrders();

        if (session()->has('direct_check')) {

            // dd($request);
            $ord = Order::find($request->order_id);
            if ($ord) {
                session(['service_type' => $ord->service_type]);
                session(['address_type' => $request->address_id]);
                session(['branch_id' => $ord->branch_id]);

                $add = Address::find($request->address_id);
                if ($add) {
                    if ($add->area) {
                        session(['address_area_id' => $add->area_id]);
                    }
                }
            } else {
                return redirect()->route('menu.page');
            }
        }

        // dd(session()->all());
        $service_type = session()->get('service_type');
        if ($service_type == 'delivery') {
            $address_id = session()->get('address_id');
            $area_id = session()->get('address_area_id');
            $request->merge(['address_id' => $address_id, 'address_area_id' => $area_id]);
        }
        $branch_id = session()->get('branch_id');
        
        $request->merge([
            'branch_id' => $branch_id,
            'service_type' => $service_type,
            
        ]);

        $branch = Branch::where('id', $branch_id)->with(['city', 'area', 'deliveryAreas'])->with(['workingDays' => function ($day) {
            $day->where('day', strtolower(now()->englishDayOfWeek))->first();
        }])->first();

        $work_hours = $branch->workingDays()->where('day', strtolower(now()->englishDayOfWeek))->get();

        $isOpen = (app(BranchesController::class)->check($request, $branch_id))->getOriginalContent();

        if ($isOpen['data']['available'] === false) {
            session()->flash('branch_closed', true);
            session()->flash('branch_name', $branch['name_' . app()->getLocale()]);
            return back();
        }

        unset($request['_token']);
        session()->put(['checkOut_details' => $request->all()]);

        if (isset($address_id) && !$payment) {
            $address = Address::find($address_id);
            return view('website.checkout', compact('request', 'address', 'work_hours', 'firstDiscount'));
        }

        if ($payment) {
            return view('website.checkout-pay', compact('request', 'branch', 'work_hours', 'payment', 'firstDiscount'));
        } 

        return view('website.checkout', compact('request', 'branch', 'work_hours', 'payment', 'firstDiscount'));
    }

    public function get_checkout_reorder(Request $request)
    {
        if (!session()->has('direct_check')) {
            return redirect()->route('menu.page');
        }

        $payment = null;
        if (session()->has('payment')) {
            $payment = (object) session('payment');
            // session()->forget('payment');
            if (null === $payment->status) {
                Payment::where('payment_id', $payment->payment_id)->delete();

                session()->forget('payment');
                // abort(404);
            } else {
                $request->merge(session('checkOut_details'));
            }
        }

        if ($request['total'] <= 0 && isset($request['points_paid']) && $request['points_paid'] > 0) {
            return back()->with('loyality_not_used', __('general.loyality_not_used'));
        }

        $firstDiscount = false;

        // dd($request->all());

        if (session()->has('direct_check')) {

            // dd($request);
            $ord = Order::find($request->order_id);
            if ($ord) {
                if ($ord->is_first_order) {
                    $request->merge([
                        'total' => round($ord->total *2, 2)
                    ]);
                }
                session(['service_type' => $ord->service_type]);
                session(['address_type' => $request->address_id]);
                session(['branch_id' => $ord->branch_id]);

                $add = Address::find($request->address_id);
                if ($add) {
                    if ($add->area) {
                        session(['address_area_id' => $add->area_id]);
                    }
                }
            } else {
                return redirect()->route('menu.page');
            }
        }

        // dd(session()->all());
        $service_type = session()->get('service_type');
        if ($service_type == 'delivery') {
            $address_id = session()->get('address_id');
            $area_id = session()->get('address_area_id');
            $request->merge(['address_id' => $address_id, 'address_area_id' => $area_id]);
        }
        $branch_id = session()->get('branch_id');
        
        $request->merge([
            'branch_id' => $branch_id,
            'service_type' => $service_type,
            
        ]);

        $branch = Branch::where('id', $branch_id)->with(['city', 'area', 'deliveryAreas'])->with(['workingDays' => function ($day) {
            $day->where('day', strtolower(now()->englishDayOfWeek))->first();
        }])->first();

        $work_hours = $branch->workingDays()->where('day', strtolower(now()->englishDayOfWeek))->get();

        $isOpen = (app(BranchesController::class)->check($request, $branch_id))->getOriginalContent();

        if ($isOpen['data']['available'] === false) {
            session()->flash('branch_closed', true);
            session()->flash('branch_name', $branch['name_' . app()->getLocale()]);
            return back();
        }

        unset($request['_token']);
        session()->put(['checkOut_details' => $request->all()]);

        if (isset($address_id)) {
            $address = Address::find($address_id);
            return view('website.checkout_reorder', compact('request', 'address', 'work_hours', 'firstDiscount'));
        }

        if (session()->has('payment')) {
            // session()->forget('direct_check');
        }

        return view('website.checkout_reorder', compact('request', 'branch', 'work_hours', 'payment', 'firstDiscount'));
    }

    public function get_delivery_fees($area_id)
    {
        $fees = Area::where('id', $area_id)->select('delivery_fees')->first();
        return round($fees->delivery_fees, 2);
    }
}
