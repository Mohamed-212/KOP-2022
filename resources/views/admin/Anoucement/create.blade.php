@extends('layouts.admin.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add New Anoucement</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.Anoucement.index') }}">Back</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Anoucement Details</h3>
                    </div>
                    <form action="{{ route('admin.Anoucement.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name_en">name English</label>
                                        <input type="text" class="form-control" id="name_en" placeholder="Enter name"
                                            name="name_en" value="{{ old('name_en') }}">
                                        @error('name_en')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name_ar">name Arabic</label>
                                        <input type="text" class="form-control " id="name_ar" placeholder="Enter name"
                                            name="name_ar" value="{{ old('name_ar') }}">
                                        @error('name_ar')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
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
                                        <label for="exampleInputFile">Image</label>
                                        <div class="help-block text-info">
                                            <b>Note:</b> Image dimensions: 1100 * 1000
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
                // $('#desc').css('display', 'none');
            } else {
                $('#links').css('display', 'none');
                // $('#desc').css('display', 'block');
            }

            if (val === 'first') {
                $('#wvideo').css('display', 'block');
            } else {
                $('#wvideo').css('display', 'none');
            }
        });
    });
</script>
@endpush
