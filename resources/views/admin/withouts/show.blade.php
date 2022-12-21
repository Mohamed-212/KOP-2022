@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Without - {{$without->name_en}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-extra"><a href="{{route('admin.without.index')}}">Back</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Without Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category</label>
                                <select readonly class="form-control" name="category_id">
                                    <option value="">{{ $without->category['name_'.app()->getLocale()] }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Without Arabic Name</label>
                                <input readonly type="text" class="form-control" placeholder="Enter Without Arabic Name" name="name_ar" value="{{ $without->name_ar }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Without English Name</label>
                                <input readonly type="text" class="form-control" placeholder="Enter Without English Name" name="name_en" value="{{ $without->name_en }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Without Arabic Description</label>
                                <textarea readonly class="form-control" placeholder="Enter Without Arabic Description" name="description_ar">{{ $without->description_ar }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Without English Description</label>
                                <textarea readonly class="form-control {!! $errors->first('description_en', 'is-invalid') !!}" placeholder="Enter Without English Description" name="description_en">{{ $without->description_en }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Without Price</label>
                                <input readonly type="text" class="form-control {!! $errors->first('price', 'is-invalid') !!}" placeholder="Enter Without Price" name="price" value="{{ $without->price }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Without Calories</label>
                                <input readonly type="text" class="form-control {!! $errors->first('calories', 'is-invalid') !!}" placeholder="Enter Without Calories" name="calories" value="{{ $without->calories }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Image</label>
                                <img loading="lazy" data-lazy="true"  src="{{ $without->image }}" class="img-thumbnail" style="width: 77px;" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @endsection
