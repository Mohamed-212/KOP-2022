<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Order;
use App\Filters\OrderFilters;
use App\Models\Address;
use App\Models\Branch;
use App\Models\Extra;
use App\Models\Offer;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\User;
use App\Models\Without;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\LogfileTrait;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     
    use LogfileTrait;

    public function index(OrderFilters $filters)
    {
        $user = Auth::user();
        if($user->hasRole('admin'))
        {
            $orders = Order::query();
            if(request()->order_from != 'all'){
                $orders->when(request()->order_from, function ($q) {
                    return $q->where('order_from', request()->order_from);
                });
            }
            $orders = $orders->orderBy('id', 'DESC')->get();
        }
        else{
            $branches = $user->branches->pluck('id')->toArray();
            $orders = Order::query();
            if(request()->order_from != 'all'){
                $orders->when(request()->order_from, function ($q) {
                    return $q->where('order_from', request()->order_from);
                });
            }
            $orders = $orders->whereIn('branch_id', $branches)->filter($filters)->orderBy('id', 'DESC')->get();
        }
        $this->Make_Log('App\Models\Order','view',0);
        return view('admin.order.index' , compact('orders'));
    }

    public function show(Request $request, $order_id)
    {
        $order = Order::find($order_id);

        $user = User::find($order->customer_id);

        $firstOrder = $order->is_first_order;

        $branch = $work_hours = null;
        if (isset($order->branch_id)) {
            $branch = Branch::where('id', $order->branch_id)->with(['city', 'area', 'deliveryAreas'])->with(['workingDays' => function ($day) {
                $day->where('day', strtolower(now()->englishDayOfWeek))->first();
            }])->first();

            $work_hours = $branch->workingDays()->where('day', strtolower(now()->englishDayOfWeek))->get();
        }

        $address = null;
        if ($order->address_id) {
            $address = Address::withTrashed()->find($order->address_id);
        }

        $items = $order->items;

        $payment = null;
        if ($order->payment_type === 'online') {
            $payment = Payment::where('order_id', $order->id)->where('customer_id', $order->customer_id)->first();
        }

        $items->map(function (&$item, $key) {
            $item->extras_objects = Extra::whereIn('id', explode(', ', $item->pivot->item_extras))->get();
            $item->withouts_objects = Without::whereIn('id', explode(', ', $item->pivot->item_withouts))->get();
            if ($item->pivot->offer_id) {
                $offer = Offer::find($item->pivot->offer_id);
                if ($offer->date_to > now()) {
                    $item['valid'] = 1;
                } else {
                    $item['valid'] = 0;
                }
            }
        });

        $orderDetails = OrderItem::where('order_id', $order_id)->get();
        
        $this->Make_Log('App\Models\Order','view details',$order_id);

        return view('admin.order.details' , compact('orderDetails', 'branch', 'work_hours', 'address', 'user', 'items', 'order', 'payment', 'firstOrder'));
    }
}
