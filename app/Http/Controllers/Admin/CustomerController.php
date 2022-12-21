<?php

namespace App\Http\Controllers\Admin;

use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Area;
use App\Models\Address;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\LogfileTrait;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use LogfileTrait;

    public function index()
    {
        $customers = User::whereHas('roles', function ($role) {
            $role->where('name', 'customer');
        })->orderBy('id', 'DESC')->get();
        $this->Make_Log('App\Models\User','view',0);
        return view('admin.customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all();
        $areas = Area::all();
        return view('admin.customer.create', compact('cities', 'areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3|max:20',
            'middle_name' => 'nullable|min:3|max:20',
            'last_name' => 'required|min:3|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:4',
            'first_phone' => 'required|numeric|digits:12',
            'second_phone' => 'nullable|numeric|digits:12',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:5000'
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors())->withInput();


        if ($request->filled('middle_name')) {
            $name = $request->first_name . ' ' . $request->middle_name . ' ' . $request->last_name;
        } else {
            $name = $request->first_name . ' ' . $request->last_name;
        }


        $customerRole = Role::where(['name' => 'customer'])->first();

        $customer = User::create([
            'name' => $name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'first_phone' => $request->first_phone,
            'second_phone' => $request->second_phone,
            'image' => '',
            'password' => Hash::make($request->password),
            'activation_token' => '',
            'created_by' => auth()->id()
        ]);

        $this->Make_Log('App\Models\User','create',$customer->id);


        if ($request->hasFile('image')) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move(public_path('customers'), $image_new_name);
            $customer->image = '/customers/' . $image_new_name;
            $customer->save();
        } else {
            $image = null;
        }

        $customer->attachRole($customerRole);

        if ($request->has('Address')) {
            $addresses = $request->get('Address');
            foreach ($addresses as $customer_address) {
             $action_id=   Address::create([
                    'customer_id' => $customer->id,
                    'name' => 'address of ' . $customer->name,
                    'city_id' => $customer_address['city_id'],
                    'area_id' => $customer_address['area_id'],
                    'street' => $customer_address['street'],
                    'building_number' => $customer_address['building_number'],
                    'floor_number' => $customer_address['floor_number'],
                    'landmark' => $customer_address['special_marque'],
                ]);
                $this->Make_Log('App\Models\Address','create',$action_id);
            }
        }

        return redirect()->route('admin.customer.index')->with([
            'type' => 'success',
            'message' => 'Customer insert successfuly'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $customer)
    {
        $addresses = $customer->addresses()->with('city', 'area')->get();
        return view('admin.customer.show', compact('customer', 'addresses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $customer)
    {
        $cities = City::all();
        $areas = Area::all();
        $addresses = $customer->addresses()->get();

        return view('admin.customer.edit', compact('customer', 'cities', 'areas', 'addresses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $customer)
    {

        $request->validate([
            'first_name' => 'required|min:3|max:20',
            'middle_name' => 'nullable|min:3|max:20',
            'last_name' => 'required|min:3|max:20',
            'email' => 'required|email',
            'first_phone' => 'required|numeric|digits:12',
            'second_phone' => 'nullable|numeric|digits:12',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:5000'
        ]);

        if ($request->filled('middle_name')) {
            $name = $request->first_name . ' ' . $request->middle_name . ' ' . $request->last_name;
        } else {
            $name = $request->first_name . ' ' . $request->last_name;
        }

        if ($request->hasFile('image')) {
            if (File::exists(storage_path('app/public/' . $customer->image))) {
                File::delete(storage_path('app/public/' . $customer->image));
            }
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move(public_path('customers'), $image_new_name);
            $customer->image = '/customers/' . $image_new_name;
            $customer->save();
        }

        if (isset($image))
            $customer->image = $image;
        $customer->save();

        $customer->update([
            'name' => $name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'first_phone' => $request->first_phone,
            'second_phone' => $request->second_phone,
            'updated_by' => auth()->id()
        ]);

        $this->Make_Log('App\Models\User','update',$customer->id);
        // dd(
        //     $request->Address,
        //     $customer->addresses->first()
        // );
        if($request->Address != null)
        {
            $customer->addresses()->delete();
            foreach ($request->Address as $address) {
                $customer->addresses()->updateOrCreate($address);
            }
        }



        // foreach($request->Address as $address) {








        // }



        // if($request->has('Address'))
        // {
        //     $address_customer = Address::where(['customer_id' => $customer->id])->get();
        //     $addresses = $request->get('Address');
        //     foreach ($addresses as $customer_address) {
        //         Address::create([
        //             'customer_id' => $customer->id,
        //             'name' => 'address of ' .$customer->name,
        //             'city_id' => $customer_address['city_id'],
        //             'area_id' => $customer_address['area_id'],
        //             'street' => $customer_address['street'],
        //             'building_number' => $customer_address['building_number'],
        //             'floor_number' => $customer_address['floor_number'],
        //             'landmark' => $customer_address['special_marque'],
        //         ]);
        //     }
        // }

        return redirect()->route('admin.customer.index')->with([
            'type' => 'success',
            'message' => 'Customer update successfuly'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $customer)
    {
        if ($customer->delete()) {
            $this->Make_Log('App\Models\User','delete',$customer->id);
            return redirect()->route('admin.customer.index')->with([
                'type' => 'success',
                'message' => 'Customer deleted successfuly'
            ]);
        }
    }
}
