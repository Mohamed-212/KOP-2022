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
                            <li class="breadcrumb-item"><a href="{{ route('admin.item.index') }}">Back</a></li>
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
                        <form action="{{ route('admin.item.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Choose Category</label>
                                        <select class="form-control select2 {!! $errors->first('category_id', 'is-invalid') !!}" name="category_id">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (old('category_id') == $item->id) selected @endif>
                                                    {{ $item['name_' . app()->getLocale()] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                @if (auth()->user()->hasRole('admin'))
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputRole">Hide In</label>
                                        <select class="select2" multiple="multiple" data-placeholder="Select a Branch"
                                            style="width: 100%;" name="branches[]">
                                            @foreach ($branches as $userBranch)
                                            <option value="{{ $userBranch->id }}">{{ $userBranch->name_en }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="row">
                                @if (auth()->user()->hasRole('admin'))
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputRole">Out Of Stock In</label>
                                        <select class="select2" multiple="multiple" data-placeholder="Select a Branch" style="width: 100%;" name="out_of_stock[]">
                                            @foreach ($branches as $userBranch)
                                        <option value="{{ $userBranch->id }}">{{ $userBranch->name_en }}
                                        </option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Item Arabic Name</label>
                                        <input type="text" class="form-control {!! $errors->first('name_ar', 'is-invalid') !!}"
                                            placeholder="Enter Item Arabic Name" name="name_ar"
                                            value="{{ old('name_ar') ?? '' }}">
                                        {!! $errors->first('name_ar', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Item English Name</label>
                                        <input type="text" class="form-control {!! $errors->first('name_en', 'is-invalid') !!}"
                                            placeholder="Enter Item English Name" name="name_en"
                                            value="{{ old('name_en') ?? '' }}">
                                        {!! $errors->first('name_en', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Item Arabic Description</label>
                                        <textarea class="form-control {!! $errors->first('description_ar', 'is-invalid') !!}" placeholder="Enter Item Arabic Description"
                                            name="description_ar">{{ old('description_ar') ?? '' }}</textarea>
                                        {!! $errors->first('description_ar', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Item English Description</label>
                                        <textarea class="form-control {!! $errors->first('description_en', 'is-invalid') !!}" placeholder="Enter Item English Description"
                                            name="description_en">{{ old('description_en') }}</textarea>
                                        {!! $errors->first('description_en', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Item Price</label>
                                        <input type="number" step="any" class="form-control {!! $errors->first('price', 'is-invalid') !!}"
                                            placeholder="Enter Item Price" name="price" value="{{ old('price') }}">
                                        {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Item Calories</label>
                                        <input type="number" class="form-control {!! $errors->first('calories', 'is-invalid') !!}"
                                            placeholder="Enter Item Calories" name="calories"
                                            value="{{ old('calories') }}">
                                        {!! $errors->first('calories', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Mobile Image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input {!! $errors->first('image', 'is-invalid') !!}"
                                                    name="image" value="{{ old('image') }}">
                                                <label class="custom-file-label">Choose file</label>
                                            </div>
                                        </div>
                                        {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Website Image</label>
                                        <div class="help-block text-info">
                                            <b>Note:</b> Image Dimensions Must Be: 300 * 300
                                        </div>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input {!! $errors->first('website_image', 'is-invalid') !!}"
                                                    name="website_image" value="{{ old('website_image') }}">
                                                <label class="custom-file-label">Choose file</label>
                                            </div>
                                        </div>
                                        {!! $errors->first('website_image', '<p class="help-block">:message</p>') !!}
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
        window.onbeforeunload = function() {
            return 'Are you sure? Your work will be lost. ';
        };
        $('.custom-file-input').on('change', function() {
            //get the file name
            var fileName = $(this).val();
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        })
    </script>
@endpush
