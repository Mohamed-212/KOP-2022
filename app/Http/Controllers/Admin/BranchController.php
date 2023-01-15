<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchWorkingDay;
use App\Models\City;
use App\Models\Area;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Traits\LogfileTrait;

class BranchController extends Controller
{

    /**
     * Validation rules for Branch resource
     */

    use LogfileTrait;

    protected $validationsRules = [
        'name_ar' => 'required|min:3|max:30',
        'name_en' => 'required|min:3|max:30',
        'city_id' => 'required|numeric|exists:cities,id',
        'area_id' => 'required|numeric|exists:areas,id',
        'address_description' => 'required',
        'address_description_en' => 'required',
        'first_phone' => 'required|numeric',
        'second_phone' => 'nullable|numeric',
        'email' => 'required|email',
        'service_type.*' => 'required|string',
        'WorkingDay' => 'array',
        // 'delivery_fees' => 'integer',
        'areas.*' => 'exists:areas,id|required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = Branch::OrderBy('created_at')->get();
        $this->Make_Log('App\Models\Branch','view',0);
        return view('admin.branch.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('admin.branch.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|min:3|max:30',
            'name_en' => 'required|min:3|max:30',
            'branch_city_id' => 'required|numeric',
            'area_id' => 'required|numeric',
            'address_description' => 'required',
            'address_description_en' => 'required',
            'first_phone' => 'required|numeric',
            'second_phone' => 'nullable|numeric',
            'email' => 'required|email',
            'service_type' => 'required|array',
            // 'areas.*' => 'exists:areas,id',
            // 'delivery_fees' => 'integer',
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors())->withInput();


        $attributes['service_type'] = implode(",", $request->get('service_type'));

        $input = $request->except(['WorkingDay', 'areas']);

        $branch = Branch::create([
            'name_ar' => $input['name_ar'],
            'name_en' => $input['name_en'],
            'city_id' => $input['branch_city_id'],
            'area_id' => $input['area_id'],
            'address_description' => $input['address_description'],
            'address_description_en' => $input['address_description_en'],
            'first_phone' => $input['first_phone'],
            'second_phone' => $input['second_phone'],
            'email' => $input['email'],
            'service_type' => $attributes['service_type'],
            // 'delivery_fees' => $input['delivery_fees'],
            'delivery_fees' => 0,

        ]);

        $this->Make_Log('App\Models\Branch','create',$branch->id);
        // TODO: use this fucntion to return only choosen day
        $days = array_filter($request->WorkingDay, function ($day) {
            return isset($day['on']);
        });

        if ($request->has('WorkingDay')) {

            foreach ($days as $name => $day) {

                if (!empty($day['time_from']) && !empty($day['time_to'])) {
                   $action_id= BranchWorkingDay::create([
                        'branch_id' => $branch->id,
                        'day' => $name,
                        'time_from' => $day['time_from'],
                        'time_to' => $day['time_to'],
                    ]);
                    $this->Make_Log('App\Models\BranchWorkingDay','create',$action_id);
                }

                if (!empty($day['time_from2']) && !empty($day['time_to2'])) {
                    $action_id= BranchWorkingDay::create([
                        'branch_id' => $branch->id,
                        'day' => $name,
                        'time_from' => $day['time_from2'],
                        'time_to' => $day['time_to2'],
                    ]);
                    $this->Make_Log('App\Models\BranchWorkingDay','create',$action_id);
                }
            }
        }


        // attach areas to branch
        if ($request->has('areas')) {
            $branch->deliveryAreas()->sync($request->areas);
        }

        return redirect()->route('admin.branch.index')->with([
            'type' => 'success',
            'message' => 'Branch insert successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch $branch)
    {
        $areas = $branch->deliveryAreas;
        if($areas->count() > 0){
           $deliviry_city = $areas[0]->city; 
           return view('admin.branch.edit', compact('branch', 'areas', 'deliviry_city'));
        }
        return view('admin.branch.edit', compact('branch', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {
        $validator = Validator::make($request->all(), $this->validationsRules);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors())->withInput();
        $validatedData = $request->all();
        $validatedData['service_type'] = implode(",", $request->get('service_type'));
        try {
            if (array_key_exists("areas", $validatedData)) {

                $branch->deliveryAreas()->sync($validatedData['areas']);
            }
            $branch->workingDays()->delete();
            // extract choosen days
            $days = array_filter($request->WorkingDay, function ($day) {
                return isset($day['on']);
            });

            // dd($days);
            foreach ($days as $name => $day) {
                if (!empty($day['time_from']) && !empty($day['time_to'])) {
                    BranchWorkingDay::create([
                        'branch_id' => $branch->id,
                        'day' => $name,
                        'time_from' => $day['time_from'],
                        'time_to' => $day['time_to'],
                    ]);
                }
                if (!empty($day['time_from2']) && !empty($day['time_to2'])) {
                    BranchWorkingDay::create([
                        'branch_id' => $branch->id,
                        'day' => $name,
                        'time_from' => $day['time_from2'],
                        'time_to' => $day['time_to2'],
                    ]);
                }
            }
            unset($validatedData['delivery_city_id']);
            unset($validatedData['areas']);
            unset($validatedData['WorkingDay']);
            $branch->update($validatedData);
            $this->Make_Log('App\Models\Branch','update',$branch->id);

            return redirect()->route('admin.branch.index')->with([
                'type' => 'success',
                'message' => 'Branch Has Been Updated'
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        $branch->orders()->delete();
        $branch->cashiers2()->delete();
        $branch->delete();
        $this->Make_Log('App\Models\Branch','delete',$branch->id);

        return redirect()->route('admin.branch.index');
    }
}
