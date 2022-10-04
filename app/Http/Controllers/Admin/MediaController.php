<?php

namespace App\Http\Controllers\Admin;

use App\Models\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\LogfileTrait;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use LogfileTrait;

    public function index(Request $request)
    {
        $medias = Media::orderBy('id', 'DESC')->get();
        $this->Make_Log('App\Models\Media', 'view', 0);
        return view('admin.media.index', compact('medias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.media.create');
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
            'title_ar' => ['required', 'string', 'unique:media,title_ar'],
            'title_en' => ['required', 'string', 'unique:media,title_en'],
            // 'author' => ['required', 'string'],
            "url" => 'required|mimes:mp4,ogg,wmv',
            'img' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=150,height=150',
        ]);
        try {
            $media = new Media();
            $media->title_ar = $request->title_ar;
            $media->title_en = $request->title_en;
            $media->author = '';
            if ($request->hasFile('url')) {
                $video = $request->url;
                $video_new_name = time() . $video->getClientOriginalName();
                $video->move(public_path('media'), $video_new_name);
                $media->url = '/media/' . $video_new_name;
            }

            $img = null;
            if ($request->hasFile('img')) {
                $img = $request->img;
                $img_new_name = time() . $img->getClientOriginalName();
                $img->move(public_path('media'), $img_new_name);
                $img = '/media/' . $img_new_name;
            }
            $media->img = $img;
            $media->save();
            $this->Make_Log('App\Models\Media', 'create', $media->id);
            return redirect()->route('admin.media.index')->with([
                'type' => 'success',
                'message' => 'New Media Created successfuly'
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.media.index')->with([
                'type' => 'error',
                'message' => 'There is something'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $media = Media::findOrFail($id);
        return view('admin.media.show', compact('media'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $media = Media::findOrFail($id);
        return view('admin.media.edit', compact('media'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title_ar' => ['required', 'unique:media,title_ar,' . $request->id],
            'title_en' => ['required', 'unique:media,title_en,' . $request->id],
            // 'author' => ['required'],
            "url" => 'mimes:mp4,ogx,oga,ogv,ogg,webm,flv,wmv',
            'img' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=150,height=150',
        ]);
        try {
            $media = Media::findOrFail($id);
            $media->title_ar = $request->title_ar;
            $media->title_en = $request->title_en;
            $media->author = '';
            if ($request->hasFile('url')) {
                $oldVideo = $media->url;
                $video = $request->url;
                $video_new_name = time() . $video->getClientOriginalName();
                $video->move(public_path('media'), $video_new_name);
                $media->url = '/media/' . $video_new_name;
            }
            $img = $media->img;
            if ($request->hasFile('img')) {
                $oldImage = $media->img;
                $img = $request->img;
                $img_new_name = time() . $img->getClientOriginalName();
                $img->move(public_path('media'), $img_new_name);
                $img = '/media/' . $img_new_name;
            }
            $media->img = $img;
            $media->save();
            if ($request->hasFile('url')) {
                if (file_exists(public_path($oldVideo))) {
                    unlink(public_path($oldVideo));
                }
            }
            if ($request->hasFile('img')) {
                if (file_exists(public_path($oldImage))) {
                    unlink(public_path($oldImage));
                }
            }
            $this->Make_Log('App\Models\Media', 'update', $media->id);
            return redirect()->route('admin.media.index')->with([
                'type' => 'success',
                'message' => 'New media updated successfuly'
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.media.index')->with([
                'type' => 'error',
                'message' => 'There is something'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $media = Media::findOrFail($id);
        if (file_exists(public_path($media->url))) {
            unlink(public_path($media->url));
        }
        $media->delete();
        $this->Make_Log('App\Models\Media', 'delete', $media->id);
        return back();
    }
}
