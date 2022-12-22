@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Extra - {{$extra->name_en}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-extra"><a href="{{route('admin.extra.index')}}">Back</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Extra Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category</label>
                                <select readonly class="form-control" name="category_id">
                                    <option value="">{{ $extra->category['name_'.app()->getLocale()] }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Extra Arabic Name</label>
                                <input readonly type="text" class="form-control" placeholder="Enter Extra Arabic Name" name="name_ar" value="{{ $extra->name_ar }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Extra English Name</label>
                                <input readonly type="text" class="form-control" placeholder="Enter Extra English Name" name="name_en" value="{{ $extra->name_en }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Extra Arabic Description</label>
                                <textarea readonly class="form-control" placeholder="Enter Extra Arabic Description" name="description_ar">{{ $extra->description_ar }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Extra English Description</label>
                                <textarea readonly class="form-control {!! $errors->first('description_en', 'is-invalid') !!}" placeholder="Enter Extra English Description" name="description_en">{{ $extra->description_en }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Extra Price</label>
                                <input readonly type="text" class="form-control {!! $errors->first('price', 'is-invalid') !!}" placeholder="Enter Extra Price" name="price" value="{{ $extra->price }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Extra Calories</label>
                                <input readonly type="text" class="form-control {!! $errors->first('calories', 'is-invalid') !!}" placeholder="Enter Extra Calories" name="calories" value="{{ $extra->calories }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Image</label>
                                <img loading="lazy" data-lazy="true"  src="{{ $extra->image }}" class="img-thumbnail" style="width: 77px;" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @endsection
