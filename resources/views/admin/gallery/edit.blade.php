@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Gallery</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.gallery.index')}}">Back</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Gallery Details</h3>
                </div>
                <form action="{{ route('admin.gallery.update' , $gallery->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img loading="lazy" data-lazy="true"  id="image" src="{{asset($gallery->url)}}" class="img-thumbnail w-100 p-3" style="height: 250px;">
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <input type="hidden" name="id" value="{{$gallery->id}}">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="title_en">Title English</label>
                                            <input type="text"
                                                   class="form-control"
                                                   id="title_en" placeholder="Enter Title" value="{{$gallery->title_en}}" name="title_en" >
                                            @error('title_en')
                                            <div class="help-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="title_ar">Title Arabic</label>
                                            <input type="text"
                                                   class="form-control "
                                                   id="title_ar" placeholder="Enter Title" value="{{$gallery->title_ar}}" name="title_ar" >
                                            @error('title_ar')
                                            <div class="help-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Image <span style="color: #0f7ae5">hint: dimensional 600*600</span> <p class="text-info">
                                                <b>Note</b> Image types: png | jpeg | jpg
                                            </p> </label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input id="fileimage" type="file" class="custom-file-input {!! $errors->first('url', 'is-invalid') !!}" name="url" >
                                                    @error('url')
                                                    <div class="help-block">{{ $message }}</div>
                                                    @enderror
                                                    <label class="custom-file-label">Choose image</label>
                                                </div>
                                            </div>
                                            {!! $errors->first('url', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
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
        $(document).ready(function() {
            $('#fileimage').change(function(){
                var input = this;
                var url = $(this).val();
                var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
                {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#image').attr('src',e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                else
                {
                    $('#fileimage').html('You can upload images only')
                }
            });
        });
    </script>
@endpush
