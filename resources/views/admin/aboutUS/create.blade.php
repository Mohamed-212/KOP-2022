@extends('layouts.admin.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add New About US</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.aboutUS.index') }}">Back</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">AboutUS Details</h3>
                    </div>
                    <form action="{{ route('admin.aboutUS.store') }}" method="POST" enctype="multipart/form-data">
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
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title_ar">Type</label>
                                        <select name="type" id="type" class="form-control">
                                            @foreach (['first', 'bg-st', 'bg-nd', 'emp', 'with-bg'] as $ty)
                                                <option value="{{ $ty }}"
                                                    @if (old('type') === $ty) checked @endif>
                                                    {{ __('general.' . $ty) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('type')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6" style="display: none" id="icon-sec">
                                    <div class="form-group">
                                        <label for="title_ar">Icon</label>
                                        <input type="text" class="form-control " id="title_ar"
                                            placeholder="Enter Icon Name" name="icon" value="{{ old('icon') }}">
                                        @error('icon')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group d-flex align-items-center justify-content-center">
                                            select icon from &nbsp; <a href='https://fontawesome.com/v4/icons/'
                                                target="_blank">Here</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="desc">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description_en">Description English</label>
                                        <textarea rows="5" class="form-control p-1" id="description_en" placeholder="Enter Description"
                                            name="description_en">{{ old('description_en') }}</textarea>
                                        @error('description_en')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description_ar">Description Arabic</label>
                                        <textarea rows="5" class="form-control p-1" id="description_ar" placeholder="Enter Description"
                                            name="description_ar">{{ old('description_ar') }}</textarea>
                                        @error('description_ar')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputFile">
                                            Image
                                        </label>
                                            <div class="help-block text-info">
                                                <b>Note:</b> dimensional: <span class="img-size">600*400</span>
                                                <br>
                                                <b>Note:</b> Image types: png | jpeg | jpg
                                            </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input {!! $errors->first('image', 'is-invalid') !!}"
                                                id="exampleInputFile" name="image" value="{{ old('image') }}">
                                            @error('image')
                                                <div class="help-block">{{ $message }}</div>
                                            @enderror
                                            <label class="custom-file-label" for="exampleInputFile">Choose image</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="wvideo">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="video-file">Video</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input {!! $errors->first('video', 'is-invalid') !!}"
                                                id="video-file" name="video" value="{{ old('video') }}">
                                            @error('video')
                                                <div class="help-block">{{ $message }}</div>
                                            @enderror
                                            <label class="custom-file-label" for="video-file">Choose video</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="links" style="display: none">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="facebook">Facebook</label>
                                        <input type="url" class="form-control " id="facebook"
                                            placeholder="Enter Profile Link" name="links[]" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="twitter">Twitter</label>
                                        <input type="url" class="form-control " id="twitter"
                                            placeholder="Enter Profile Link" name="links[]" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="instgram">Instgram</label>
                                        <input type="url" class="form-control " id="instgram"
                                            placeholder="Enter Profile Link" name="links[]" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="behance">Behance</label>
                                        <input type="url" class="form-control " id="behance"
                                            placeholder="Enter Profile Link" name="links[]" />
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
    $(document).ready(function() {
        $('#type').on('change', function() {
            const val = $(this).val();

            if (val === 'feat') {
                $('#icon-sec').css('display', 'block');
            } else {
                $('#icon-sec').css('display', 'none');
            }

            if (val === 'emp') {
                $('#links').css('display', 'block');
                $('.img-size').text('800*1142');
                // $('#desc').css('display', 'none');
            } else {
                $('#links').css('display', 'none');
                $('.img-size').text('600*400');
                // $('#desc').css('display', 'block');
            }

            if (val === 'first') {
                $('#wvideo').css('display', 'block');
            } else {
                $('#wvideo').css('display', 'none');
            }

            if (val === 'with-bg') {
                $('.img-size').text('1100*1000');
            } else {
                $('.img-size').text('600*400');
            }
        });
    });
</script>
@endpush
