@extends('layouts.admin.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Health Info</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.healthinfo.index')}}">Back</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Category Details</h3>
                    </div>
                    <form action="{{ route('admin.healthinfo.update' , $info->id) }}" method="POST"
                          enctype="multipart/form-data" id="add-category">
                        @csrf
                        @method('PATCH')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputArabicName">Arabic Title</label>
                                        <input type="text" class="form-control" id="exampleInputArabicName"
                                               placeholder="Enter Arabic Name" name="title_ar" value="{{$info->title_ar}}">
                                        @error('title_ar')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEnglishName">English Title</label>
                                        <input type="text" class="form-control" id="exampleInputEnglishName"
                                               placeholder="Enter English Name" name="title_en" value="{{$info->title_en}}">
                                        @error('title_en')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputArabicDescription">Arabic Description</label>
                                        <textarea class="form-control" id="exampleInputArabicDescription"
                                                  placeholder="Enter Arabic Description"
                                                  name="description_ar">{{$info->description_ar}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEnglishDescription">English Description</label>
                                        <textarea class="form-control" id="exampleInputEnglishDescription"
                                                  placeholder="Enter English Description"
                                                  name="description_en">{{$info->description_en}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Image</label>
                                        <div class="help-block text-info">
                                            <b>Note</b> Image dimensions: 1000 * 650
                                            <p class="text-info">
                                                <b>Note</b> Image types: png | jpeg | jpg
                                            </p>
                                        </div>
                                        <img src="{{ asset($info->image) }}" class="img-thumbnail" style="width: 250px;" />
                                        <div class="custom-file">
                                            <input type="file"
                                                class="custom-file-input {!! $errors->first('image', 'is-invalid') !!}"
                                                id="exampleInputFile" name="image" value="{{old('image')}}">
                                            @error('image')
                                            <div class="help-block">{{ $message }}</div>
                                            @enderror
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
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
        $( document ).ready(function() {

            $('.custom-file-input').on('change',function(){

                //get the file name
                var fileName = $(this).val();

                //replace the "Choose a file" label
                $(this).next('.custom-file-label').html(fileName);
            })

            $('input').change(function (e) {
                // Warning
                $(window).on('beforeunload', function(){
                    return "Are you sure you want to navigate away from this page?";
                });

                // Form Submit
                $(document).on("submit", "form", function(event){
                    // disable unload warning
                    $(window).off('beforeunload');
                });

            });

        });
    </script>
@endpush
