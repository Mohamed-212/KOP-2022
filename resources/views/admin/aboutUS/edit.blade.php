@extends('layouts.admin.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit About US</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.aboutUS.index')}}">Back</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">AboutUS Details</h3>
                    </div>
                    <form action="{{ route('admin.aboutUS.update' , $about->id) }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title_en">Title English</label>
                                        <input type="text"
                                               class="form-control"
                                               id="title_en" placeholder="Enter Title" value="{{$about->title_en}}"
                                               name="title_en">
                                        @error('title_en')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title_ar">Title Arabic</label>
                                        <input type="text"
                                               class="form-control "
                                               id="title_ar" placeholder="Enter Title" value="{{$about->title_ar}}"
                                               name="title_ar">
                                        @error('title_ar')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title_ar">Type</label>
                                        <select name="type" class="form-control">
                                            @foreach (['first', 'bg-st', 'bg-nd', 'emp', 'with-bg'] as $ty)
                                                <option value="{{$ty}}" @if(old('type') === $ty) selected @endif @if($about->type === $ty) selected @endif>
                                                    {{__('general.'. $ty)}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('type')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                @if ($about->type === 'feat')
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title_ar">Icon</label>
                                        <input type="text"
                                               class="form-control "
                                               id="title_ar" placeholder="Enter Icon Name" name="icon" value="{{old('icon')}}" >
                                        @error('icon')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group d-flex align-items-center justify-content-center">
                                            select icon from &nbsp; <a href='https://fontawesome.com/v4/icons/' target="_blank">Here</a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description_en">Description English</label>
                                        <textarea rows="5" class="form-control p-1" id="description_en"
                                                  placeholder="Enter Description" name="description_en"
                                        >{{$about->description_en}}</textarea>
                                        @error('description_en')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description_ar">Description Arabic</label>
                                        <textarea rows="5" class="form-control p-1" id="description_ar"
                                                  placeholder="Enter Description"
                                                  name="description_ar">{{$about->description_ar}}</textarea>
                                        @error('description_ar')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <img loading="lazy" data-lazy="true"  src="{{asset($about->image) }}" class="img-thumbnail w-100" style="height: 250px" />
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile">
                                            Image
                                        </label>
                                            <div class="help-block text-info">
                                                <b>Note:</b> Image dimensions: <span class="img-size">
                                                    @if ($about->type === 'emp')
                                                    800 * 1142
                                                    @elseif ($about->type === 'with-bg')
                                                    1100 * 1000
                                                    @else
                                                    600 * 400
                                                    @endif
                                                </span>
                                                <br>
                                                <b>Note:</b> Image types: png | jpeg | jpg
                                            </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input {!! $errors->first('image', 'is-invalid') !!}"
                                                id="exampleInputFile" name="image" value="{{ old('image') }}">
                                            @error('image')
                                                <div class="help-block">{{ $message }}</div>
                                            @enderror
                                            <label class="custom-file-label" for="exampleInputFile">Choose image</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if ($about->type === 'first')
                            <div class="row" id="wvideo">
                                <div class="col-md-6">
                                    <iframe class="w-100" height="250"
                                        src="{{asset($about->video)}}?controls=0">
                                    </iframe>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="video-file">Video</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input {!! $errors->first('video', 'is-invalid') !!}"
                                                id="video-file" name="video" value="{{ old('video') }}">
                                            @error('video')
                                                <div class="help-block">{{ $message }}</div>
                                            @enderror
                                            <label class="custom-file-label" for="video-file">Choose video</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if ($about->type === 'emp')
                                <div class="row" id="links">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="facebook">Facebook</label>
                                            <input type="url" class="form-control " id="facebook"
                                                placeholder="Enter Profile Link" name="links[]" value="{{$about->links[0]}}" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="twitter">Twitter</label>
                                            <input type="url" class="form-control " id="twitter"
                                                placeholder="Enter Profile Link" name="links[]" value="{{$about->links[1]}}" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="instgram">Instgram</label>
                                            <input type="url" class="form-control " id="instgram"
                                                placeholder="Enter Profile Link" name="links[]" value="{{$about->links[2]}}" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="behance">Behance</label>
                                            <input type="url" class="form-control " id="behance"
                                                placeholder="Enter Profile Link" name="links[]" value="{{$about->links[3]}}" />
                                        </div>
                                    </div>
                                </div>
                                @endif
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('js')
<script>
    window.onbeforeunload = function () {
        return 'Are you sure? Your work will be lost. ';
    };
 
</script>
@endpush
