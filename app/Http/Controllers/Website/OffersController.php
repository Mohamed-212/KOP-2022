<?php

namespace App\Http\Controllers\Website;

use App\Filters\OfferFilters;
use App\Models\Offer;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OffersController extends Controller
{
    // public function get_offers()
    // {
    //     $request = new \Illuminate\Http\Request();
    //     //$request->merge(['branch' => session()->get('branch_id')]);
    //     $request->merge(['type' => session()->get('service_type')]);
    //     $request->merge(['now' => Carbon::now()]);
    //     $filters = new OfferFilters($request);

    //     $return = (app(\App\Http\Controllers\Api\OffersController::class)->index($request, $filters))->getOriginalContent();

    //     if ($return['success'] == 'success') {
    //          $offers = $return['data'];
    //     }
    //     return view('website.offers', compact(['offers']));
    // }

    // public function get_offers()
    // {
    //     $request = new \Illuminate\Http\Request();
    //     //$request->merge(['branch' => session()->get('branch_id')]);
    //     $request->merge(['type' => session()->get('service_type')]);
    //     $request->merge(['now' => Carbon::now()]);
    //     $filters = new OfferFilters($request);

    //     $return = (app(\App\Http\Controllers\Api\OffersController::class)->index($request, $filters))->getOriginalContent();

    //     if ($return['success'] == 'success') {
    //          $offers = $return['data'];
    //     }
    //     return view('website.offers', compact(['offers']));
    // }

    public function get_offers()
    {
        $request = new \Illuminate\Http\Request();
        //  $request->merge(['branch' => session()->get('branch_id')]);
        $request->merge(['type' => session()->get('service_type')]);
        $request->merge(['now' => Carbon::now()]);
        $filters = new OfferFilters($request);

        $offer_id = DB::table("branch_offer")->where('branch_id', session()->get('branch_id'))->pluck('offer_id');
        $offers = Offer::whereIn('id',$offer_id)->with('buyGet', 'discount')->filter($filters)->get();

        // check if cart has items with offers
        $cartHasOffers = false;
        $cart = collect();
        if (auth()->check()) {
            $cart = auth()->user()->carts;
            foreach ($cart as $item) {
                if ($item->offer_id) {
                    $cartHasOffers = true;
                    break;
                }
            } 
        }

        // if ($return['success'] == 'success') {
        //      $offers = $return['data'];
        // }

        return view('website.offers', compact('offers', 'cartHasOffers'));
    }
    
    public function offerItems($offerID)
    {
        $request = new \Illuminate\Http\Request();
        $offer = Offer::find($offerID);
        $return = (app(\App\Http\Controllers\Api\OffersController::class)->get($request,$offerID))->getOriginalContent();
        $offers = $return['data'];
        if ($offer->offer_type == 'discount') {
            foreach($offers['details']->items as $discountitem)
            {
            if($offers['discount']['discount_type']==1)
            {
              $discountitem->offer_price=(float)$discountitem->price - ((float)$discountitem->price*((float)$offers['discount']['discount_value']/100));
            }
            else 
            {
                $discountitem->offer_price=$discountitem->price - (float)$offers['discount']['discount_value'];
            }
            }
            return view('website.offerDiscount', compact(['offers']));
        }
        return view('website.offerBuyGet', compact(['offers']));
    }
}
