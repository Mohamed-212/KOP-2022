<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\City;
use App\Models\Area;

class AddressesController extends BaseController
{

    protected $validationRules = [
        'name' => ['string', 'required'],
        'street' => ['string', 'nullable'],
        'building_number' => ['string', 'nullable'],
        'floor_number' => ['int', 'nullable'],
        'landmark' => ['string', 'nullable'],
        'city_id' => ['required', 'exists:cities,id'],
        'area_id' => ['required', 'exists:areas,id'],
        'customer_id' => ['exists:users,id'], 
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->user()) {

            $user = $request->user();
        } else {
            $user = auth('web')->user();
        }
        $address = Address::where('customer_id', $user->id)->orderBy('created_at', 'DESC')->get();
        return $this->sendResponse($address, 'The addresses returned successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validationRules);

        if ($validator->fails()) {
            return $this->sendError('Validation Error!', $validator->errors(), 400);
        }

        // attach customer reference
        if ($request->user()) {
            if ($request->user()->hasRole('customer')) {
                $request->merge(['customer_id' => $request->user()->id]);
            }
        } else {
            if (auth('web')->user()->hasRole('customer')) {
                $request->merge(['customer_id' => auth('web')->user()->id]);
            }
        }

        if ($request->has('_token')) {
            unset($request['_token']);
        }
        $address = Address::firstOrCreate($request->all());

        if (!$address) {
            return $this->sendError(__('general.error'), 400);
        }


        return $this->sendResponse($address, __('general.address.created'));
    }

    public function sotre(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string',],
            'street' => ['nullable', 'string'],
            'building_number' => ['nullable', 'string'],
            'floor_number' => ['nullable', 'string'],
            'landmark' => ['nullable'],
            'city_id' => ['required', 'exists:cities,id'],
            'area_id' => ['required', 'exists:areas,id'],
            'customer_id' => ['exists:users,id'],
        ]);

        if ($validator->fails())
            return $this->sendError(__('general.validation_errors'), $validator->errors(), 400);

        // $city = City::where('name_en', "LIKE", "%$request->city%")->orWhere('name_ar', "LIKE", "%$request->city%")->first();
        // if (!$city) {
        //     return $this->sendError(__('general.address.city_not_found'));
        // }
        // $area = Area::where('name_en', "LIKE", "%$request->area%")->orWhere('name_ar', "LIKE", "%$request->area%")->first();
        // if (!$area) {
        //     return $this->sendError(__('general.address.area_not_found'));
        // }

        // TODO: handle errors
        // if (!$city or !$area)
        //     return $this->sendError('Some information not correct');

        // attach customer reference
        if ($request->user()) {
            if ($request->user()->hasRole('customer')) {
                $request->merge([
                    'customer_id' => $request->user()->id,
                    'city_id' => $request->city_id,
                    'area_id' => $request->area_id
                ]);
            }
        } else {
            if (auth('web')->user()->hasRole('customer')) {
                $request->merge([
                    'customer_id' => auth('web')->user()->id,
                    'city_id' => $request->city_id,
                    'area_id' => $request->area_id
                ]);
            }
        }

        $address = Address::firstOrCreate($request->all());

        if (!$address)
            return $this->sendError(__('general.error'), 400);

        return $this->sendResponse($address, __('general.address.created'));
    }


    public function sotreWithMaps(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string',],
            'street' => ['nullable', 'string'],
            'building_number' => ['nullable', 'string'],
            'floor_number' => ['nullable', 'string'],
            'landmark' => ['nullable'],
            'city' => ['nullable', 'string'],
            'area' => ['nullable', 'string'],
            'customer_id' => ['exists:users,id'],
        ]);
        $request->area=trim($request->area);
        if ($validator->fails())
            return $this->sendError(__('general.validation_errors'), $validator->errors(), 400);

        $city = City::where('name_en', "LIKE", "%$request->city%")->orWhere('name_ar', "LIKE", "%$request->city%")->first();
        if (!$city) {
            return $this->sendError(__('general.address.city_not_found'));
        }
        $area = Area::where('name_en', "LIKE", "%$request->area%")->orWhere('name_ar', "LIKE", "%$request->area%")->first();
        if (!$area) {
            return $this->sendError(__('general.address.area_not_found'));
        }

        // TODO: handle errors
        // if (!$city or !$area)
        //     return $this->sendError('Some information not correct');

        // attach customer reference
        if ($request->user()) {
            if ($request->user()->hasRole('customer')) {
                $request->merge([
                    'customer_id' => $request->user()->id,
                    'city_id' => $city->id,
                    'area_id' => $area->id
                ]);
            }
        } else {
            if (auth('web')->user()->hasRole('customer')) {
                $request->merge([
                    'customer_id' => auth('web')->user()->id,
                    'city_id' => $city->id,
                    'area_id' => $area->id
                ]);
            }
        }

        $address = Address::firstOrCreate($request->all());

        if (!$address)
            return $this->sendError(__('general.error'), 400);

        return $this->sendResponse($address, __('general.address.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Address $address)
    {
        return $this->sendResponse($address, 'Address returned successfuly');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {

        $validator = Validator::make($request->all(), $this->validationRules);
        if ($validator->fails()) {
            return $this->sendError($validator->errors(), __('general.validation_errors'), 400);
        }

        if (!$address->update($request->all())) {
            return $this->sendError('Error!', 500);
        }

        return $this->sendResponse($address, __('general.address.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address, Request $request)
    {
        if ($request->user()) {
            if ($address->customer->id == $request->user()->id) {
                if ($address->delete())
                    return $this->sendResponse(null, __('general.address deleted successfully'));
            }
        } else {
            $order = Order::where('address_id', $address->id)->get();
            if ($order->count() <= 0) {
                if ($address->customer->id == auth('web')->user()->id) {
                    if ($address->delete())
                        return $this->sendResponse(null, __('general.deleted', ['key' => __('general.City')]));
                }
            }
            return $this->sendError(__('general.error'));
        }
    }

    /**
     * check location exist in DB
     */
    public function checkLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city' => ['required', 'string'],
            'area' => ['required', 'string'],
        ]);
        if ($validator->fails())
            return $this->sendError(__('general.validation_errors'), $validator->errors(), 400);
        $areaId=null;
        $cityId=null;
        $city = City::where('name_en', "LIKE", "%$request->city%")->orWhere('name_ar', "LIKE", "%$request->city%")->first();
        if($city){
            $area = Area::where('city_id', $city->id)->where('name_en', "LIKE", "%$request->area%")->orWhere('name_ar', "LIKE", "%$request->area%")->first();
            if($area){
                $cityId = $city->id;
                $areaId = $area->id;
            }
        }
        $data =[
            'city_id' => $cityId,
            'area_id' => $areaId
        ];
        if($cityId){
            return $this->sendResponse($data, __('general.address.created'));
        }
        return $this->sendError(__('general.address.city_not_found'));
    }
}
