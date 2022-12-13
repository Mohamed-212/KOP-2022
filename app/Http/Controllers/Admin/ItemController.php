<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Filters\ItemFilters;
use App\Models\Category;
use App\Models\Branch;
use App\Models\HomeItem;
use Illuminate\Support\Facades\Validator;

use App\Traits\LogfileTrait;


class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
           
    use LogfileTrait;

    public function index(Request $request, ItemFilters $filters)
    {
        $categories = Category::orderBy('id', 'DESC')->get();
        $items = Item::filter($filters)->orderBy('id', 'DESC')->get();
        $this->Make_Log('App\Models\Item','view',0);
        return view('admin.items.index', compact('categories', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        $branches = Branch::all();

        return view('admin.items.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "name_ar" => 'required|string',
            "name_en" => 'required|string',
            "description_ar" => 'nullable|required|string',
            "description_en" => 'nullable|required|string',
            "price" => 'required|numeric',
            "calories" => 'required|numeric',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website_image' => 'required|mimes:jpeg,png,jpg,gif,svg|dimensions:width=300,height=300',
            "category_id" => 'required|exists:categories,id',
        ]);


        if ($request->hasFile('image')) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move(public_path('items'), $image_new_name);
            $validatedData['image'] = '/items/' . $image_new_name;
        }
        if ($request->hasFile('website_image')) {
            $image = $request->website_image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move(public_path('items'), $image_new_name);
            $validatedData['website_image'] = '/items/' . $image_new_name;
        }
        $item = Item::create($validatedData);
        // $item->branches = $request->branches;
        // $item->out_of_stock = $request->out_of_stock;
        $item->branches = implode(',', $request->branches);
        $item->out_of_stock = implode(',', $request->out_of_stock);
        $item->save();

        $this->Make_Log('App\Models\Item','create',$item->id);
        if (!$item)
            return redirect()->route('admin.item.index')->with([
                'type' => 'error',
                'message' => 'test'
            ]);

        return redirect()->route('admin.item.index')->with([
            'type' => 'success',
            'message' => 'Item Update successfully'
        ]);
    }


    public function uploadImage(Request $request, $input_name = 'image', $user = null)
    {

        $ds = DIRECTORY_SEPARATOR;

        if ($request->has($input_name)) {
            $image = $request->file($input_name);

            $name = rand() . '_item_' . rand() . rand() . '.' . $image->getClientOriginalExtension();

            $folder = $ds . 'img' . $ds . 'items' . DIRECTORY_SEPARATOR;

            $filePath = $folder . $name;

            //dd(request()->{$input_name}->getSize() / (1024 * 1024));
            if (request()->{$input_name}->getSize() / (1024 * 1024) >= 2) {
                $this->compress(request()->{$input_name}, public_path($filePath));
                return $filePath;
            }

            request()->{$input_name}->move(public_path($folder), $name);
        }
        return $filePath;
    }

    public function compress($source, $path)
    {
        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source);

        $try = imagejpeg($image, $path, 60);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Item $item)
    {
        return view('admin.items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Item $item)
    {
        $categories = Category::all();
        $userBranches = auth()->user()->branches;

        $itemBranches = explode(',', $item->branches);

        $outOfStockBr = explode(',', $item->out_of_stock);

        $userBranches = Branch::all();

        return view('admin.items.edit', compact('item', 'categories', 'userBranches', 'itemBranches', 'outOfStockBr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $validatedData = $request->validate([
            "name_ar" => 'required|string',
            "name_en" => 'required|string',
            "description_ar" => 'nullable|required|string',
            "description_en" => 'nullable|required|string',
            "price" => 'required|numeric',
            "calories" => 'required|numeric',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|dimensions:width=300,height=300',
            "category_id" => 'required|exists:categories,id',
        ]);


        if ($request->hasFile('image')) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move(public_path('items'), $image_new_name);
            $validatedData['image'] = '/items/' . $image_new_name;
        }
        if ($request->hasFile('website_image')) {
            $image = $request->website_image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move(public_path('items'), $image_new_name);
            $validatedData['website_image'] = '/items/' . $image_new_name;
        }
        
        if (!$item->update($validatedData))
            return redirect()->route('admin.item.index')->with([
                'type' => 'error',
                'message' => 'test'
            ]);

        $itemBranches = explode(',', $item->branches);

        $userBranches = auth()->user()->branches;
        $branches = $userBranches->pluck('id')->toArray();
        // foreach ($itemBranches as $itemBranch) {

        //     if (($key = array_search($itemBranch, $branches)) !== false) {
        //         unset($branches[$key]);
        //     }
        // }
        $r = (array_diff($itemBranches, $branches));
        if (!$request->branches == null) {
            foreach ($request->branches as $branch) {
                $r[] = $branch;
            }
        }

        $item->branches = implode(',', $request->branches);
        $item->out_of_stock = implode(',', $request->out_of_stock);
        $item->save();

        // dd($item->branches);

        $this->Make_Log('App\Models\Item','update',$item->id);
        return redirect()->route('admin.item.index')->with([
            'type' => 'success',
            'message' => 'Item Update successfuly'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Item $item)
    {
        $item->delete();
        $this->Make_Log('App\Models\Item','delete',$item->id);
        return redirect()->back()->with([
            'type' => 'error', 'message' => 'Item deleted successfuly'
        ]);
    }

    public function getCategory($category)
    {
        $category = Category::findOrFail($category);

        $items = Item::where('category_id', $category->id)->get();

        return response()->json([
            'status' => 1,
            'message' => 'success',
            'data' => $items
        ]);
    }

    public function dealOfWeekItem(ItemFilters $filters)
    {
        $categories = Category::all();
        $items = Item::filter($filters)->get(); 
        return view('admin.dealOfWeek.index', compact('categories', 'items'));
    }

    public function dealOfWeekStatus($itemId)
    {
        $item = Item::find($itemId);
        $item->best_seller = ($item->best_seller == 'activate')? 'deactivate':'activate';
        $item->save();
         $this->Make_Log('App\Models\Item','dealOfWeekStatus',$itemId);
        return response()->json([
            'message' => 'success',
            'data' => $item->best_seller
        ]);
    }

    public function recommend(Item $item)
    {
        $item->recommended = true;
        $item->save();

        return back();
    }

    public function unRecommend(Item $item)
    {
        $item->recommended = false;
        $item->save();

        return back();
    }

    public function Homeitem(Request $request)
    {
        $homeitems = HomeItem::all()->load('item','category');
        return view('admin.homeitem.index',compact('homeitems'));
    }

    public function Create_Homeitem(Request $request)
    {
        $categories=Category::all();
        return view('admin.homeitem.create',compact('categories'));
    }
    public function Store_Homeitem(Request $request)
    {
        $validatedData = $request->validate([
            "description_ar" => 'required|string',
            "description_en" => 'required|string',
            "category_id" => 'required|exists:categories,id',
            "item_id" => 'required|exists:items,id',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'number' => 'required|unique:home_item',
        ]);


        if ($request->hasFile('image')) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move(public_path('items'), $image_new_name);
            $validatedData['image'] = '/items/' . $image_new_name;
        }
        
        $HomeItem = HomeItem::create($validatedData);
        $this->Make_Log('App\Models\HomeItem','create',$HomeItem->id);
        
        if (!$HomeItem)
            return redirect()->route('admin.homeitem.index')->with([
                'type' => 'error',
                'message' => 'test'
            ]);

        return redirect()->route('admin.homeitem.index')->with([
            'type' => 'success',
            'message' => 'homeitem Update successfully'
        ]);
    }
    public function Edit_Homeitem(Request $request ,HomeItem $homeitem)
    {
        $categories = Category::all();
        $homeitem->load('item','category');
        return view('admin.homeitem.edit',compact('categories','homeitem'));
    }
    public function Update_Homeitem(Request $request ,HomeItem $homeitem)
    {
        $validatedData = $request->validate([
            "description_ar" => 'required|string',
            "description_en" => 'required|string',
            "category_id" => 'required|exists:categories,id',
            "item_id" => 'required|exists:items,id',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        if ($request->hasFile('image')) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move(public_path('items'), $image_new_name);
            $validatedData['image'] = '/items/' . $image_new_name;
        }
        
        if (!$homeitem->update($validatedData))
            return redirect()->route('admin.homeitem.index')->with([
                'type' => 'error',
                'message' => 'test'
            ]);

  
        $homeitem->save();

        $this->Make_Log('App\Models\homeitem','update',$homeitem->id);
        return redirect()->route('admin.homeitem.index')->with([
            'type' => 'success',
            'message' => 'homeitem Update successfuly'
        ]);

    }

    public function Destroy_Homeitem(Request $request, HomeItem $homeitem)
    {
        $homeitem->update([
            "description_ar" => null,
            "description_en" => null,
            "category_id" => null,
            "item_id" => null,
            'image' => null,
        ]);
        $this->Make_Log('App\Models\HomeItem','delete',$homeitem->id);
        return redirect()->back()->with([
            'type' => 'error', 'message' => 'homeitem deleted successfuly'
        ]);
    }
   
}
