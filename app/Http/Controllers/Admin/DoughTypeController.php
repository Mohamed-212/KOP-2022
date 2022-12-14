<?php

namespace App\Http\Controllers\Admin;

use App\Models\DoughType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class DoughTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DoughType::where('id', '!=', 9)->get();

        return view('admin.dough.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dough.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $groups = DoughType::all();

        $req = request()->validate([
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
        ]);

        DoughType::create($req);

        return redirect()->route('admin.dough.index')->with([
            'type' => 'success',
            'message' => 'New dough type Created successfuly'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DoughType  $doughType
     * @return \Illuminate\Http\Response
     */
    public function show(DoughType $doughType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DoughType  $doughType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $doughType = DoughType::findOrFail($id);
        return view('admin.dough.edit', compact('doughType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DoughType  $doughType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $req = request()->validate([
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
        ]);

        $doughType = DoughType::findOrFail($id);

        try {
        $doughType->fill($req);
        $doughType->save();

        return redirect()->route('admin.dough.index')->with([
            'type' => 'success',
            'message' => 'New dough type Created successfuly'
        ]);
        } catch (Exception $e) {
            return redirect()->route('admin.dough.index')->with([
                'type' => 'error',
                'message' => 'There is something'
            ]);
        }

        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DoughType  $doughType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $doughType = DoughType::findOrFail($id);
        $doughType->delete();

        return redirect()->route('admin.dough.index')->with([
            'type' => 'error',
            'message' => 'Dough Type Deleted Successfully'
        ]);
    }
}
