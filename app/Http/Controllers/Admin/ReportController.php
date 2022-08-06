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

use App\Filters\CustomerFilter;
use App\Filters\ItemFilters;
use App\Filters\ExtraFilters;
use App\Filters\OrderFilters;
use App\Filters\IncomeFilters;

class ReportController extends Controller
{

    public function getCustomer(Request $requets, CustomerFilter $filters)
    {
        $customers = User::whereHas('roles', function($role){
            $role->where('name', 'customer');
        })->filter($filters)->orderBy('id', 'DESC')->get();
    	return view('admin.report.customer' , compact('customers'));
   	}

    public function getOrder(Request $request, OrderFilters $filters)
    {
        $orders = Order::when(request()->order_from, function ($q) {
            return $q->where('order_from', request()->order_from);
        })->orderBy('id', 'DESC')->get();
         return view('admin.report.order' , compact('orders'));
    }

    public function getOrderItems(Request $request, ItemFilters $filters)
    {
        $orders = Order::filter($filters)->where('state', 'completed')->orderBy('id', 'DESC')->get();
        $branches = Branch::orderBy('id', 'DESC')->get();

        return view('admin.report.order-item' , compact('orders', 'branches'));
    }

    public function getIncome(Request $request, IncomeFilters $filters)
    {
        $orders = Order::filter($filters)->where('state', 'completed')->orderBy('id', 'DESC')->get();
        // $orders = Order::when(request()->order_from, function ($q) {
        //     return $q->where('order_from', request()->order_from)->where('state', 'completed');
        // })->orderBy('id', 'DESC')->get();
        $branches = Branch::orderBy('id', 'DESC')->get();
        return view('admin.report.income' , compact('orders', 'branches'));
    }

    public function getItem(Request $request, ItemFilters $filters)
    {
        $categories = Category::orderBy('id', 'DESC')->get();
        $items = Item::filter($filters)->orderBy('id', 'DESC')->get();
        return view('admin.report.item' , compact('items', 'categories'));
    }

    public function getExtra(Request $request, ExtraFilters $filters)
    {
       $categories = Category::orderBy('id', 'DESC')->get();
        $extras = Extra::filter($filters)->orderBy('id', 'DESC')->get();
        return view('admin.report.extra' , compact('extras', 'categories'));
    }

    public function getOrderStatus(Request $request, OrderFilters $filters)
    {
        $orders = Order::when(request()->order_from, function ($q) {
            return $q->where('order_from', request()->order_from);
        })->orderBy('id', 'DESC')->get();
        return view('admin.report.order-status' , compact('orders'));
    }

    public function getOrderCustomer(Request $request, OrderFilters $filters)
    {
     $customers = User::whereHas('roles', function($role) {
            $role->where('name', 'customer');
        })->orderBy('id', 'DESC')->get();

        $orders = Order::filter($filters)->orderBy('id', 'DESC')->get();

        return view('admin.report.order-customer' , compact('orders', 'customers'));
    }


}
