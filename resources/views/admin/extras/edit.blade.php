@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Extra {{ $extra->id }}</h1>
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
                    <form action="{{ route('admin.extra.update', $extra->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control select2 {!! $errors->first('category_id', 'is-invalid') !!}" name="category_id">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @if(old('category_id') == $category->id or $extra->category_id == $category->id) selected @endif >
                                                {{ $category['name_'.app()->getLocale()] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="col-md-6">

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Extra Arabic Name</label>
                                    <input type="text" class="form-control {!! $errors->first('name_ar', 'is-invalid') !!}" placeholder="Enter Extra Arabic Name" name="name_ar" value="{{ old('name_ar') ?? $extra->name_ar }}">
                                    {!! $errors->first('name_ar', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Extra English Name</label>
                                    <input type="text" class="form-control {!! $errors->first('name_en', 'is-invalid') !!}" placeholder="Enter Extra English Name" name="name_en" value="{{ old('name_en') ?? $extra->name_en }}">
                                    {!! $errors->first('name_en', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Extra Arabic Description</label>
                                    <textarea class="form-control {!! $errors->first('description_ar', 'is-invalid') !!}" placeholder="Enter Extra Arabic Description" name="description_ar">{{ old('description_ar') ?? $extra->description_ar }}</textarea>
                                    {!! $errors->first('description_ar', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Extra English Description</label>
                                    <textarea class="form-control {!! $errors->first('description_en', 'is-invalid') !!}" placeholder="Enter Extra English Description" name="description_en">{{ old('description_en') ?? $extra->description_en }}</textarea>
                                    {!! $errors->first('description_en', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Extra Price</label>
                                    <input type="number" step="0.01" class="form-control {!! $errors->first('price', 'is-invalid') !!}" placeholder="Enter Extra Price" name="price" value="{{ old('price') ?? $extra->price}}">
                                    {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Extra Calories</label>
                                    <input type="number" class="form-control {!! $errors->first('calories', 'is-invalid') !!}" placeholder="Enter Extra Calories" name="calories" value="{{ old('calories') ?? $extra->calories }}">
                                    {!! $errors->first('calories', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Image</label>
                                    <img src="{{ $extra->image }}" class="img-thumbnail" style="widht: 77px;" />
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input {!! $errors->first('image', 'is-invalid') !!}" name="image" value="{{ old('image') }}">
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                    </div>
                                    {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div> --}}
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
    $('.custom-file-input').on('change',function(){
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
    })

</script>
@endpush
