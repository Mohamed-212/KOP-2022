<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\Branch;
use App\Models\Category;
use App\Models\User;
use App\Traits\LogfileTrait;


class HomeController extends Controller
{
    use LogfileTrait;
    public function index()
    {

        // dd(auth()->user()->id);
        // orders
        $ordersCount = Order::where('state', 'pending')->count();

        // branches
        $branchesCount = Branch::count();

        // categories
        $categoriesCount = Category::count();

        // customers
        $customersCount = User::whereHas('roles', function($role) {
            $role->where('name', 'customer');
        })->count();

        $this->Make_Log('App\Models\dashboard','view',0);

        if (auth()->user()->hasRole('branch_manager')) {

            $ordersCount = Order::where('state', 'pending')->where(function($q) {
                return $q->whereIn('branch_id', auth()->user()->branches);
            })->count();
            return view('admin.dashboard_branch_manager', compact('ordersCount'));
        }

        return view('admin.dashboard', compact('ordersCount', 'branchesCount', 'categoriesCount', 'customersCount'));
    }
}
