<?php

namespace App\Http\Controllers\Admin;

use File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\Offer;
use App\Models\OfferBuyGet;
use App\Models\OfferDiscount;
use App\Models\User;
use App\Models\Branch;
use Auth;
use Validator;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Storage;

use App\Traits\LogfileTrait;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use LogfileTrait;

    public function index()
    {
        $offers = Offer::with('buyGet')->with('discount')->where('description', 'descriptiondescriptiondescriptiondescription')->orderBy('created_at', 'DESC')->get();
        $this->Make_Log('App\Models\Offer','view',0);

        if (auth()->user()->hasRole('branch_manager')) {
            $user_branches = auth()->user()->branches;
            if (!empty($user_branches)) {
                $offer_id = DB::table("branch_offer")->whereIn('branch_id', $user_branches)->pluck('offer_id');
                $offers = Offer::whereIn('id', $offer_id)->with('buyGet')->with('discount')->orderBy('created_at', 'desc')->get();
            }
        } else {
            $offers = Offer::with('buyGet')->with('discount')->orderBy('created_at', 'DESC')->get();
        }

        return view('admin.offer.index', compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $branches = Branch::get();
        return view('admin.offer.create', compact('categories','branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            //'title' => 'required|min:3|max:20',
            //'title_ar' => 'required|min:3|max:20',
            'title' => 'required',
            'title_ar' => 'required',
            'service_type' => 'required|in:takeaway,delivery,all',
            'date_from' => 'required|date|before_or_equal:date_to',
            'date_to' => 'required|date',
            'branches' => 'required|array',
            'description' => 'nullable',
            'description_ar' => 'nullable',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|dimensions:width=550,height=465',
            'website_image' => 'required|mimes:jpeg,png,jpg,gif,svg|dimensions:width=509,height=459',
            'website_image_menu' => 'required|mimes:jpeg,png,jpg,gif,svg|dimensions:width=300,height=300',
            'offer_type' => 'required',
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors())->withInput();




        if ($request->offer_type == 'discount') {

            $validator = Validator::make($request->all(), [
                'discount_quantity' => 'required',
                'category_id' => 'required',
                'items' => 'required',
                'discount_type' => 'required',
                'discount_value' => 'required'
            ]);

            if ($validator->fails())
                return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        if ($request->offer_type == 'buy-get') {
            $validator = Validator::make($request->all(), [
                'buy_quantity' => 'required',
                'buy_category_id' => 'required',
                'buy_items' => 'required',
                'get_quantity' => 'required',
                'get_category_id' => 'required',
                'get_items' => 'required',
                'offer_price' => 'required'
            ]);

            if ($validator->fails())
                {return redirect()->back()->withErrors($validator->errors())->withInput();}

        }

        $services=($request->service_type=="all")?['takeaway','delivery']:[$request->service_type];
      
        if ($request->hasFile('image')) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move(public_path('offers'), $image_new_name);
            $mobile_image = '/offers/' . $image_new_name;
        } else {
            $mobile_image = '';
        }
        
        if ($request->hasFile('website_image')) {
            $image = $request->website_image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move(public_path('offers'), $image_new_name);
            $website_image = '/offers/' . $image_new_name;
        } else {
            $website_image = '';
        }
        if ($request->hasFile('website_image_menu')) {
            $image = $request->website_image_menu;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move(public_path('offers'), $image_new_name);
            $website_image_menu = '/offers/' . $image_new_name;
        } else {
            $website_image_menu = '';
        }
        
    foreach($services as $service)
    {
        $offer = Offer::create([
                'title' => $request->title,
                'title_ar' => $request->title_ar,
                'service_type' => $service,
                'date_from' =>  Carbon::createFromFormat('Y-m-d\TH:i', $request->date_from),
                'date_to' =>  Carbon::createFromFormat('Y-m-d\TH:i', $request->date_to),
                'description' => $request->description,
                'description_ar' => $request->description_ar,
                'image' => '',
                'offer_type' => $request->offer_type,
                'created_by' => $request->user()->id
            ]);
            $offer->website_image=$website_image;
            $offer->website_image_menu=$website_image_menu;
            $offer->image=$mobile_image;
            $offer->save();

        $this->Make_Log('App\Models\Offer','create',$offer->id);

 

        if ($request->has('buy_quantity') && $request->buy_quantity != null) {
            $buy_get_offer = OfferBuyGet::create([
                'offer_id' => $offer->id,
                'buy_quantity' => $request->buy_quantity,
                'buy_category_id' => $request->buy_category_id,
                'get_quantity' => $request->get_quantity,
                'get_category_id' => $request->get_category_id,
                'offer_price' => $request->offer_price,
            ]);
            $this->Make_Log('App\Models\OfferBuyGet','create',$buy_get_offer->id);
            $buy_get_offer->buyItems()->sync($request->buy_items);
            $buy_get_offer->getItems()->sync($request->get_items);
        }

        if ($request->offer_type == 'discount' && $request->has('discount_quantity') && $request->discount_quantity != null) {

            if (!$request->items) {
                return redirect()->back();
            }

            $discountOffer = OfferDiscount::create([
                'offer_id' => $offer->id,
                'quantity' => 1,
                'category_id' => $request->category_id,
                'discount_type' => $request->discount_type,
                'discount_value' => $request->discount_value,
            ]);
            $this->Make_Log('App\Models\OfferDiscount','create',$discountOffer->id);
            $discountOffer->items()->sync($request->items);
        }


        $users = User::whereHas('roles', function ($role) {
            $role->where('name', 'customer');
        })->get();
        $offer->branches()->sync($request->branches);
        
    }
        foreach ($users as $user) {
            \App\Http\Controllers\NotificationController::pushNotifications($user->id,  "New Offer: " . $request->title, "Offer");
        }

        return redirect()->route('admin.offer.index')->with([
            'type' => 'success',
            'message' => 'Offer insert successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        $branches = Branch::get();
        return view('admin.offer.show', compact('offer', 'branches'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {

        // switch ($offer->offer_type) {
        //     case 'buy-get':
        //         $buy_items = $offer->buyGet->buy_items;
        //         if (strlen($buy_items) > 1) {
        //             $buy_items = explode(',', $buy_items);
        //         } else {
        //             $buy_items = array($buy_items);
        //         }
        //         $get_items = $offer->buyGet->get_items;
        //         if (strlen($get_items) > 1) {
        //             $get_items = explode(',', $get_items);
        //         } else {
        //             $get_items = array($get_items);
        //         }

        //         $buyItemsIds = explode(',', $offer->buyGet->buy_items);
        //         $buyItems = Item::whereIn('id', $buyItemsIds)->get();
        //         // dd($buyItems, $buyItemsIds);

        //         $getItemsIds = explode(',', $offer->buyGet->get_items);
        //         $getItems = Item::whereIn('id', $getItemsIds)->get();
        //         // dd($getItems, $getItemsIds);

        //         foreach ($getItems as $item) {

        //             if ($offer->buyGet->offer_price) {
        //                 $disccountValue = $item->price * $offer->buyGet->offer_price / 100 ;
        //                 $item->offer_price = $item->price - $disccountValue;
        //             } else {
        //                 $item->offer_price = 0;
        //             }
        //         }

        //         $items['buy_items'] = $buyItems;
        //         $items['get_items'] = $getItems;

        //         break;

        //     case 'discount':
        //         $items = $offer->discount->items;
        //         if (strlen($items) > 1) {
        //             $items = explode(',', $items);
        //         } else {
        //             $items = array($items);
        //         }
        //         $items = \App\Models\Item::whereIn('id', $items)->get();
        //         break;
        //     default:
        //         $items = array();
        //         break;
        // }
        $categories = \App\Models\Category::all();
        $branches = Branch::get();
        return view('admin.offer.edit', compact('offer', 'categories','branches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        $attributes = $request->validate([
            //'title' => 'required|min:3|max:20',
            //'title_ar' => 'required|min:3|max:20',
            'title' => 'required',
            'title_ar' => 'required',
            'service_type' => 'required',
            'date_from' => 'required|date',
            'date_to' => 'required|date',
            'branches' => 'required|array',
            'description' => 'nullable',
            'description_ar' => 'nullable',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|dimensions:width=550,height=465',
            'website_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|dimensions:width=509,height=459',
            'website_image_menu' => 'nullable|mimes:jpeg,png,jpg,gif,svg|dimensions:width=300,height=300',
            'offer_type' => 'required',
        ]);
        // $branches = implode(",", $request->get('branches'));


        if ($request->hasFile('image')) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move(public_path('offers'), $image_new_name);
            $offer->image = '/offers/' . $image_new_name;
            $offer->save();
        }

        if ($request->hasFile('website_image')) {
            $image = $request->website_image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move(public_path('offers'), $image_new_name);
            $offer->website_image = '/offers/' . $image_new_name;
            $offer->save();
        }
        if ($request->hasFile('website_image_menu')) {
            $image = $request->website_image_menu;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move(public_path('offers'), $image_new_name);
            $offer->website_image_menu = '/offers/' . $image_new_name;
            $offer->save();
        }

        $offer->update([
            'title' => $request->title,
            'title_ar' => $request->title_ar,
            'service_type' => $request->service_type,
            'date_from' =>  Carbon::createFromFormat('Y-m-d\TH:i', $request->date_from),
            'date_to' =>  Carbon::createFromFormat('Y-m-d\TH:i', $request->date_to),

            // 'branches' => $branches,
            'description' => $request->description,
            'description_ar' => $request->description_ar,
            'offer_type' => $request->offer_type,
            'updated_by' => Auth::user()->id
        ]);
        $offer->branches()->detach();
        $offer->branches()->syncWithoutDetaching($request->branches);
        $this->Make_Log('App\Models\Offer','updete',$offer->id);
        if ($request->offer_type == 'discount') {

            $validator = Validator::make($request->all(), [
                'discount_quantity' => 'required',
                'category_id' => 'required',
                'items' => 'required',
                'discount_type' => 'required',
                'discount_value' => 'required'
            ]);

            if ($validator->fails())
                return redirect()->back()->withErrors($validator->errors());
        }

        if ($request->offer_type == 'buy-get') {

            $validator = Validator::make($request->all(), [
                'buy_quantity' => 'required',
                'buy_category_id' => 'required',
                'buy_items' => 'required',
                'get_quantity' => 'required',
                'get_category_id' => 'required',
                'get_items' => 'required',
                'offer_price' => 'required'
            ]);

            if ($validator->fails())
                return redirect()->back()->withErrors($validator->errors());
        }

        if ($request->has('buy_quantity') && $request->buy_quantity != null) {

            $action_id=$offer->buyGet()->updateOrCreate([
                'offer_id' => $offer->id,
                'buy_quantity' => $request->buy_quantity,
                'buy_category_id' => $request->buy_category_id,
                'get_quantity' => $request->get_quantity,
                'get_category_id' => $request->get_category_id,
                'offer_price' => $request->offer_price,
            ]);

            $offer->buyGet->buyItems()->sync($request->buy_items);
            $offer->buyGet->getItems()->sync($request->get_items);
            $now = new DateTime();
            $offer->updated_at = $now;
            $offer->save();
            $this->Make_Log('App\Models\OfferBuyGet','updete',$action_id);
        }

        if ($request->has('discount_quantity') && $request->discount_quantity != null) {
            $offer->discount->offer_id = $offer->id;
            $offer->discount->quantity = $request->discount_quantity;
            $offer->discount->category_id = $request->category_id;
            $offer->discount->discount_type = $request->discount_type;
            $offer->discount->discount_value = $request->discount_value;
            $offer->discount->save();
            $offer->discount->items()->sync($request->items);
            $now = new DateTime();
            $offer->updated_at = $now;
            $offer->save();
            $this->Make_Log('App\Models\OfferDiscount','updete',$offer->discount->id);
        }

        return redirect()->route('admin.offer.index')->with([
            'type' => 'success',
            'message' => 'Offer updated successfuly'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        $offer->delete();
        $this->Make_Log('App\Models\Offer','delete',$offer->id);

        return redirect()->route('admin.offer.index')->with([
            'type' => 'error',
            'message' => 'Offer deleted successfully'
        ]);
    }

    public function setAsMain(Request $request, Offer $offer)
    {
        // check if main offers more than two
        $count = Offer::where('main', true)->count();

        // if ($count >= 2) {
        //     return  redirect()->route('admin.offer.index')->with([
        //         'type' => 'error',
        //         'message' => 'you can not add more than 2 offers at homepage'
        //     ]);
        // }

        $offer->main = true;
        $offer->save();

        return  redirect()->route('admin.offer.index')->with([
            'type' => 'success',
            'message' => 'Offer added to homepage successfully'
        ]);
    }

    public function removeFromMain(Request $request, Offer $offer)
    {
        $offer->main = false;
        $offer->save();

        return  redirect()->route('admin.offer.index')->with([
            'type' => 'error',
            'message' => 'Offer removed from homepage successfully'
        ]);
    }
}