<?php

namespace App\Http\Controllers\Api;

use App\Models\Branch;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use Carbon\Carbon;
use DateTime;
use DB;

class BranchesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { //Get all branches with its city, areas and today working hours

        $branches = Branch::with(['city', 'area', 'deliveryAreas'])->with(['workingDays' => function ($day) {
            $day->where('day', strtolower(now()->englishDayOfWeek))->get();
        }])->paginate(10);

        $branches = Branch::with(['city', 'area', 'deliveryAreas', 'workingDays'])->get();

        foreach ($branches as $branch) {
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
        $branch = $branch->with(['city', 'area', 'deliveryAreas'])->with(['workingDays' => function ($day) {
            $day->where('day', strtolower(now()->englishDayOfWeek))->first();
        }])->first();

        return $this->sendResponse($branch, __('general.branch_ret'));
    }

    //check if open 
    public function check(Request $request, $id)
    {
        $branch = Branch::where('id', $id)->with(['city', 'area', 'deliveryAreas'])->with(['workingDays' => function ($day) {
            $day->where('day', strtolower(now()->englishDayOfWeek))->latest()->limit(2)->get();
        }])->first();

        $open = $branch->open();
        $close = $branch->close();

        $data = [
            'open at' => $open,
            'close at' => $close,
            'available' => false,
        ];

        // dd( Branch::where('id', $id)->with('workingDays')->get());

    //    dd($branch->workingDays->pluck('time_from', 'time_to'));

        foreach ($branch->workingDays as $workingDay) {
            // $timeFrom = Carbon::createFromFormat('H:i a', $workingDay->time_from);
            // $timeTo = Carbon::createFromFormat('H:i a', $workingDay->time_to);

            // if ($workingDay->time_to == '1:00 AM') {
            //     $timeTo->addDay();
            //     // $timeFrom->addDay();
            //     // dump($timeFrom, $timeTo, $now->gte($timeFrom) , $now->lte($timeTo));
            // }
            // // dump($workingDay->time_to);
            // $now = Carbon::now(); 
            // dump($now, $timeFrom, $timeTo, $workingDay);
            // if ($now->gte($timeFrom) && $now->lte($timeTo)) {
            //     // $data['available'] = true;
            //     break;
            // }

            
            $now = Carbon::now();  
            // dd($now)      
            $start = Carbon::createFromTimeString($workingDay->time_from);
            $end = Carbon::createFromTimeString($workingDay->time_to);
            if (str_contains($workingDay->time_to, 'AM') || str_contains($workingDay->time_to, 'am')){
              $end->addDay();
              $start->createFromTimeString('12:00 AM');
            } 
             
            if ($now->between($start, $end)) {
                $data['available'] = true;
                // break;
            }
        }

        // dd($data);

        return $this->sendResponse($data, __('general.branch_ret'));
    }

    public function getBranchWorkingHours(Request $request)
    {

        if ($request->address_id) {

            $customerAddress = Address::where('id', $request->address_id)->first();

            // get the branch covers customer area and open
            $area = $customerAddress->area;

            if ($area) {
                $branch = DB::table('branch_delivery_areas')->where('area_id', $area->id . "")->first();

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
