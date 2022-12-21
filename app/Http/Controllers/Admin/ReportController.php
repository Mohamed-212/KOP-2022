<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Category;
use App\Models\Item;
use App\Models\Extra;
use App\Models\Branch;
use App\Traits\LogfileTrait;
use App\Filters\CustomerFilter;
use App\Filters\ItemFilters;
use App\Filters\ExtraFilters;
use App\Filters\OrderFilters;
use App\Filters\IncomeFilters;
use App\Filters\PaymentFilter;
use App\Models\Payment;

class ReportController extends Controller
{
    use LogfileTrait;
    public function getCustomer(Request $requets, CustomerFilter $filters)
    {
        $customers = User::whereHas('roles', function($role){
            $role->where('name', 'customer');
        })->filter($filters)->orderBy('id', 'DESC')->get();
        $this->Make_Log('App\Models\User','report',0);
    	return view('admin.report.customer' , compact('customers'));
   	}

    public function getOrder(Request $request, OrderFilters $filters)
    {
        $orders = Order::when(request()->order_from, function ($q) {
            return $q->where('order_from', request()->order_from);
        })->orderBy('id', 'DESC')->get();
        // dd($request->all());
        $this->Make_Log('App\Models\Order','report',0);
         return view('admin.report.order' , compact('orders'));
    }

    public function getOrderItems(Request $request, ItemFilters $filters)
    {
        $orders = Order::filter($filters)->where('state', 'completed')->orderBy('id', 'DESC')->get();
        $branches = Branch::orderBy('id', 'DESC')->get();
        $this->Make_Log('App\Models\OrderItems','report',0);
        return view('admin.report.order-item' , compact('orders', 'branches'));
    }

    public function getIncome(Request $request, IncomeFilters $filters)
    {
        $orders = Order::filter($filters)->where('state', 'completed')->orderBy('id', 'DESC')->get();
        // $orders = Order::when(request()->order_from, function ($q) {
        //     return $q->where('order_from', request()->order_from)->where('state', 'completed');
        // })->orderBy('id', 'DESC')->get();
        $branches = Branch::orderBy('id', 'DESC')->get();
        $this->Make_Log('App\Models\Income','report',0);
        return view('admin.report.income' , compact('orders', 'branches'));
    }

    public function getItem(Request $request, ItemFilters $filters)
    {
        $categories = Category::orderBy('id', 'DESC')->get();
        $items = Item::filter($filters)->orderBy('id', 'DESC')->get();
        $this->Make_Log('App\Models\Item','report',0);
        return view('admin.report.item' , compact('items', 'categories'));
    }

    public function getExtra(Request $request, ExtraFilters $filters)
    {
       $categories = Category::orderBy('id', 'DESC')->get();
        $extras = Extra::filter($filters)->orderBy('id', 'DESC')->get();
        $this->Make_Log('App\Models\Extra','report',0);
        return view('admin.report.extra' , compact('extras', 'categories'));
    }

    public function getOrderStatus(Request $request, OrderFilters $filters)
    {
        $orders = Order::when(request()->order_from, function ($q) {
            return $q->where('order_from', request()->order_from);
        })->orderBy('id', 'DESC')->get();
        $this->Make_Log('App\Models\OrderStatus','report',0);
        return view('admin.report.order-status' , compact('orders'));
    }

    public function getOrderCustomer(Request $request, OrderFilters $filters)
    {
     $customers = User::whereHas('roles', function($role) {
            $role->where('name', 'customer');
        })->orderBy('id', 'DESC')->get();
        $this->Make_Log('App\Models\OrderCustomer','report',0);
        $orders = Order::filter($filters)->orderBy('id', 'DESC')->get();

        return view('admin.report.order-customer' , compact('orders', 'customers'));
    }

    public function getPayments(Request $request, PaymentFilter $filters)
    {
        $payments = Payment::filter($filters)->orderBy('id', 'DESC')->get();
        $this->Make_Log('App\Models\Payment','report',0);
    	return view('admin.payment.index' , compact('payments'));
    }

    public function getOnePayment(Request $request, $id)
    {
        $py = Payment::findOrFail($id);

        return view('admin.payment.show' , compact('py'));
    }
}
