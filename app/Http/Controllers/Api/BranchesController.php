<?php

namespace App\Http\Controllers\Api;

use App\Models\Branch;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use Carbon\Carbon;
use DB;

class BranchesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {//Get all branches with its city, areas and today working hours

        $branches = Branch::with(['city', 'area', 'deliveryAreas'])->with(['workingDays' => function($day) {
            $day->where('day', strtolower(now()->englishDayOfWeek))->get();
        }])->paginate(10);

        $branches = Branch::with(['city', 'area', 'deliveryAreas', 'workingDays'])->get();

        foreach($branches as $branch) {
            $currentDay =  $branch->workingDays()->where('day', strtolower(now()->englishDayOfWeek))->get();
            $branch->working_hours = $currentDay;
        }

        return $this->sendResponse($branches, __('general.Branches'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Branch $branch)
    {
        $branch = $branch->with(['city', 'area', 'deliveryAreas'])->with(['workingDays' => function($day) {
            $day->where('day', strtolower(now()->englishDayOfWeek))->first();
        }])->first();

        return $this->sendResponse($branch, __('general.branch_ret'));
    }

    //check if open 
    public function check(Request $request, $id)
    {
         $branch = Branch::where('id',$id)->with(['city', 'area', 'deliveryAreas'])->with(['workingDays' => function($day) {
            $day->where('day', strtolower(now()->englishDayOfWeek))->get();
        }])->first();

        $open= $branch->open();
        $close= $branch->close();

        $data=[
            'open at'=>$open,
            'close at'=>$close,
            'available'=>false
        ];
        
        for($i=0;$i<count($open);$i++)
        {   
            $date=date("Y-m-d");
            $from= date('Y-m-d H:i', strtotime("$date $open[$i]"));
            $to= date('Y-m-d H:i', strtotime("$date $close[$i]"));
            
            if(str_contains($close[$i],"AM"))
            {
                $date = date("Y-m-d", strtotime("+1 day"));
                $to= date('Y-m-d H:i', strtotime("$date $close[$i]"));
            }
             
             $now=date('Y-m-d H:i');
             if(str_contains($now,"00:"))
             {
                $now= str_replace('00:','24:',$now);
             }
             
            if((strtotime($from) < strtotime($now)) and (strtotime($to)>  strtotime($now)))
            {
                $data['available']=true;
                return $this->sendResponse($data,__('general.branch_ret'));
            }
        }
        return $this->sendResponse($data, __('general.branch_ret'));
    }

    public function getBranchWorkingHours(Request $request) {

        if ($request->address_id) {

            $customerAddress = Address::where('id', $request->address_id)->first();

            // get the branch covers customer area and open
            $area = $customerAddress->area;

            if ($area) {
                $branch = DB::table('branch_delivery_areas')->where('area_id', $area->id. "")->first();

                if ($branch) {
                    $branch = Branch::find($branch->branch_id);

                    if ($branch) {
                        $branch->workingDays;
                        return $this->sendResponse($branch, __('general.branch_ret'));
                    } else {
                        return $this->sendError(__('general.branch_no_cover'));
                    }
                } else {
                    return $this->sendError(__('general.branch_no_cover'));
                }
            } else {
                return $this->sendError(__('general.branch_no_cover'));
            }
        } else if ($request->branch_id) {
            $branch = Branch::find($request->branch_id);
            if ($branch) {
                $branch->workingDays;
                return $this->sendResponse($branch, __('general.branch_ret'));
            }
        }

        return $this->sendError(__('general.invalid_address'));
    }
}
