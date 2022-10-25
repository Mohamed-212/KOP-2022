<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Api\FrontController;
use App\Models\Category;
use App\Models\Item;
use App\Models\OfferDiscount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function menuPage()
    {
        $menu = [];
        $request = new \Illuminate\Http\Request();
        $return = (app(\App\Http\Controllers\Api\MenuController::class)->getAllCategories($request))->getOriginalContent();

        // check if cart has items with offers
        $cartHasOffers = false;
        $cart = collect();
        if (Auth::check()) {
            $cart = auth()->user()->carts;
            foreach ($cart as $item) {
                if ($item->offer_id) {
                    $cartHasOffers = true;
                    break;
                }
            }
        }

        if ($return['success'] == 'success') {
            $menu['categories'] = $return['data'];
        }

        return view('website.menu', compact('menu', 'cartHasOffers'));
    }

    public function itemPage($category_id, $item_id)
    {
        $item = 0;
        $category = Category::find($category_id);
        $request = new \Illuminate\Http\Request();
        $request->branch_id = (session()->has('branch_id')) ? session()->get('branch_id') : 0; //det branch_id

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

        $return = (app(\App\Http\Controllers\Api\MenuController::class)->getItems($request, $category_id))->getOriginalContent();
        foreach ($return['data'] as $product) {
            if ($product->id == $item_id) {
                $item = $product;
                break;
            }
        }
        return view('website.item', compact('item', 'cartHasOffers'));
    }

    public function searchItem(Request $request)
    {
        $items = Item::where('name_' . app()->getLocale(), 'LIKE', "%{$request->itemSearch}%")->get();
        foreach ($items as $key => $item) {
            $branches = explode(',', $item->branches);

            //if(in_array($request->branch_id, $branches))
            {
                $offers = DB::table('offer_discount_items')->where('item_id', $item->id)->get();

                $parent_offer = null;
                foreach ($offers as $offer) {
                    $parent_offer = OfferDiscount::find($offer->offer_id);

                    // Just edit
                    if ($parent_offer)  break;
                }

                if ($parent_offer && $parent_offer->offer) {

                    if (\Carbon\Carbon::now() < $parent_offer->offer->date_from || \Carbon\Carbon::now() > $parent_offer->offer->date_to) {
                        $parent_offer = null;
                    }
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
            }
        }
        return view('website.search', compact(['items']));
    }
}
