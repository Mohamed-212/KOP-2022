<?php

namespace App\Http\Controllers\Admin;

use App\Models\General;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Session;

use App\Traits\LogfileTrait;
use App\Models\Gift;
use App\Models\GiftsOrder;
use App\Models\Order;
use App\Models\PointsTransaction;
use App\Models\User;
use DB;

class GiftController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use LogfileTrait;

    public function index()
    {
        $gifts = Gift::orderBy('id', 'DESC')->get();
        $this->Make_Log('App\Models\Gift','view',0);
        return view('admin.gift.index', compact('gifts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.gift.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|min:3|max:30',
            'name_en' => 'required|min:3|max:30',
            'points' => 'required|numeric',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        $branch = Gift::create([
            'name' => $request->name,
            'name_en' => $request->name_en,
            'points' => $request->points,
            'image' => $request->image,
        ]);
        if ($request->hasFile('image')) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move(public_path('branchs'), $image_new_name);
            $branch->image = '/branchs/' . $image_new_name;
            $branch->save();
        }

        $this->Make_Log('App\Models\Gift','create',$branch->id);
        return redirect()->route('admin.gift.index')->with([
            'type' => 'success',
            'message' => 'Gift insert successfuly'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Gift $gift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Gift $gift)
    {
        return view('admin.gift.edit', compact('gift'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gift $gift)
    {

        $attributes = $request->validate([
            'name' => 'required|min:3|max:30',
            'name_en' => 'required|min:3|max:30',
            'points' => 'required|numeric'
        ]);

        $gift->update([
            'name' => $request->name,
            'name_en' => $request->name_en,
            'points' => $request->points
        ]);

        if ($request->hasFile('image')) {
            $gift->update([
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);


            if ($request->hasFile('image')) {
                $image = $request->image;
                $image_new_name = time() . $image->getClientOriginalName();
                $image->move(public_path('gifts'), $image_new_name);
                $gift->image = '/gifts/' . $image_new_name;
                $gift->save();
            }
        }
        $this->Make_Log('App\Models\Gift','update',$gift->id);
        Session::flash('success', 'Gift has been updated');
        return redirect()->route('admin.gift.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gift $gift)
    {
        $gift->delete();
        $this->Make_Log('App\Models\Gift','delete',$gift->id);

        return redirect()->route('admin.gift.index');
    }


    public function showGiftsOrders()
    {
        $orders = GiftsOrder::get();
        return view('admin.gift.showGiftsOrders', compact('orders'));
    }

    public function pointsValue()
    {
        $points = DB::table('general')->where('key', 'pointsValue')->get();

        // $value = 0;
        // if($pointValue){
        //     $value = $pointValue->value;
        // }
        return view('admin.points.index', compact('points'));
    }

    public function pointsValuePost(Request $request)
    {
        $attributes = $request->validate([
            'value' => 'required|numeric|min:0',
            'for' => 'required|numeric|min:0'
        ]);

        $value = General::create([
            'value' => $request->value,
            'for' => $attributes['for'],
            'key' => 'pointsValue',
        ]);
        $this->Make_Log('App\Models\General','update',$value->id);
        return back()->with([
            'type' => 'success',
            'message' => 'Value Updated Successfuly'
        ]);
    }

    public function showPointsTransactions()
    {
        $transactions = PointsTransaction::orderBy('id', 'DESC')->groupBy('user_id')->get();
        return view('admin.gift.showPointsTransactions', compact('transactions'));
    }

    public function showPointsTransactionsForUser($id)
    {
        $user = User::findOrFail($id);

        // history
        $completed = Order::where('state', 'completed')->where('customer_id', $user->id)->where('points', '!=', null)->where('points', '>', 0)->get();
        $points_still = PointsTransaction::where('status', 0)->where('user_id', $user->id)->get();
        $pending = PointsTransaction::where('status', 2)->where('user_id', $user->id)->get();

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

        $history = (collect($history))->sortBy('order_id');

        $transactions = PointsTransaction::orderBy('id', 'DESC')->where('user_id', $id)->get();
        return view('admin.gift.showPointsTransactionsForUser', compact('transactions', 'history'));
    }
}
