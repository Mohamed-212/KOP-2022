<?php

namespace App\Http\Controllers\Api;

use App\Models\DeactivationReason;
use App\Models\Careers;
use App\Models\JobRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use DB;
use App\Models\AboutUs;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Media;
use App\Models\HealthInfo;
use App\Models\Item;
use App\Models\News;
use App\Models\Offer;
use App\Models\OfferDiscount;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Validator;

class FrontController extends BaseController
{
    //aboutUS
    public function getAboutUS()
    {
        $aboutUS = AboutUs::all();
        return $this->sendResponse($aboutUS, __('general.ret', ['key' => __('general.about_ret')]));
    }

    //gallery
    public function getGallery()
    {
        $gallery = Gallery::paginate(12);
        return $this->sendResponse($gallery, __('general.ret', ['key' => __('general.gallery_ret')]));
    }

    //media Video
    public function getVideo($videoID = null)
    {
        $media = [];
        if ($videoID == null) {
            $all = Media::all();
            if (count($all) > 0) {
                $media['current'] = $all[0];
                //$media['allRemain'] = array_slice((array)$all, 1);
                $media['allRemain'] = $all;
            }
        } else {
            $media['current'] = Media::find($videoID);
            //$media['allRemain'] = Media::all()->except($videoID);
            $media['allRemain'] = Media::all();
        }
        return $this->sendResponse($media, __('general.ret', ['key' => __('general.media_ret')]));
    }

    //News
    public function getAllNews()
    {
        $news = News::paginate(6);
        return $this->sendResponse($news, __('general.ret', ['key' => __('general.news_ret')]));
    }
    public function getAllNewsNoPaginate()
    {
        $news = News::all();
        return $this->sendResponse($news, __('general.ret', ['key' => __('general.news_ret')]));
    }

    public function getNew($newID)
    {
        $new = News::find($newID);
        if ($new) {
            return $this->sendResponse($new, __('general.ret', ['key' => __('general.new_ret')]));
        }
        return $this->sendError(__('general.error'));
    }

    //Health Info
    public function getAllHealthInfo()
    {
        $healthInfo = HealthInfo::all();
        return $this->sendResponse($healthInfo,  __('general.ret', ['key' => __('general.health_ret')]));
    }

    //Jobs
    public function getAllJobs()
    {
        $careers = Careers::where('status', true)->get();
        return $this->sendResponse($careers,  __('general.ret', ['key' => __('general.carrers_ret')]));
    }

    public function GetJob($id)
    {
        $careers = Careers::find($id);

        return $this->sendResponse($careers,  __('general.ret', ['key' => __('general.carrer_ret')]));
    }

    public function jobRequest(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'description' => 'required',
            'cv_file' => 'required|mimes:pdf',

        ]);
        if ($validator->fails()) {
            return $this->sendError(__('general.validation_errors'), $validator->errors());
        }
        //check if application exist
        $countExist = JobRequest::where('id', $id)
            ->where(function ($q) use ($request) {
                $q->where('email', $request->email)
                    ->orWhere('phone', $request->phone);
            })->get()->count();
        if ($countExist > 0) {
            return $this->sendError(__('general.carrer_already'), __('general.app_not_sent'));
        }

        try {
            $jobRequest = new JobRequest();
            $jobRequest->job_id = $id;
            $jobRequest->name = $request->name;
            $jobRequest->email = $request->email;
            $jobRequest->phone = $request->phone;
            $jobRequest->description = $request->description;

            if ($request->hasFile('cv_file')) {
                $cv_file = $request->cv_file;
                $cv_file_new_name = time() . $cv_file->getClientOriginalName();
                $cv_file->move(public_path('CV'), $cv_file_new_name);
                $jobRequest->cv_file = '/CV/' . $cv_file_new_name;
            }
            $jobRequest->save();

            return $this->sendResponse($jobRequest, __('general.app_sent'));
        } catch (\Exception $ex) {
            return $this->sendError(__('general.validation_errors'), $validator->errors());
        }
    }

    public function getHomeSections(Request $request)
    {
        $banner = Banner::all();

        // recommended items
        $recommended = Item::where('recommended', true)->get();

        // categories with items
        // $categories = Category::with('items','extras','withouts')->get();
        $return = (app(\App\Http\Controllers\Api\MenuController::class)->getAllCategories($request))->getOriginalContent();

        $categories = $return['data'];

        if($return['success'] == 'success'){
             $categories = $return['data'];
             foreach($categories as $category)
        {
            // $count=0;
            // foreach($category->items as $item)
            // {
            //     if($count == 3)
            //     {break;}
            //     $item->category_name_ar= $category->name_ar;
            //     $item->category_name_en= $category->name_en;

            //     // $item->

            //     $item->extra = $category->extras;
            //     $item->withouts = $category->withouts;

            //     // get items offers
            //     $offers = FacadesDB::table('offer_discount_items')->where('item_id', $item->id)->get();

            //     $parent_offer = null;
            //     foreach ($offers as $offer) {
            //         $parent_offer = OfferDiscount::find($offer->offer_id);


            //         if ($parent_offer) {

            //             if (\Carbon\Carbon::now() < optional($parent_offer->offer)->date_from || \Carbon\Carbon::now() > optional($parent_offer->offer)->date_to) {
            //                 $parent_offer = null;
            //             }
            //         }

            //         if ($parent_offer)  break;
            //     }

                


            //     $item->offer = $parent_offer;

            //     if ($parent_offer) {
            //         if ($parent_offer->discount_type == 1) {
            //             $disccountValue = $item->price * $parent_offer->discount_value / 100;
            //             $item->offer->offer_price = $item->price - $disccountValue;
            //         } elseif ($parent_offer->discount_type == 2) {
            //             $item->offer->offer_price = $item->price - $parent_offer->discount_value;
            //         }

            //         unset($item->offer->offer);
            //     }

            //     // array_push($menu['dealItems'] , $item);
            //     $count++;
            // }
            // $count=0;
        }
        } else {
            $categories = [];
        }

        // offers
        $offerslist = Offer::with('buyGet', 'discount')->where('main', true)->get();

        $offers = [];
        foreach($offerslist as $off){
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
            // dump($start, $end);
            if (!Carbon::now()->between($start, $end)) {
                continue;
            }
            $offers[] = $off;
        }

        return $this->sendResponse(compact('banner', 'recommended', 'categories', 'offers'), 'Get all menu items');
    }

    public function deactivate(Request $request)
    {
        $request->validate([
            'cancellation_reason' => 'nullable|string|max:255',
            'reason_id' => 'required|integer|exists:deactivation_reasons,id',
        ]);

        $user = auth()->user();

        $user->update([
            'status' => 0,
            'cancellation_reason' => $request->cancellation_reason,
            'reason_id' => $request->reason_id
        ]);

        // auth()->logout();
        session()->flush();

        return $this->sendResponse(compact('user'), __('auth.use account deactivated'));
    }

    public function deactivation_reasons()
    {
        $reasons = DeactivationReason::all();

        return $this->sendResponse(compact('reasons'), 'get all reasons');
    }
} 
