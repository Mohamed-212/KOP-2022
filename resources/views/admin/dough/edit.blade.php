@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add New dough</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dough.index')}}">Back</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-name">Dough Type Details</h3>
                </div>
                <form action="{{ route('admin.dough.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name_en">name English</label>
                                    <input type="text"
                                        class="form-control"
                                        id="name_en" placeholder="Enter name" value="{{$doughType->name_en}}" name="name_en" >
                                    @error('name_en')
                                    <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name_ar">name Arabic</label>
                                    <input type="text"
                                           class="form-control "
                                           id="name_ar" placeholder="Enter name" value="{{$doughType->name_ar}}" name="name_ar" >
                                    @error('name_ar')
                                    <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name_ar">name Arabic</label>
                                    <input type="text"
                                           class="form-control "
                                           id="name_ar" placeholder="Enter name" value="{{old('name_ar')}}" name="name_ar" >
                                    @error('name_ar')
                                    <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div> --}}
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
