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
        //  dump(session()->all(), session()->has('url_service'));

        if(!session('url_service'))
        {
            session()->put('url_service', url()->previous());
            session()->save();
        }

        // dump(session()->all(), session()->has('url_service'));

        // session()->forget('branch_id');
       
        // session()->forget('url_service');


        $branches = Branch::with(['city', 'area', 'deliveryAreas', 'workingDays'])->get();

        foreach ($branches as $branch) {
            $currentDay =  $branch->workingDays()->where('day', strtolower(now()->englishDayOfWeek))->get();
            $branch->working_hours = $currentDay;
        }

        $countItems = auth()->user()->carts()->count();

        // dd(auth()->user()->carts);

        return view('website.takeaway', compact(['branches', 'countItems']));
    }

    public function takeawayBranchConfirm($id, $service_type)
    {

        $request = new Request();
        if ($service_type == 'takeaway') {
            $request->merge(['branch_id' => $id]);
            $branchId = $id;
            $branch = Branch::findOrFail($branchId);
        } else {
            $request->merge(['address_id' => $id]);
            $add = Address::findOrFail($id);
            $area = $add->area;
            if ($area) {
                $branch = DB::table('branch_delivery_areas')->where('area_id', $area->id . "")->first();
                $branch = Branch::findOrFail($branch->branch_id);
                if ($branch) {
                    $branchId = $branch->id;
                }
            }
            // session()->put(['address_id'=>$id]);
        }

        $isOpen = (app(\App\Http\Controllers\Api\BranchesController::class)->check($request, $branchId))->getOriginalContent();

        if ($isOpen['data']['available'] === false) {
            session()->flash('branch_closed', true);
            session()->flash('branch_name', $branch['name_' . app()->getLocale()]);
            // dd($isOpen);
            return back();
        }

        $return = (app(\App\Http\Controllers\Api\BranchesController::class)->getBranchWorkingHours($request))->getOriginalContent();

        // dd($return);

        if ($return['success'] == true) {
            
            session(['branch_id' => $return['data']['id']]);
            session(['service_type' => $service_type]);
            if ($service_type == 'delivery') {
                session(['address_id' => $id]);
                $address = Address::findOrFail($id);
                session(['address_area_id' => $address->area_id]);

                // dd($address);

                if ($address->area) {
                    $branch = DB::table('branch_delivery_areas')->where('area_id', $address->area->id . "")->first();
                    if ($branch) {
                        session(['address_branch_id' => $branch->branch_id]);
                    }
                }
                
            }
            session()->forget('status');

            auth()->user()->carts()->delete();

            return redirect(session('url_service', route('menu.page')));
            // if (auth()->user()->carts()->get()->count() > 0) {
            //     return redirect(session('url_service'));
            //     // return back();
            // }
            // return redirect()->intended();
        }
                    // dd(session('branch_id'), $return);

        session(['err' => $return['message']]);
        return redirect()->route('menu.page');
        // if (auth()->user()->carts()->get()->count() > 0) {

        //     // return back();
        // }
        // return redirect()->intended();
    }

    /* choose delivery(takeaway) branch or delivery address  */
    public function takeawayBranch($id, $service_type)
    {
        $request = new Request();
        if ($service_type == 'takeaway') {
            $request->merge(['branch_id' => $id]);
            $branchId = $id;
            $branch = Branch::find($branchId);
        } else {
            $request->merge(['address_id' => $id]);
            $add = Address::findOrFail($id);
            $area = $add->area;
            if ($area) {
                $branch = DB::table('branch_delivery_areas')->where('area_id', $area->id . "")->first();
                $branch = Branch::find($branch->branch_id);
                if ($branch) {
                    $branchId = $branch->id;
                }
            }
            // session()->put(['address_id'=>$id]);
        }

        

        $isOpen = (app(\App\Http\Controllers\Api\BranchesController::class)->check($request, $branchId))->getOriginalContent();
        

        if ($isOpen['data']['available'] === false) {
            session()->flash('branch_closed', true);
            session()->flash('branch_name', $branch['name_' . app()->getLocale()]);
            // dd($isOpen);
            return back();
        }
        // dd($isOpen);

        $return = (app(\App\Http\Controllers\Api\BranchesController::class)->getBranchWorkingHours($request))->getOriginalContent();

        // dd($return);

        if ($return['success'] == true) {
            
            session(['branch_id' => $return['data']['id']]);
            session(['service_type' => $service_type]);
            
            if ($service_type == 'delivery') {
                session(['address_id' => $id]);
                $address = Address::findOrFail($id);
                session(['address_area_id' => $address->area_id]);

                if ($address->area) {
                    $branch = DB::table('branch_delivery_areas')->where('area_id', $address->area->id . "")->first();
                    if ($branch) {
                        session(['address_branch_id' => $branch->branch_id]);
                    }
                }

                // dd(session('url_service'));
                
            }
            session()->forget('status');
            // dd(session('url_service'));
            return redirect()->to(session('url_service', route('menu.page')));
            // if (auth()->user()->carts()->get()->count() > 0) {
            //     return redirect(session('url_service'));
            //     // return redirect(session('url_service'));
            // }
            // return redirect()->intended();
        }
                    // dd(session('branch_id'), $return);

        session(['err' => $return['message']]);
        return redirect()->route('menu.page');
        // if (auth()->user()->carts()->get()->count() > 0) {

        //     // return back();
        // }
        // return redirect()->intended();
    }
}
