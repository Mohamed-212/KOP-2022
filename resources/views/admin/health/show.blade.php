@extends('layouts.admin.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> Health info - {{ $info->title_en }}</h1>
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
                        <h3 class="card-title">Health Info Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputArabicName">Arabic Title</label>
                                    <input readonly type="text" class="form-control" id="exampleInputArabicName"
                                           placeholder="Enter Arabic Name" name="name_ar" value="{{$info->title_ar}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEnglishName">English Name</label>
                                    <input readonly type="text" class="form-control" id="exampleInputEnglishName"
                                           placeholder="Enter English Name" name="name_en" value="{{$info->title_en}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputArabicDescription">Arabic Description</label>
                                    <textarea readonly class="form-control" id="exampleInputArabicDescription"
                                              placeholder="Enter Arabic Description"
                                              name="description_ar">{{$info->description_ar}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEnglishDescription">English Description</label>
                                    <textarea readonly class="form-control" id="exampleInputEnglishDescription"
                                              placeholder="Enter English Description"
                                              name="description_en">{{$info->description_en}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Image</label>
                                <br>
                                 @if($info->image)
                                 <img loading="lazy" data-lazy="true"  src="{{asset($info->image) }}" class="img-thumbnail w-100" style="height: 250px" />
                                  @endif
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>
@endsection
