<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Extra;
use App\Filters\ExtraFilters;
use App\Models\Category;
use App\Traits\LogfileTrait;

class ExtraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use LogfileTrait;

    public function index(Request $request, ExtraFilters $filters)
    {
        $categories = Category::orderBy('id', 'DESC')->get();
        $extras = Extra::filter($filters)->orderBy('id', 'DESC')->get();
        $this->Make_Log('App\Models\Extra','view',0);
        return view('admin.extras.index', compact('categories', 'extras'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.extras.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "name_ar" => 'required|string',
            "name_en" => 'required|string',
            "description_ar" => 'nullable|required|string',
            "description_en" => 'nullable|required|string',
            "price" => 'required',
            "calories" => 'required|numeric',
            // 'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            "category_id" => 'required|exists:categories,id',
        ]);

        $extra = Extra::create($validatedData);
        $this->Make_Log('App\Models\Extra','create',$extra->id);
        if ($request->hasFile('image'))
        {
            $image = $request->image;
            $image_new_name = time(). $image->getClientOriginalName();
            $image->move(public_path('extras'), $image_new_name);
            $extra->image = '/extras/' . $image_new_name;
            $extra->save();
        }

        if (!$extra)
            return redirect()->route('admin.extra.index')->with([
                'type' => 'error',
                'message' => 'There is something wrong!!'
            ]);

        return redirect()->route('admin.extra.index')->with([
            'type' => 'success',
            'message' => 'Menu Update successfuly'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Extra $extra)
    {
        return view('admin.extras.show', compact('extra'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Extra $extra)
    {
        $categories = Category::all();
        return view('admin.extras.edit', compact('extra', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Extra $extra)
    {

        $validatedData = $request->validate([
            "name_ar" => 'required|string',
            "name_en" => 'required|string',
            "description_ar" => 'nullable|required|string',
            "description_en" => 'nullable|required|string',
            "price" => 'required',
            "calories" => 'required|numeric',
            // 'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            "category_id" => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('image'))
        {
            $image = $request->image;
            $image_new_name = time(). $image->getClientOriginalName();
            $image->move(public_path('extras'), $image_new_name);
            $extra->image = '/extras/' . $image_new_name;
            $extra->save();
        }

        if (!$extra->update($validatedData))
            return redirect()->route('admin.extra.index')->with([
                'type' => 'error',
                'message' => 'test'
            ]);
        $this->Make_Log('App\Models\Extra','update',$extra->id);
        return redirect()->route('admin.extra.index')->with([
            'type' => 'success',
            'message' => 'Menu Update successfuly'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Extra $extra)
    {

        $extra->delete();
        $this->Make_Log('App\Models\Extra','delete',$extra->id);
        return redirect()->back()->with([
            'type' => 'success',
            'message' => 'Menu extra deleted successfuly'
        ]);

    }
}
