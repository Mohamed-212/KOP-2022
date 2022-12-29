<?php

namespace App\Http\Controllers\Website;

use App\Filters\OfferFilters;
use App\Http\Controllers\Api\FrontController;
use App\Models\Item;
use App\Models\Offer;
use App\Models\News;
use App\Models\HomeItem;
use App\Models\OfferDiscount;
use App\Models\Anoucement;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\AreaImport;
use App\Models\Area;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function homePage(Request $request){

        // session()->flush();

        $o_list = Offer::all();

        $o = [];
        foreach($o_list as $off){
            if (!$off) {
               continue; 
            }
            // dump(date('H:i'));
            // dump(date('Y-m-d', strtotime($off->date_from)), date('Y-m-d', strtotime($off->date_to)));
            // dump($off->date_from, $off->date_to);
            if (date('Y-m-d') < date('Y-m-d', strtotime($off->date_from)) || date('Y-m-d') > date('Y-m-d', strtotime($off->date_to))) {
                continue;
            }
            $start = Carbon::createFromTimeString(substr($off->date_from, 11));
            $end = Carbon::createFromTimeString(substr($off->date_to, 11));
            // dd($start, $end);
            if (!Carbon::now()->between($start, $end)) {
                continue;
            }
            $o[] = $off;
        }

        $menu = [];

        // $areas = Excelll::toArray(new AreaImport, storage_path('/app/public/areas.xlsx'));

        // $areas = array_splice($areas[0], 9);

        // // DB::table('areas')->truncate();

        // $lastId = Area::latest('id')->first();

        // $i = $lastId ? $lastId->id+1 : 1;
        
        // foreach ($areas as $area) {
        //     if ($area[0] === null) continue;

        //     $ar = Area::create([
        //         'id' => $i,
        //         'city_id' => 23421,
        //         'name_ar' => $area[0],
        //         'name_en' => $area[1],
        //         'delivery_fees' => 23,
        //         'description_ar' => null,
        //         'description_en' => null,
        //         'min_delivery_ammount' => null,
        //     ]);

        //     // dump($ar);
        //     $i++;
        // }
    
        // dd('');

        $return = (app(\App\Http\Controllers\Api\MenuController::class)->getAllCategories2())->getOriginalContent();

        if($return['success'] == 'success'){
             $menu['categories'] = $return['data'];
        }
        $return = (app(FrontController::class)->getGallery())->getOriginalContent();
        if($return['success'] == 'success'){
            $menu['galleries'] = (count($return['data']))? $return['data'] : [];
        }
        $return = (app(FrontController::class)->getAboutUS())->getOriginalContent();
        if($return['success'] == 'success'){
            $menu['aboutus'] = (count($return['data']))? $return['data'][0] : '';
        } 
        // $return = (app(FrontController::class)->getAllNews())->getOriginalContent();
        // if($return['success'] == 'success'){
             $menu['news'] = News::latest()->take(3)->get();
        // }
        $request = new \Illuminate\Http\Request();
        if(session()->has('service_type')){
            $request->merge(['type' => session()->get('service_type')]);
        }
        $request->merge(['now' => Carbon::now()]);
        $filters = new OfferFilters($request);
        $offers = Offer::with('buyGet', 'discount')->filter($filters)->get();
        // $return = (app(\App\Http\Controllers\Api\OffersController::class)->index($request, $filters))->getOriginalContent();
        // if($return['success'] ==  nt($return['data']))? $return['data'] : [];
        // }
        $menu['offers'] = $offers;
        $menu['main_offer']=Offer::with('buyGet','discount')->filter($filters)->where('main',true)->get();

        // $catData = (app(\App\Http\Controllers\Api\MenuController::class)->getAllCategories($request))->getOriginalContent();

        $dealItems = Category::with('items')->get();
        // $dealItems = $catData['data'];
        $menu['dealItems']=[];
        foreach($menu['categories'] as $category)
        {
            $count=0;
            foreach($category->items as $item)
            {
                if($count == 3)
                {break;}
                $item->category_name_ar= $category->name_ar;
                $item->category_name_en= $category->name_en;

                // get items offers
                $offers = DB::table('offer_discount_items')->where('item_id', $item->id)->get();

                $parent_offer = null;
                foreach ($offers as $offer) {
                    $parent_offer = OfferDiscount::find($offer->offer_id);


                    if ($parent_offer) {

                        if ($parent_offer->offer) {
                            if (date('Y-m-d') < date('Y-m-d', strtotime($parent_offer->offer->date_from)) || date('Y-m-d') > date('Y-m-d', strtotime($parent_offer->offer->date_to))) {
                                $parent_offer = null;
                            }
    
                            if ($parent_offer && $parent_offer->offer) {
                                $start = Carbon::createFromTimeString(substr($parent_offer->offer->date_from, 11));
                                $end = Carbon::createFromTimeString(substr($parent_offer->offer->date_to, 11));
                                // dd($start, $end);
                                if (!Carbon::now()->between($start, $end)) {
                                    $parent_offer = null;
                                }
                            }
                            
                         } else {
                            $parent_offer = null;
                         }
                         // dump(date('H:i'));
                         // dump(date('Y-m-d', strtotime($parent_offer->offer->date_from)), date('Y-m-d', strtotime($parent_offer->offer->date_to)));
                         // dump($parent_offer->offer->date_from, $parent_offer->offer->date_to);
                         // dump(date('H:i'));
                         // dump(date('Y-m-d', strtotime($parent_offer->offer->date_from)), date('Y-m-d', strtotime($parent_offer->offer->date_to)));
                         // dump($parent_offer->offer->date_from, $parent_offer->offer->date_to);
                         

                    }

                    if ($parent_offer)  break;
                }

                


                $item->offer = $parent_offer;

                if ($parent_offer) {
                    if ($parent_offer->discount_type == 1) {
                        $disccountValue = $item->price * $parent_offer->discount_value / 100;
                        $item->offer->offer_price = $item->price - $disccountValue;
                    } elseif ($parent_offer->discount_type == 2) {
                        $item->offer->offer_price = $item->price - $parent_offer->discount_value;
                    }

                    unset($item->offer->offer);
                }

                array_push($menu['dealItems'] , $item);
                $count++;
            }
            $count=0;
        }

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

    //    return  $menu['dealItems'] ;
        $menu['recommended']=Item::where('recommended', true)->get();
        $menu['homeitem']=HomeItem::all();
         $menu['anoucement']=Anoucement::all();
        return view('website.index',compact('menu', 'cartHasOffers'));
    } 
}


