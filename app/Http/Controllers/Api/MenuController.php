<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;
use App\Models\Address;
use App\Http\Controllers\Api\BaseController;
use DB;
use App\Models\OfferDiscount;
use Carbon\Carbon;

class MenuController extends BaseController
{
    public function getAllCategories2()
    {
        $categories = Category::with('items')->get();
        // load first category items
        $categories->first()->loadMissing('items');

        foreach ($categories->first()->items as $key => $item) {
            $branches = explode(',', $item->branches);
            //if(in_array($request->branch_id, $branches))
            {
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
            }
        }

        return $this->sendResponse($categories, __('general.ret', ['key' => __('general.cat_ret')]));
    }

    public function getAllCategories(Request $request)
    {

        // load first category items


        if (isset($request->service_type)) {
            if ($request->service_type == 'takeaway') {
                $request->request->add(['branch_id' => $request->id]);
            } elseif ($request->service_type == 'delivery') {
                $address = Address::find($request->id);
                $request->request->add(['branch_id' => DB::table('branch_delivery_areas')->where('area_id', $address->area_id)->pluck('branch_id')->first()]);
            }
        }

        $categories = Category::with('items')->get();
        $data = [];
        // $categories->first()->loadMissing('items');
        foreach ($categories as $category) {
            foreach ($category->items as $key => $item) {

                $item->extra = $category->extras;
                $item->without = $category->withouts;

                $branches = explode(',', $item->branches);
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

                    }

                    if ($parent_offer)  break;
                }

                


                $item->offer = $parent_offer;
                

                if ($parent_offer) {
                    
                    if ($parent_offer->discount_type == 1) {
                        $disccountValue = $item->price * $parent_offer->discount_value / 100;
                        $item->offer->offer_price = $item->price - $disccountValue;
                        $item->offer_price = round($item->price - $disccountValue, 2);
                        // dump($item);
                    } elseif ($parent_offer->discount_type == 2) {
                        $item->offer->offer_price = $item->price - $parent_offer->discount_value;
                        $item->offer_price = round($item->price - $parent_offer->discount_value, 2);
                    }

                    // dump($item);
                    // if ($item->offer->offer_type == 'discount') {
                        $item->offer_price = $item->offer_price > 0 ? $item->offer_price : null;
                    // }

                    unset($item->offer->offer);
                }
            }
            // dd($category);
            $data[] = $category;
        }

        // dd($categories->first());


        return $this->sendResponse($categories, __('general.ret', ['key' => __('general.cat_ret')]));
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

        return $this->sendResponse($category, __('general.ret', ['key' => __('general.cat_ret')]));
    }

    public function getItems(Request $request, $category = null)
    {
        if ($category) {
            $items = Category::find($category)->items()->with('category.extras', 'category.withouts')->get();
        } else {
            $items = Item::with('category.extras', 'category.withouts')->get();
        }

        // dd($items);
        foreach ($items as $key => $item) {
            $branches = explode(',', $item->branches);
            //if(in_array($request->branch_id, $branches))
            {
                $offers = DB::table('offer_discount_items')->where('item_id', $item->id)->get();

                $parent_offer = null;
                // dd($item->id);
                foreach ($offers as $offer) {
                    $parent_offer = OfferDiscount::find($offer->offer_id);
                    // dd($parent_offer);
                    if ($parent_offer && $parent_offer->offer) {
                        
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
                    }

                    // Just edit
                    if ($parent_offer)  break;
                }

                // dd($parent_offer);


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

        return $this->sendResponse($items, __('general.ret', ['key' => __('general.items_ret')]));
    }


    public function getCategoryItems(Request $request, int $category)
    {
        $category = Category::findOrFail($category);
        $items = $category->items()->get();

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
            unset($item->category);
        }

        return $this->sendResponse($items, __('general.ret', ['key' => __('general.items_ret')]));
    }


    public function getItem(Request $request, int $item)
    {
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
                if (isset(optional($parent_offer->offer)->date_from)) {
                    if (\Carbon\Carbon::now() < optional($parent_offer->offer)->date_from || \Carbon\Carbon::now() > optional($parent_offer->offer)->date_to) {
                        $parent_offer = null;
                    }
                } else {
                    break;
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
            }
        }
        return $this->sendResponse($item,  __('general.ret', ['key' => __('general.item_ret')]));
    }

    public function getExtras(Request $request, int $category)
    {
        $category = Category::findOrFail($category);

        return $this->sendResponse($category->extras,  __('general.ret', ['key' => __('general.extras_ret')]));
    }

    public function getWithouts(Request $request, int $category)
    {
        $category = Category::findOrFail($category);

        return $this->sendResponse($category->withouts,  __('general.ret', ['key' => __('general.withouts_ret')]));
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

        return $this->sendResponse($items, __('general.ret', ['key' => __('general.recomended_ret')]));
    }
}
