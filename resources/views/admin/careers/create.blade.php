@extends('layouts.admin.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add New Category</h1>
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
                    <form action="{{ route('admin.careers.store') }}" method="POST" enctype="multipart/form-data"
                          id="add-category">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputArabicName">Arabic Title</label>
                                        <input type="text" class="form-control" id="exampleInputArabicTitle"
                                               placeholder="Enter Arabic Title" name="title_ar">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEnglishName">English Title</label>
                                        <input type="text" class="form-control" id="exampleInputEnglishTitle"
                                               placeholder="Enter English Title" name="title_en">
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
                                        <label for="exampleInputArabicDescription">Arabic Brief Description</label>
                                        <textarea class="form-control" id="exampleInputArabicBriefDescription"
                                                  placeholder="Enter Arabic Brief Description" name="brief_description_ar"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEnglishDescription">English Brief Description</label>
                                        <textarea class="form-control" id="exampleInputEnglishBriefDescription"
                                                  placeholder="Enter English Brief Description" name="brief_description_en"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputArabicDescription">Arabic Responsibilities</label>
                                        <textarea class="form-control" id="exampleInputArabicResponsibilities"
                                                  placeholder="Enter Arabic Description" name="responsibilities_ar"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEnglishDescription">English Responsibilities</label>
                                        <textarea class="form-control" id="exampleInputEnglishResponsibilities"
                                                  placeholder="Enter English Description" name="responsibilities_en"></textarea>
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

