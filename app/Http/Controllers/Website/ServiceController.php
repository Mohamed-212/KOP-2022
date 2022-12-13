<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Api\FrontController;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ServiceController extends Controller
{
    /* show all branches with its working hours */
    public function takeawayPage()
    {

        $branches = Branch::with(['city', 'area', 'deliveryAreas', 'workingDays'])->get();

        foreach ($branches as $branch) {
            $currentDay =  $branch->workingDays()->where('day', strtolower(now()->englishDayOfWeek))->get();
            $branch->working_hours = $currentDay;
        }

        return view('website.takeaway', compact(['branches']));
    }

    /* choose delivery(takeaway) branch or delivery address  */
    public function takeawayBranch($id, $service_type)
    {

        $request = new Request();
        if ($service_type == 'takeaway') {
            $request->merge(['branch_id' => $id]);
        } else {
            $request->merge(['address_id' => $id]);
            //            session()->put(['address_id'=>$id]);
        }
        $return = (app(\App\Http\Controllers\Api\BranchesController::class)->getBranchWorkingHours($request))->getOriginalContent();

        if ($return['success'] == true) {
            session()->put(['branch_id' => $return['data']['id']]);
            session()->put(['service_type' => $service_type]);
            if ($service_type == 'delivery') {
                session()->put(['address_id' => $id]);
                $address = Address::findOrFail($id);
                session()->put(['address_area_id' => $address->area_id]);

                if ($address->area) {
                    $branch = DB::table('branch_delivery_areas')->where('area_id', $address->area->id . "")->first();
                    if ($branch) {
                        session()->put(['address_branch_id' => $branch->branch_id]);
                    }
                }
                
            }
            session()->forget('status');
            return redirect()->route('menu.page');
            // if (auth()->user()->carts()->get()->count() > 0) {
            //     return redirect()->route('menu.page');
            //     // return back();
            // }
            // return redirect()->intended();
        }
        session()->put(['err' => $return['message']]);
        return redirect()->route('menu.page');
        // if (auth()->user()->carts()->get()->count() > 0) {

        //     // return back();
        // }
        // return redirect()->intended();
    }
}
