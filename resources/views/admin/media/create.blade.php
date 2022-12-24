@extends('layouts.admin.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add New Media</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.media.index') }}">Back</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Media Details</h3>
                    </div>
                    <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title_en">Title English</label>
                                        <input type="text" class="form-control" id="title_en" placeholder="Enter Title"
                                            name="title_en" value="{{ old('title_en') }}">
                                        @error('title_en')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title_ar">Title Arabic</label>
                                        <input type="text" class="form-control " id="title_ar" placeholder="Enter Title"
                                            name="title_ar" value="{{ old('title_ar') }}">
                                        @error('title_ar')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="author">Author</label>
                                        <div class="help-block text-info">
                                            .
                                        </div>
                                        <input type="text" class="form-control" id="author"
                                            placeholder="Enter Author Name" name="author" value="{{ old('author') }}">
                                        @error('author')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Video</label>
                                        <div class="help-block text-info">
                                            <b>Note:</b> Video Minimum dimensions: 720 * 650
                                            <br>
                                            <b>Note:</b> Video types: mp4 | ogg | wmv
                                        </div>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input {!! $errors->first('url', 'is-invalid') !!}"
                                                    name="url" value="{{ old('url') }}">
                                                <label class="custom-file-label">Choose Video</label>
                                            </div>
                                        </div>
                                        @error('url')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image</label>
                                        <div class="help-block text-info">
                                            <b>Note:</b> Image dimensions: 150 * 150
                                            <br>
                                            <b>Note:</b> Image types: png | jpeg | jpg
                                        </div>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input {!! $errors->first('img', 'is-invalid') !!}"
                                                    name="img" value="{{ old('img') }}">
                                                <label class="custom-file-label">Choose Image</label>
                                            </div>
                                        </div>
                                        @error('img')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
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
