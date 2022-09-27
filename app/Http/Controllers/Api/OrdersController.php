<?php

namespace App\Http\Controllers\Api;

use App\Models\OfferBuyGet;
use App\Models\OfferDiscount;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Filters\OrderFilters;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController;
use App\Models\Branch;
use App\Models\Order;
use App\Models\Item;
use App\Models\User;
use App\Models\Extra;
use App\Models\General;
use App\Models\Offer;
use App\Models\OrderItem;
use App\Models\Without;
use App\Models\PointsTransaction;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdersController extends BaseController
{
    use GeneralTrait;

    protected $validationRules = [
        'customer_id' => 'exists:users,id',
        'address_id' => 'required|exists:addresses,id',
        'branch_id' => 'exists:branches,id',
        'service_type' => 'required',
        'offer_id' => 'exists:offers,id'
    ];

    public function index(Request $request, OrderFilters $filters)
    {

        $orders = Order::filter($filters);

        $user_branches = Auth::user()->branches()->pluck('branches.id')->toArray();

        if (!empty($user_branches)) {
            $orders = $orders->whereIn('branch_id', $user_branches);
        }

        $orders = $orders->with(['customer', 'branch', 'items'])->with(['address' => function ($address) {
            $address->with(['city', 'area']);
        }])->orderBy('id', 'DESC')->paginate(10);


        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $extras = $item->pivot->item_extras;
                $extras = $extras ? explode(", ", $extras) : [];

                $all_extras = [];
                foreach ($extras as $extra) {
                    $all_extras[] = Extra::find($extra);
                }

                $item->extras = $all_extras;
            }
        }

        return $this->sendResponse($orders->toArray(), __('general.Orders retrieved successfully.'));
    }

    public function getUserOrders(Request $request)
    {
        $orders = auth('api')->user()->orders()->with(['branch', 'items'])->with(['address' => function ($address) {
            $address->with(['city', 'area']);
        }])->orderBy('id', 'DESC')->paginate(10);
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $item->extras = Extra::whereIn('id', explode(', ', $item->pivot->item_extras))->get();
                $item->withouts = Without::whereIn('id', explode(', ', $item->pivot->item_withouts))->get();
                // $extras = $item->pivot->item_extras;
                // $extras = $extras ? explode(", ", $extras) : [];

                // $all_extras = [];
                // foreach ($extras as $extra) {
                //     $all_extras[] = Extra::find($extra);
                // }

                // $item->extras = $all_extras;

                // $withouts = $item->pivot->item_withouts;
                // $withouts = $withouts ? explode(", ", $withouts) : [];

                // $all_withouts = [];
                // foreach ($withouts as $without) {
                //     $all_withouts[] = Without::find($without);
                // }

                // $item->withouts = $all_withouts;
            }
        }
        return $this->sendResponse($orders->toArray(),  __('general.Orders retrieved successfully.'));
    }

    /**
     * Request Body:
     *  - customer_id
     *  - address_id
     *  - service_type (delivery, takeaway)
     *  - offer_id
     *  - branch_id
     *  - subtotal
     *  - taxes
     *  - delivery_fees
     *  - total
     *  - points_paid
     *  - items[]
     *      - item_id
     *      - withouts[]
     *      - withouts[]
     *
     *
     * Followed Steps:
     *  1- Get Customer information by customer id from "users" table.
     *      1.1- Check for customer role.
     *  2- Check for the service type.
     *      2.1- In case of delivery.
     *          2.1.1- Form validation for (address_id, service_type, offer_id).
     *          2.1.2- Get the customer address for "address" table by address_id.
     *          2.1.3- Get the area for the fetched address.
     *          2.1.4- Get the branch id from "branch_delivery_areas" table using the fetched area id.
     *          2.1.5- Check if there's branch already exists for this id.
     *          2.1.6- Output: $branch_id.
     *      2.2- In case of takeaway.
     *          2.2.1- Form validation for (branch_id, service_type, offer_id).
     *          2.2.2- Get branch by "branch_id" then check if there's abranch already exists for this id.
     *          2.2.3- Output: $branch_id.
     *  3- Grap the rest of order data from request.
     *  4- Create new order.
     *  5- Send a push notification for all the nearby branches with the new order details.
     *  6- Loop through each item of the items array found in request body.
     *      6.1- Grap the item model based on $item['item_id'].
     *      6.2- Grap the extras models based on $item['extras'].
     *      6.3- Grap the withouts models based on $item['withouts'].
     *      6.4- If the request has $item['price'] means that order has offer.
     *          6.4.1- Grap the sum of withouts.
     *          6.4.2- Grap the sum of extras.
     *          6.4.3- Subtotal += price + extras - withouts.
     *      6.5- If the request doesn't have $item['price'].
     *          6.5.1- Grap the sum of withouts.
     *          6.5.2- Grap the sum of extras.
     *          6.5.3- Subtotal += $itemModel->price + extras - withouts.
     *      6.6 Attach the rest of data to the pivot table.
     */

    public function store(Request $request)
    {
        // get customer information
        $customer = User::where('id', $request->customer_id)->whereHas('roles', function ($role) {
            $role->where('name', 'customer');
        })->first();

        $branch_id = 0;

        if ($request->service_type == 'delivery') {

            // validate user input
            $validator = Validator::make($request->all(), [
                'address_id' => 'required|exists:addresses,id',
                'service_type' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Errors!', $validator->errors());
            }
            $customerAddress = $customer->addresses->where('id', $request->address_id)->first();

            // get the branch covers customer area and open
            $area = isset($customerAddress->area) ? $customerAddress->area : null;

            if ($area) {
                $branch = DB::table('branch_delivery_areas')->where('area_id', $area->id . "")->first();

                if ($branch) {
                    $branch = Branch::find($branch->branch_id);

                    if ($branch) {
                        $branch_id = $branch->id;
                    } else {
                        return $this->sendError(__('general.branch_no_cover'));
                    }
                } else {
                    return $this->sendError(__('general.branch_no_cover'));
                }
            } else {
                return $this->sendError(__('general.branch_no_cover'));
            }
        }

        if ($request->service_type == 'takeaway') {

            // validate user input
            $validator = Validator::make($request->all(), [
                'branch_id' => 'exists:branches,id',
                'service_type' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Errors!', $validator->errors());
            }
            $branch = Branch::find($request->branch_id);

            if (!$branch) {
                return $this->sendError('there is no branch by this id');
            }

            $branch_id = $branch->id;
        }


        // apply 50% discount if this is first order
        $request->total = $this->applyDiscountIfFirstOrder($customer, $request->total);

        $orderData = [
            "address_id" => $request->address_id,
            "customer_id" => $request->customer_id, //$request->user()->id,
            "branch_id" => $branch_id, //$branch->id,
            "service_type" => $request->service_type,
            "state" => 'pending',
            "subtotal" => $request->subtotal,
            "taxes" => $request->taxes,
            "delivery_fees" => $request->delivery_fees,
            "total" => $request->total,
            "points_paid" => $request->points_paid,
            'points' => $request->points,
            'offer_value' => $request->offer_value,
            'order_from' => 'mobile',
            'description_box' => $request->description,
            'payment_type' => $request->payment_type

        ];

        $order = Order::create($orderData);

        // try{

        // }catch(\Exception $ex){
        //     return $this->sendError('Order did not placed');
        // }

         $cashiers =  User::join('branch_user','branch_user.user_id','users.id')->where('branch_user.branch_id',$branch_id)->whereHas('roles', function ($role) {
            $role->where('name', 'cashier');})->get();
        if ($cashiers) {
            foreach ($cashiers as $cashier) {
               
              \App\Http\Controllers\NotificationController::pushNotifications($cashier->id, "New Order has been placed", "Order", null, null, $request->customer_id);
            }
        }

        // $subtotal = 0;

        $items = [];
        // dd($request->items);
        foreach ($request->items as $item) {
            if (gettype($item) == 'object') {
                $item = $item->toArray();
            }
            // if ($item['quantity'] > 1) {
            for ($i = 0; $i < $item['quantity']; $i++) {
                $items[] = [
                    'item_id' => $item['item_id'],
                    'quantity' => 1,
                    'offer_price' => isset($item['offer_price']) ? $item['offer_price'] : null,
                    'price' => $item['price'],
                    'offerId' => isset($item['offerId']) ? $item['offerId'] : null,
                    'extras' => isset($item['extras'][$i]) && count($item['extras']) ? $item['extras'][$i] : [],
                    'withouts' => isset($item['withouts'][$i]) && count($item['withouts']) ? $item['withouts'][$i] : [],
                    'dough_type_ar' => isset($item['dough_type_ar'][$i]) ? $item['dough_type_ar'][$i] : null,
                    'dough_type_en' => isset($item['dough_type_en'][$i]) ? $item['dough_type_en'][$i] : null,
                    'dough_type_2_ar' => isset($item['dough_type_2_ar'][$i]) ? $item['dough_type_2_ar'][$i] : null,
                    'dough_type_2_en' => isset($item['dough_type_2_en'][$i]) ? $item['dough_type_2_en'][$i] : null,
                ];
            }
            // } else {
            //     $items[] = $item;
            // }  
        }

        foreach ($items as $item) {

            $orderItem = Item::where('id', $item['item_id'])->first();
            $orderItemExtras = null;


            if (array_key_exists('extras', $item)) {
                $orderItemExtras = Extra::whereIn('id', $item['extras'])->get();
            }
            $orderItemWithouts = null;
            if (array_key_exists('withouts', $item)) {
                $orderItemWithouts = Without::whereIn('id', $item['withouts'])->get();
            }

            $itemOfferPrice = 0;
            $itemPrice = 0;
            // check if there is offer price
            // count sum of extras price and item price
            if (array_key_exists('offer_price', $item)) {
                $extras = $orderItemExtras ? $orderItemExtras->sum('price') : 0;
                $itemOfferPrice = $item['offer_price'] + $extras;
            }
            if (array_key_exists('price', $item)) {
                $extras = $orderItemExtras ? $orderItemExtras->sum('price') : 0;
                $itemPrice = $orderItem->price + $extras;
            }

            // $subtotal = $subtotal + $itemPrice;
            $offer = Offer::find(isset($item['offerId']) ? $item['offerId'] : 0);
            $extras = array_key_exists('extras', $item) ? $item['extras'] : null;

            if (is_array($extras) && count($extras) && !is_int($extras[0])) {
                $extras = collect($extras)->pluck('id');
            }

            $withouts = array_key_exists('withouts', $item) ? $item['withouts'] : null;
            if (is_array($withouts) && count($withouts) && !is_int($withouts[0])) {
                $withouts = collect($withouts)->pluck('id');
            }
            $order->items()->attach($item['item_id'], [
                'item_extras' =>  is_array($extras) ? implode(', ', $extras) : $extras,
                'item_withouts' =>  is_array($withouts) ? implode(', ', $withouts) : $withouts,
                'dough_type_ar' => array_key_exists('dough_type_ar', $item) ? $item['dough_type_ar'] : null,
                'dough_type_en' => array_key_exists('dough_type_en', $item) ? $item['dough_type_en'] : null,
                'dough_type_2_ar' => array_key_exists('dough_type_2_ar', $item) ? $item['dough_type_2_ar'] : null,
                'dough_type_2_en' => array_key_exists('dough_type_2_en', $item) ? $item['dough_type_2_en'] : null,
                'price' => $itemPrice,
                'pure_price' => $orderItem->price,
                'offer_price' => array_key_exists('offer_price', $item) ? $itemOfferPrice : null, // TODO: Remove price
                'offer_id' => optional($offer)->id,
                'offer_last_updated_at' => optional($offer)->updated_at,
                'quantity' => array_key_exists('quantity', $item) ? $item['quantity'] : 1,
            ]);
        }


        return $this->sendResponse($order,  __('general.Order created successfully!'));
    }

    public function orderPayed(Request $request)
    {
        if ($request->status == 'paid' && $request->message == 'Succeeded!') {
            // make order
            // get customer information
            $customer = User::where('id', $request->customer_id)->whereHas('roles', function ($role) {
                $role->where('name', 'customer');
            })->first();

            $branch_id = 0;

            if ($request->service_type == 'delivery') {

                // validate user input
                $validator = Validator::make($request->all(), [
                    'address_id' => 'required|exists:addresses,id',
                    'service_type' => 'required',
                ]);
                if ($validator->fails()) {
                    return $this->sendError('Validation Errors!', $validator->errors());
                }
                $customerAddress = $customer->addresses->where('id', $request->address_id)->first();

                // get the branch covers customer area and open
                $area = $customerAddress->area;

                if ($area) {
                    $branch = DB::table('branch_delivery_areas')->where('area_id', $area->id . "")->first();

                    if ($branch) {
                        $branch = Branch::find($branch->branch_id);

                        if ($branch) {
                            $branch_id = $branch->id;
                        } else {
                            return $this->sendError(__('general.branch_no_cover'));
                        }
                    } else {
                        return $this->sendError(__('general.branch_no_cover'));
                    }
                } else {
                    return $this->sendError(__('general.branch_no_cover'));
                }
            }

            if ($request->service_type == 'takeaway') {

                // validate user input
                $validator = Validator::make($request->all(), [
                    'branch_id' => 'exists:branches,id',
                    'service_type' => 'required',
                ]);
                if ($validator->fails()) {
                    return $this->sendError('Validation Errors!', $validator->errors());
                }
                $branch = Branch::find($request->branch_id);

                if (!$branch) {
                    return $this->sendError('there is no branch by this id');
                }

                $branch_id = $branch->id;
            }


            // $orderData = [
            //     "address_id" => $request->address_id,
            //     "customer_id" => $request->customer_id, //$request->user()->id,
            //     "branch_id" => $branch_id, //$branch->id,
            //     "service_type" => $request->service_type,
            //     "state" => 'pending',
            //     "subtotal" => $request->subtotal,
            //     "taxes" => $request->taxes,
            //     "delivery_fees" => $request->delivery_fees,
            //     "total" => $request->total,
            //     "points_paid" => $request->points_paid,
            //     'order_from' => 'mobile'
            // ];

            // apply 50% discount if this is first order
            $request->total = $this->applyDiscountIfFirstOrder($customer, $request->total);

            $orderData = [
                "address_id" => $request->address_id,
                "customer_id" => $request->customer_id, //$request->user()->id,
                "branch_id" => $branch_id, //$branch->id,
                "service_type" => $request->service_type,
                "state" => 'pending',
                "subtotal" => $request->subtotal,
                "taxes" => $request->taxes,
                "delivery_fees" => $request->delivery_fees,
                "total" => $request->total,
                "points_paid" => $request->points_paid,
                'points' => $request->points,
                'offer_value' => $request->offer_value,
                'order_from' => 'mobile'
            ];

            $order = Order::create($orderData);

            if (!$order) {
                return $this->sendError('Order did not placed');
            }

             $cashiers =  User::join('branch_user','branch_user.user_id','users.id')->where('branch_user.branch_id',$branch_id)->whereHas('roles', function ($role) {
            $role->where('name', 'cashier');})->get();
            if ($cashiers) {
                foreach ($cashiers as $cashier) {
                    \App\Http\Controllers\NotificationController::pushNotifications($cashier->id, "New Order has been placed", "Order", null, null, $request->customer_id);
                }
            }

            $subtotal = 0;

            foreach ($request->items as $item) {
                $orderItem = Item::where('id', $item['item_id'])->first();
                $orderItemExtras = null;
                if (gettype($item) == 'object') {
                    $item = $item->toArray();;
                }
                if (array_key_exists('extras', $item)) {
                    $orderItemExtras = Extra::whereIn('id', $item['extras'])->get();
                }

                $orderItemWithouts = null;
                if (array_key_exists('withouts', $item)) {
                    $orderItemWithouts = Without::whereIn('id', $item['withouts'])->get();
                }

                $itemOfferPrice = 0;
                $itemPrice = 0;
                // check if there is offer price
                // count sum of extras price and item price
                if (array_key_exists('offer_price', $item)) {
                    $extras = $orderItemExtras ? $orderItemExtras->sum('price') : 0;
                    $itemOfferPrice = $item['offer_price'] + $extras;
                }
                if (array_key_exists('price', $item)) {
                    $extras = $orderItemExtras ? $orderItemExtras->sum('price') : 0;
                    $itemPrice = $orderItem->price + $extras;
                }

                $subtotal = $subtotal + $itemPrice;
                $offer = Offer::find(isset($item['offerId']) ? $item['offerId'] : 0);
                $order->items()->attach($item['item_id'], [
                    'item_extras' => array_key_exists('extras', $item) ? implode(', ', $item['extras']) : null,
                    'item_withouts' => array_key_exists('withouts', $item) ? implode(', ', $item['withouts']) : null,
                    'dough_type_ar' => array_key_exists('dough_type_ar', $item) ? $item['dough_type_ar'] : null,
                    'dough_type_en' => array_key_exists('dough_type_en', $item) ? $item['dough_type_en'] : null,
                    'price' => $itemPrice,
                    'pure_price' => $orderItem->price,
                    'offer_price' => array_key_exists('offer_price', $item) ? $itemOfferPrice : null, // TODO: Remove price
                    'offer_id' => optional($offer)->id,
                    'offer_last_updated_at' => optional($offer)->updated_at,
                    'quantity' => array_key_exists('quantity', $item) ? $item['quantity'] : 1
                ]);
            }

            // save payment
            $payment = Payment::create([
                'payment_id' => $request->payment_id,
                'customer_id' => $request->customer_id,
                'status' => $request->status,
                'message' => $request->message,
                'order_id' => $order->id,
                'total_paid' => $request->amount / 100
            ]);

            return $this->sendResponse($order,  __('general.Order created successfully!'));
        }
        return $this->sendError(__('general.Order did not placed'));
    }

    public function re_order(Request $request)
    {
        $message = __('general.success');
        $validation = true;
        $order = Order::find($request->order_id);
        // check if order exists in DB
        if (!$order) {
            return $this->sendError(__('general.Order not found'));
        }

        $items = [];
        $deletedOfferPrice = 0;
        $final_item_price = 0;

        $offers = [];
        $noOffers = [];
        $allItems = [];

        if ($order->items->count() != OrderItem::where('order_id', $request->order_id)->count()) {
            $message = __('general.item deleted');
            $validation = false;
            return $this->sendResponse(['message' => $message, 'validation' => $validation, 'items' => (object)[]], '');
        }

        foreach ($order->items as $item) {
            $extras_price = 0;
            $is_valid = false;
            $hasOffer = 0;



            if ($item->price != OrderItem::where('order_id', $request->order_id)->where('item_id', $item->id)->pluck('pure_price')->first()) {
                $message = __('general.item price changed');
                $validation = false;
                return $this->sendResponse(['message' => $message, 'validation' => $validation, 'items' => (object)[]], '');
            }
            if ($item->pivot->offer_id && (Offer::find($item->pivot->offer_id))['date_to'] < now()) {
                $message = __('general.offer expired');
                $validation = false;
                return $this->sendResponse(['message' => $message, 'validation' => $validation, 'items' => (object)[]], '');
                $quantity = $item->pivot->quantity;
                $item_price = Item::find($item->id)->price;
                $final_item_price = ($item_price * $quantity);
                if ($item->pivot->item_extras) {
                    $extras_price = Extra::whereIn('id', explode(', ', $item->pivot->item_extras))->sum('price') * $quantity;
                    $final_item_price += $extras_price;
                }
                $deletedOfferPrice += $final_item_price;
                $hasOffer = 1;
            }
            if ($item->pivot->offer_id && (Offer::find($item->pivot->offer_id))['date_to'] >= now()) {
                $quantity = $item->pivot->quantity;
                $item_price = ((Offer::find($item->pivot->offer_id))['offer_type'] == 'discount') ? $this->calcOfferItem($item->pivot->offer_id, $item->id) : $item->pivot->offer_price;
                $final_item_price = ($item_price * $quantity);
                if ($item->pivot->item_extras) {
                    $extras_price = Extra::whereIn('id', explode(', ', $item->pivot->item_extras))->sum('price') * $quantity;
                    $final_item_price += $extras_price;
                }
                $deletedOfferPrice += $final_item_price;
                $hasOffer = 1;
            }
            if ($item->pivot->offer_id == null) {
                if (OrderItem::where('order_id', $request->order_id)->where('item_id', $item->id)->pluck('offer_id')->first()) {
                    $message = __('general.offer deleted');
                    $validation = false;
                    return $this->sendResponse(['message' => $message, 'validation' => $validation, 'items' => (object)[]], '');
                }
                $quantity = $item->pivot->quantity;
                $item_price = Item::find($item->id)->price;
                $final_item_price = ($item_price * $quantity);
                if ($item->pivot->item_extras) {
                    $extras_price = Extra::whereIn('id', explode(', ', $item->pivot->item_extras))->sum('price') * $quantity;
                    $final_item_price += $extras_price;
                }
                $deletedOfferPrice += $final_item_price;
            }

            if ($item->pivot->offer_id && (Offer::find($item->pivot->offer_id))['date_to'] >= now()) {
                $items[] = collect([
                    'item_id' => $item->id,
                    'extras' => [explode(', ', $item->pivot->item_extras)],
                    'withouts' => [explode(', ', $item->pivot->item_withouts)],
                    'price' => Item::find($item->id)->price,
                    'dough_type_ar' => $item->pivot->dough_type_ar,
                    'dough_type_en' => $item->pivot->dough_type_en,
                    'offer_price' => ((Offer::find($item->pivot->offer_id))['offer_type'] == 'discount') ? $this->calcOfferItem($item->pivot->offer_id, $item->id) : $item->pivot->offer_price,
                    'offerId' => $item->pivot->offer_id,
                    'quantity' => $item->pivot->quantity
                ]);
                $hasOffer = 1;
                $is_valid = true;
            } else {
                $items[] = collect([
                    'item_id' => $item->id,
                    'extras' => [explode(', ', $item->pivot->item_extras)],
                    'withouts' => [explode(', ', $item->pivot->item_withouts)],
                    'price' => Item::find($item->id)->price,
                    'dough_type_ar' => $item->pivot->dough_type_ar,
                    'dough_type_en' => $item->pivot->dough_type_en,
                    'quantity' => $item->pivot->quantity,
                ]);
                if ($item->pivot->offer_id == null) {
                    $order_items = [];
                    $noOffer_price = 0;
                    $order_items[] = [
                        "order_id" => $item->pivot->order_id,
                        "item_id" => $item->id,
                        'quantity' => $item->pivot->quantity,
                        "item_extras" => $item->pivot->item_extras,
                        "item_withouts" => $item->pivot->item_withouts,
                        "dough_type_ar" => $item->pivot->dough_type_ar,
                        'dough_type_en' => $item->pivot->dough_type_en,
                        'price' => Item::find($item->id)->price + Extra::whereIn('id', explode(', ', $item->pivot->item_extras))->sum('price'),
                        "offer_price" => null,
                        "offer_id" => null,
                        "offer_last_updated_at" => null,
                        "extras" => Extra::whereIn('id', explode(', ', $item->pivot->item_extras))->get(),
                        "withouts" => Without::whereIn('id', explode(', ', $item->pivot->item_withouts))->get(),
                        "item" => $item,
                        "calories" => $item->calories,
                    ];
                    $noOffer_price = Item::find($item->id)->price * $item->pivot->quantity;
                    if ($item->pivot->item_extras) {
                        $noOffer_price += Extra::whereIn('id', explode(', ', $item->pivot->item_extras))->sum('price') * $item->pivot->quantity;
                    }
                    $noOffers[] = [
                        'offers' => [],
                        'order_items' => $order_items,
                        'final_item_price' => $noOffer_price,
                    ];
                }
            }
            if ($hasOffer) {
                $order_items = [];
                $details = 0;
                $Offer_price = 0;
                $order_items[] = [
                    "order_id" => $item->pivot->order_id,
                    "item_id" => $item->id,
                    'quantity' => $item->pivot->quantity,
                    "item_extras" => $item->pivot->item_extras,
                    "item_withouts" => $item->pivot->item_withouts,
                    "dough_type_ar" => $item->pivot->dough_type_ar,
                    'dough_type_en' => $item->pivot->dough_type_en,
                    'price' => Item::find($item->id)->price + Extra::whereIn('id', explode(', ', $item->pivot->item_extras))->sum('price'),
                    "offer_price" => ((Offer::find($item->pivot->offer_id))['offer_type'] == 'discount') ? $this->calcOfferItem($item->pivot->offer_id, $item->id) + Extra::whereIn('id', explode(', ', $item->pivot->item_extras))->sum('price') : $item->pivot->offer_price,
                    "offer_id" => $item->pivot->offer_id,
                    "extras" => Extra::whereIn('id', explode(', ', $item->pivot->item_extras))->get(),
                    "withouts" => Without::whereIn('id', explode(', ', $item->pivot->item_withouts))->get(),
                    "item" => $item,
                    "type" => (Offer::find($item->pivot->offer_id))['offer_type'],
                ];

                if ($is_valid == true) {
                    $Offer_price = (((Offer::find($item->pivot->offer_id))['offer_type'] == 'discount') ? $this->calcOfferItem($item->pivot->offer_id, $item->id) : $item->pivot->offer_price) * $item->pivot->quantity;
                    if ($item->pivot->item_extras) {
                        $Offer_price += Extra::whereIn('id', explode(', ', $item->pivot->item_extras))->sum('price') * $item->pivot->quantity;
                    }
                } else {

                    $message = __('general.offer deleted');
                    $validation = false;
                    return $this->sendResponse(['message' => $message, 'validation' => $validation, 'items' => (object)[]], '');

                    $Offer_price = (Item::find($item->id)->price) * $item->pivot->quantity;
                    if ($item->pivot->item_extras) {
                        $Offer_price += Extra::whereIn('id', explode(', ', $item->pivot->item_extras))->sum('price') * $item->pivot->quantity;
                    }
                }
                $offer = Offer::find($item->pivot->offer_id);
                if ((Offer::find($item->pivot->offer_id))['offer_type'] == 'discount') {
                    $offer['details'] = OfferDiscount::where('offer_id', $offer->id)->latest()->first();
                } else {
                    $offer['details'] = OfferBuyGet::where('offer_id', $offer->id)->latest()->first();
                }
                $offers[] = [
                    'offer' => $offer,
                    'order_items' => $order_items,
                    // 'is_valid' => $is_valid,
                    'final_offer_price' => $Offer_price,
                ];
            }
        }

        $requestt = new \Illuminate\Http\Request();
        $requestt = $request->merge([
            'subtotal' => ($deletedOfferPrice != 0) ? $deletedOfferPrice : $order->subtotal,
        ]);
        $requestt = $request->merge([
            'taxes' => round($requestt->subtotal * .15, 2),
        ]);

        if ($order->points_paid != 0) {
            if ($request->points_paid != 0) {
                $requestt = $request->merge([
                    'total' => ($deletedOfferPrice != 0) ? $deletedOfferPrice + $order->delivery_fees + $requestt->taxes - $request->points_paid : $order->total + $order->points_paid - $request->points_paid,
                ]);
            } else {
                $requestt = $request->merge([
                    'total' => ($deletedOfferPrice != 0) ? $deletedOfferPrice + $order->delivery_fees + $requestt->taxes : $order->total + $order->points_paid,
                ]);
            }
        } else {
            if ($request->points_paid != 0) {
                $requestt = $request->merge([
                    'total' => ($deletedOfferPrice != 0) ? $deletedOfferPrice + $order->delivery_fees + $requestt->taxes - $request->points_paid : $order->total - $request->points_paid,
                ]);
            } else {
                $requestt = $request->merge([
                    'total' => ($deletedOfferPrice != 0) ? $deletedOfferPrice + $order->delivery_fees + $requestt->taxes : $order->total,
                ]);
            }
        }

        $requestt = $request->merge([
            'delivery_fees' => $order->delivery_fees,
            'points_paid' => $request->points_paid ? $request->points_paid : 0,
            'branch_id' => $order->branch_id,
            'address_id' => $order->address_id,
            'service_type' => $order->service_type,
            'items' => $items,
            'customer_id' => $order->customer_id,
            'payment_type' => $request->payment_type,
        ]);

        // Get address or branch based on service_type
        $location = [
            'service_type' => $order->service_type
        ];
        if ($order->service_type == 'takeaway') {
            $location['branch'] = $order->branch;
        } else {
            $location['address'] = $order->address;
        }
        $delivery_fees = $order->service_type == 'delivery' ? 10 : 0;

        // remove 50% discount if user trying to reorder an order that has this offer
        $total = $this->removeDiscountIfNotFirstOrder(request()->user(), $requestt->total);

        $subtotal = $requestt->subtotal;
        $taxes = $requestt->taxes;
        $allItems = array_merge($noOffers, $offers);
        $reorder = compact('location', 'allItems', 'total', 'subtotal', 'taxes', 'delivery_fees');
        
        // confirm order
        // show popup if offer have changes or price changed

        if ($request->has('confirm') && $request->input('confirm')) {
            // return $requestt;
            $return = $this->store($requestt);
            if ($return->getOriginalContent()['success']) {
                return $this->sendResponse($return->getOriginalContent()['data'], 'Order confirmed successfully');
            }
        }

        return $this->sendResponse(['message' => $message, 'validation' => $validation, 'items' => $reorder], '');
    }

    public function getById(Request $request, Order $order)
    {
        return $this->sendResponse($order->toArray(), 'Order retrieved successfully.');
    }

    public function acceptOrder(Request $request, Order $order)
    {

        if ($order->state != 'pending') {
            return $this->sendError('You cannot accept this order', 400);
        }

        $order->update(['state' => 'in-progress']);

        \App\Http\Controllers\NotificationController::pushNotifications($order->customer_id, "Your Order has been Accepted, لقد تم قبول طلبك", "Order");
        return $this->sendResponse($order->toArray(), __('general.Order has been accepted'));
    }

    public function rejectOrder(Request $request, Order $order)
    {
        if ($order->state != 'pending') {
            return $this->sendError(__('general.You cannot reject this order!'), 400);
        }

        $order->update(['state' => 'rejected', 'cancellation_reason' => $request->cancellation_reason]);


        if ($order->points_paid != 0 && is_int($order->points)) {
            
            $point = PointsTransaction::where('order_id', $order->id)->where('user_id', $order->customer_id)->where('points', $order->points)->where('status', 2)->first();
            if ($point) {
                $point->status = 3; // rejected
                $point->save();
            }
        }


        \App\Http\Controllers\NotificationController::pushNotifications($order->customer_id, "Your Order has been Rejected, لقد تم رفض طلبك", "Order");
        return $this->sendResponse($order->toArray(), __('general.Order has been rejected'));
    }

    public function completeOrder(Request $request, Order $order)
    {

        if ($order->state != 'in-progress') {
            return $this->sendError(__('general.You cannot complete this order'));
        }

        $order->update(['state' => 'completed']);


        $point = PointsTransaction::where('order_id', $order->id)->where('user_id', $order->customer_id)->where('points', $order->points)->where('status', 2)->first();
        if ($point) {
            $point->status = 4; // completed
            $point->save();
        }

        PointsTransaction::create([
            'points' => round($order->total),
            'user_id' => $order->customer_id,
            'order_id' => $order->id,
            'status' => 0
        ]);


        if ($order->service_type == 'delivery') {
            \App\Http\Controllers\NotificationController::pushNotifications($order->customer_id, "Your Order is on the way, الطلب في الطريق إليك", "Order");
            return $this->sendResponse($order->toArray(), __('general.Order is on the way'));
        }

        if ($order->service_type == 'takeaway') {
            \App\Http\Controllers\NotificationController::pushNotifications($order->customer_id, "Your Order has been completed, تم تجهيز الطلب", "Order");
            return $this->sendResponse($order->toArray(), __('general.Order has been completed'));
        }
    }

    public function cancelOrder(Request $request, Order $order)
    {

        if ($order->state == 'completed' or $order->state == 'rejected') {
            return $this->sendError(__('general.You cannot cancel this order'));
        }

        $order->update(['state' => 'canceled', 'cancellation_reason' => $request->cancellation_reason]);


        if ($order->points_paid != 0 && is_int($order->points)) {
            // PointsTransaction::create([
            //     'points' => $order->points,
            //     'user_id' => $order->customer_id,
            //     'order_id' => $order->id,
            //     'status' => 4
            // ]);
            $point = PointsTransaction::where('order_id', $order->id)->where('user_id', $order->customer_id)->where('points', $order->points)->where('status', 2)->first();
            if ($point) {
                $point->status = 1; // canceled
                $point->save();
            }
        }

        \App\Http\Controllers\NotificationController::pushNotifications($order->customer_id, "Your Order has been Cancelled, لقد تم إلغاء طلبك", "Order");
        return $this->sendResponse($order->toArray(), __('general.Order has been canceled'));
    }

    public function getBranch(Request $request)
    {
        $customer = User::where('id', $request->customer_id)->whereHas('roles', function ($role) {
            $role->where('name', 'customer');
        })->first();

        $customerAddress = $customer->addresses->where('id', $request->address_id)->first();

        // get the branch covers customer area and open
        $area = $customerAddress->area;
        if ($area) {
            $branch = DB::table('branch_delivery_areas')->where('area_id', $area->id . "")->first();

            if ($branch) {
                $branch = Branch::find($branch->branch_id);

                if ($branch) {
                    $branch_id = $branch->id;
                    return $this->sendResponse($branch_id, 'Related Branch');
                } else {
                    return $this->sendError(__('general.sorry there is no branch cover this area'));
                }
            } else {
                return $this->sendError(__('general.sorry there is no branch cover this area'));
            }
        } else {
            return $this->sendError(__('general.sorry there is no branch cover this area'));
        }
    }

    protected function calcOfferItem($offer_id, $item_id)
    {
        $price = Item::find($item_id)->price;
        $offer = Offer::find($offer_id);
        $offerDiscount = OfferDiscount::where('offer_id', $offer->id)->latest()->first();
        if ($offerDiscount->discount_type == 1) {
            $disccountValue = $price * $offerDiscount->discount_value / 100;
            return $price - $disccountValue;
        } elseif ($offerDiscount->discount_type == 2) {
            return $price - $offerDiscount->discount_value;
        }
    }

    public function pointValues(Request $request)
    {
        $points = General::where('key', 'pointsValue')->get();

        return $this->sendResponse($points, 'get point values');
    }

    public function getPointsHistory(Request $request)
    {
        // history
        $completed = Order::where('state', 'completed')->where('customer_id', Auth::id())->where('points', '!=', null)->get();
        $points_still = PointsTransaction::where('status', 0)->where('user_id', Auth::id())->get();
        $pending = PointsTransaction::where('status', 2)->where('user_id', Auth::id())->get();

        $history = [];
        
        foreach ($points_still as $point) {
            $history[] = (object)[
                'points' => (int)$point->points,
                'order_id' => (int)$point->order_id,
                'created_at' => $point->created_at
            ];
        }
        foreach ($completed as $order) {
            $history[] = (object)[
                'points' => $order->points * -1,
                'order_id' => $order->id,
                'created_at' => $order->updated_at
            ];
        }
        foreach ($pending as $point) {
            $history[] = (object)[
                'points' => (int)$point->points * -1,
                'order_id' => (int)$point->order_id,
                'created_at' => $point->created_at
            ];
        }

        $res = (collect($history))->sortBy('order_id');

        return $this->sendResponse($res, 'user points history');
    }

    public function getPointsScreen(Request $request)
    {
        // user points
        $validRefundedPoints = Auth::user()->points_transactions()->whereIn('status', [0, 3, 4])->get()->sum('points');
        $consumedCanceledPoints = Auth::user()->points_transactions()->whereIn('status', [2])->get()->sum('points');
        $user_points = $validRefundedPoints - $consumedCanceledPoints;

        // points table
        $point_values = General::where('key', 'pointsValue')->get();
        $point_values->map(function (General $general) {
            $general->addHidden('for');
            return $general;
        });

        // history
       // history
       $completed = Order::where('state', 'completed')->where('customer_id', Auth::id())->where('points', '!=', null)->get();
       $points_still = PointsTransaction::where('status', 0)->where('user_id', Auth::id())->get();
       $pending = PointsTransaction::where('status', 2)->where('user_id', Auth::id())->get();

       $history = [];
       
       foreach ($points_still as $point) {
           $history[] = (object)[
               'points' => (int)$point->points,
               'order_id' => (int)$point->order_id,
               'created_at' => $point->created_at
           ];
       }
       foreach ($completed as $order) {
           $history[] = (object)[
               'points' => $order->points * -1,
               'order_id' => $order->id,
               'created_at' => $order->updated_at
           ];
       }
       foreach ($pending as $point) {
           $history[] = (object)[
               'points' => (int)$point->points * -1,
               'order_id' => (int)$point->order_id,
               'created_at' => $point->created_at
           ];
       }

        $history = (collect($history))->sortBy('order_id')->values();

        return $this->sendResponse(compact('user_points', 'point_values', 'history'), 'loyality screen');
    }
    public function today_orders(Request $request, OrderFilters $filters)
    {

        $orders = Order::filter($filters);

        $user_branches = Auth::user()->branches()->pluck('branches.id')->toArray();

        if (!empty($user_branches)) {
            $orders = $orders->whereIn('branch_id', $user_branches);
        }

        $orders = $orders->with(['customer', 'branch', 'items'])->with(['address' => function ($address) {
            $address->with(['city', 'area']);
        }])->whereRaw('Date(created_at) >= CURDATE()')->orderBy('id', 'DESC')->get();


        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $extras = $item->pivot->item_extras;
                $extras = $extras ? explode(", ", $extras) : [];

                $withouts = $item->pivot->item_withouts;
                $withouts = $withouts ? explode(", ", $withouts) : [];



                $all_extras = [];
                foreach ($extras as $extra) {
                    $all_extras[] = Extra::find($extra);
                }

                $all_withouts = [];
                foreach ($withouts as $without) {
                    $all_withouts[] = Without::find($without);
                }

                $item->extras = $all_extras;
                $item->withouts = $all_withouts;
            }
        }

        return $this->sendResponse($orders->toArray(), 'Orders retrieved successfully.');
    }

    public function order_history(Request $request, OrderFilters $filters)
    {

        $orders = Order::filter($filters);

        $user_branches = Auth::user()->branches()->pluck('branches.id')->toArray();

        if (!empty($user_branches)) {
            $orders = $orders->whereIn('branch_id', $user_branches)->whereIn('state', ['completed', 'canceled', 'rejected']);
        }

        $orders = $orders->with(['customer', 'branch', 'items'])->with(['address' => function ($address) {
            $address->with(['city', 'area']);
        }])->whereRaw('Date(created_at) < CURDATE()')->orderBy('id', 'DESC')->get();


        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $extras = $item->pivot->item_extras;
                $extras = $extras ? explode(", ", $extras) : [];

                $withouts = $item->pivot->item_withouts;
                $withouts = $withouts ? explode(", ", $withouts) : [];



                $all_extras = [];
                foreach ($extras as $extra) {
                    $all_extras[] = Extra::find($extra);
                }

                $all_withouts = [];
                foreach ($withouts as $without) {
                    $all_withouts[] = Without::find($without);
                }

                $item->extras = $all_extras;
                $item->withouts = $all_withouts;
            }
        }
        return $this->sendResponse($orders->toArray(), 'Orders retrieved successfully.');
    }

    public function make_order_payment(Request $request)
    {

        $paymentId = Payment::where('payment_id', $request->id)->where('hash', session('payment_hash'))->first();

        if (!$paymentId) {
            session()->flash('error', 'payment id is not valid');
            return redirect()->route('payment');
        }

        $testMessage = ' (Test Environment)';

        if ($request->status == 'paid' && $request->message == "Succeeded!$testMessage") {

            $payment = \Moyasar\Facades\Payment::fetch($request->id);

            abort_if($payment->status !== 'paid' || $payment->amount !== (int)$paymentId->total_paid, 404);

            session()->flash('success', __('general.Order Payed Successfully'));
            session()->forget('payment_hash');
            // session(['payment' => $paymentId->toArray()]);
            $paymentId->status = $request->status;
            $paymentId->message = $request->message;
            $paymentId->data = $payment->toJson();
            // $paymentId->order_id = $return['data']['id'];
            $paymentId->save();

            return view('api.payment_response');
        } else {

            if ($request->status == 'failed') {
                session()->flash('error', strtolower(str_replace(" (Test Environment)", "", $request->message)));

                // delete this payment from payments
                $paymentId->delete();

                return redirect(route('get.paymentMobile', [
                    session('user_id'), session('payment_amount'), session('payment_hash')
                ]));
            }
            session()->flash('error', __('general.error'));
            return redirect()->route('get.paymentMobile', [
                session('user_id'), session('payment_amount'), session('payment_hash')
            ]);
        }
    }
}
