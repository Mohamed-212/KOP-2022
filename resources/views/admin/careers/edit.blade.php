@extends('layouts.admin.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Job</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.careers.index')}}">Back</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Job Details</h3>
                    </div>
                    <form action="{{ route('admin.careers.update' , $job->id) }}" method="POST"
                          enctype="multipart/form-data" id="add-category">
                        @csrf
                        @method('PATCH')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputArabicName">Arabic Title</label>
                                        <input type="text" class="form-control" id="exampleInputArabicName"
                                               placeholder="Enter Arabic Name" name="title_ar" value="{{$job->title_ar}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEnglishName">English Title</label>
                                        <input type="text" class="form-control" id="exampleInputEnglishName"
                                               placeholder="Enter English Name" name="title_en" value="{{$job->title_en}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputArabicDescription">Arabic Description</label>
                                        <textarea class="form-control" id="exampleInputArabicDescription"
                                                  placeholder="Enter Arabic Description"
                                                  name="description_ar">{{$job->description_ar}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEnglishDescription">English Description</label>
                                        <textarea class="form-control" id="exampleInputEnglishDescription"
                                                  placeholder="Enter English Description"
                                                  name="description_en">{{$job->description_en}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputArabicDescription">Arabic Brief Description</label>
                                        <textarea class="form-control" id="exampleInputArabicDescription"
                                                  placeholder="Enter Arabic Brief Description"
                                                  name="brief_description_ar">{{$job->brief_description_ar}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEnglishDescription">English Brief Description</label>
                                        <textarea class="form-control" id="exampleInputEnglishDescription"
                                                  placeholder="Enter English Brief Description"
                                                  name="brief_description_en">{{$job->brief_description_en}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputArabicDescription">Arabic Responsibilities</label>
                                        <textarea class="form-control" id="exampleInputArabicDescription"
                                                  placeholder="Enter Arabic Responsibilities"
                                                  name="responsibilities_ar">{{$job->responsibilities_ar}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEnglishDescription">English Responsibilities</label>
                                        <textarea class="form-control" id="exampleInputEnglishDescription"
                                                  placeholder="Enter English Responsibilities"
                                                  name="responsibilities_en">{{$job->responsibilities_en}}</textarea>
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
