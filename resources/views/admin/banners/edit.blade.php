@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Banner</h1>
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
                    <h3 class="card-title">Banner Details</h3>
                </div>
                <form action="{{ route('admin.banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img loading="lazy" data-lazy="true"  src="{{asset($banner->image) }}" class="img-thumbnail w-100" style="height: 250px" />
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Image</label>
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
