@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add New Item</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url()->previous()}}">Back</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Item Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Item Arabic Name</label>
                                <select readonly class="form-control" name="category_id">
                                    <option value="">{{ $item->category['name_'.app()->getLocale()] }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Item Arabic Name</label>
                                <input readonly type="text" class="form-control" placeholder="Enter Item Arabic Name" name="name_ar" value="{{ $item->name_ar }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Item English Name</label>
                                <input readonly type="text" class="form-control" placeholder="Enter Item English Name" name="name_en" value="{{ $item->name_en }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Item Arabic Description</label>
                                <textarea readonly class="form-control" placeholder="Enter Item Arabic Description" name="description_ar">{{ $item->description_ar }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Item English Description</label>
                                <textarea readonly class="form-control {!! $errors->first('description_en', 'is-invalid') !!}" placeholder="Enter Item English Description" name="description_en">{{ $item->description_en }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Item Price</label>
                                <input readonly type="text" class="form-control {!! $errors->first('price', 'is-invalid') !!}" placeholder="Enter Item Price" name="price" value="{{ $item->price }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Item Calories</label>
                                <input readonly type="text" class="form-control {!! $errors->first('calories', 'is-invalid') !!}" placeholder="Enter Item Calories" name="calories" value="{{ $item->calories }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Image</label>
                                <img loading="lazy" data-lazy="true"  src="{{ $item->image }}" class="img-thumbnail" style="width: 77px;" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @endsection
