@extends('layouts.admin.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add New Health Info</h1>
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
                        <h3 class="card-title">Health Info  Details</h3>
                    </div>
                    <form action="{{ route('admin.healthinfo.store') }}" method="POST" enctype="multipart/form-data"
                          id="add-category">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputArabicName">Arabic Title</label>
                                        <input type="text" class="form-control" id="exampleInputArabicTitle"
                                               placeholder="Enter Arabic Title" name="title_ar">
                                        @error('title_ar')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEnglishName">English Title</label>
                                        <input type="text" class="form-control" id="exampleInputEnglishTitle"
                                               placeholder="Enter English Title" name="title_en">
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
                                                  placeholder="Enter Arabic Description" name="description_ar"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEnglishDescription">English Description</label>
                                        <textarea class="form-control" id="exampleInputEnglishDescription"
                                                  placeholder="Enter English Description" name="description_en"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Image</label>
                                        <div class="help-block text-info">
                                            <b>Note:</b> Image dimensions: 1000 * 650
                                            <br>
                                            <b>Note:</b> Image types: png | jpeg | jpg
                                        </div>
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
   
</script>
@endpush
