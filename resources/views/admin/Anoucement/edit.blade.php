@extends('layouts.admin.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Annoucement</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.Anoucement.index')}}">Back</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Annoucement Details</h3>
                    </div>
                    <form action="{{ route('admin.Anoucement.update' , $Anoucement->id) }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name_en">Name English</label>
                                        <input type="text"
                                               class="form-control"
                                               id="name_en" placeholder="Enter name" value="{{$Anoucement->name_en}}"
                                               name="name_en">
                                        @error('name_en')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name_ar">Name Arabic</label>
                                        <input type="text"
                                               class="form-control "
                                               id="name_ar" placeholder="Enter name" value="{{$Anoucement->name_ar}}"
                                               name="name_ar">
                                        @error('name_ar')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description_en">Description English</label>
                                        <textarea rows="5" class="form-control p-1" id="description_en"
                                                  placeholder="Enter Description" name="description_en"
                                        >{{$Anoucement->description_en}}</textarea>
                                        @error('description_en')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description_ar">Description Arabic</label>
                                        <textarea rows="5" class="form-control p-1" id="description_ar"
                                                  placeholder="Enter Description"
                                                  name="description_ar">{{$Anoucement->description_ar}}</textarea>
                                        @error('description_ar')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <img loading="lazy" data-lazy="true"  src="{{asset($Anoucement->image) }}" class="img-thumbnail w-100" style="height: 250px" />
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image</label>
                                        <div class="help-block text-info">
                                            <b>Note:</b> Image dimensions: 1100 * 1000
                                            <br>
                                            <b>Note:</b> Image types: png | jpeg | jpg
                                        </div>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input {!! $errors->first('image', 'is-invalid') !!}" name="image" value="{{ old('image') }}">
                                                <label class="custom-file-label">Choose file</label>
                                            </div>
                                        </div>
                                        {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
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
</script>
@endpush
