<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;
use App\Http\Controllers\Api\BaseController;
use DB;
use App\Models\OfferDiscount;

class MenuController extends BaseController
{
    public function getAllCategories2()
    {
        $categories = Category::with('items')->get();
        // load first category items
        $categories->first()->load('items');
        
        return $this->sendResponse($categories, 'All Categories retrieved successfully.');
    }

    public function getAllCategories(Request $request)
    {
        $categories = Category::with('items')->get();
        // load first category items

        if($request->service_type =='takeaway')
        {
            $categories->first()->load('items')->where('items.branches', $request->id);
        }
        elseif($request->service_type =='delivery')
        {
            $address = Address::find($request->id);
            $branch=DB::table('branch_delivery_areas')->where('area_id',$address->area_id)->pluck('branch_id');
            if (!empty($branch)) {
                $categories->first()->load('items')->whereIn('items.branches', $branch);
            }
        }
        
        
        return $this->sendResponse($categories, 'All Categories retrieved successfully.');
    }

    public function getCategory(Request $request, int $category)
    {
        $category = Category::findOrFail($category);
        $category->loadMissing('items', 'extras', 'withouts');


        foreach ($category->items as $key => $item) {
            $branches = explode(',', $item->branches);
            //if(in_array($request->branch_id, $branches))
            {
                $offers = DB::table('offer_discount_items')->where('item_id', $item->id)->get();

                $parent_offer = null;
                foreach ($offers as $offer) {
                    $parent_offer = OfferDiscount::find($offer->offer_id);


                    if ($parent_offer)  break;
                }

                if ($parent_offer) {

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

        return $this->sendResponse($category, 'Categories retrieved successfully.');
    }

    public function getItems(Request $request,$category)
    {
        $items = Category::find($category)->items()->with('category.extras', 'category.withouts')->get();

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

                if ($parent_offer) {

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

        return $this->sendResponse($items, 'items retrieved successfully.');
    }


    public function getCategoryItems(Request $request, int $category) {
        $category = Category::findOrFail($category);
        $items = $category->items()->get();

        foreach ($items as $key => $item) {
            $branches = explode(',',$item->branches);
            //if(in_array($request->branch_id, $branches))
            {
                $offers = DB::table('offer_discount_items')->where('item_id', $item->id)->get();

                $parent_offer = null;
                foreach ($offers as $offer) {
                    $parent_offer = OfferDiscount::find($offer->offer_id);

                    // Just edit
                    if ($parent_offer)  break;

                }

                if ($parent_offer) {

                    if (\Carbon\Carbon::now() < $parent_offer->offer->date_from || \Carbon\Carbon::now() > $parent_offer->offer->date_to) {
                        $parent_offer = null;
                    }
                }


                $item->offer = $parent_offer;

                if ($parent_offer) {
                    if ($parent_offer->discount_type == 1) {

                        $disccountValue = $item->price * $parent_offer->discount_value / 100 ;
                        $item->offer->offer_price = $item->price - $disccountValue;
                    } elseif($parent_offer->discount_type == 2) {
                        $item->offer->offer_price = $item->price - $parent_offer->discount_value;
                    }

                    unset($item->offer->offer);
                }
            }
            unset($item->category);
        }
        
        return $this->sendResponse($items, 'items retrieved successfully.');
    }


    public function getItem(Request $request, int $item) {
        $item = Item::findOrFail($item);
        $item->load('category.extras', 'category.withouts');
        // $item->category= Category::with('extras', 'withouts')->where('id',$item->category_id)->get();
        $offers = DB::table('offer_discount_items')->where('item_id', $item->id)->get();

        $parent_offer = null;
        foreach ($offers as $offer) {
            $parent_offer = OfferDiscount::find($offer->offer_id);

            // Just edit
            //  if ($parent_offer)  break;
        
        if ($parent_offer) {
           if(isset($parent_offer->offer->date_from)){
            if (\Carbon\Carbon::now() < $parent_offer->offer->date_from || \Carbon\Carbon::now() > $parent_offer->offer->date_to) {
                $parent_offer = null;
            }}
            else{break;}
        }

        $item->offer = $parent_offer;

        if ($parent_offer) {
            if ($parent_offer->discount_type == 1) {

                $disccountValue = $item->price * $parent_offer->discount_value / 100 ;
                $item->offer->offer_price = $item->price - $disccountValue;
            } elseif($parent_offer->discount_type == 2) {
                $item->offer->offer_price = $item->price - $parent_offer->discount_value;
            }
        
        }

        }
        return $this->sendResponse($item, 'item retrieved successfully.');
     
    }

    public function getExtras(Request $request, int $category)
    {
        $category = Category::findOrFail($category);

        return $this->sendResponse($category->extras, 'Extras retrieved successfully.');
    }

    public function getWithouts(Request $request, int $category)
    {
        $category = Category::findOrFail($category);

        return $this->sendResponse($category->withouts, 'Withouts retrieved successfully.');
    }

    public function getExtra(Request $request, Extra $extra)
    {
        dd($extra, 'test');
    }

    public function getWithout(Request $request, Without $without)
    {
        dd($without, 'test');
    }

    public function getOffers()
    {
    }

    public function getRecommendedItems(Request $request)
    {
        $items = Item::where('recommended', true)->simplePaginate();

        return $this->sendResponse($items, 'recommended items retrieved successfully.');
    }
}
