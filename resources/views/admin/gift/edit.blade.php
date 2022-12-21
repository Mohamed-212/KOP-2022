@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit Gift</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.gift.index')}}">Back</a></li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Gift Details</h3>
        </div>
        <form action="{{ route('admin.gift.update', $gift->id) }}" method="POST" id="edit-gift" enctype="multipart/form-data">
          @csrf
          @method('PATCH')
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputArabicName">Arabic Name</label>
                  <input type="text" class="form-control {!! $errors->first('name', 'is-invalid') !!}" id="exampleInputArabicName" placeholder="Enter Arabic Name" name="name" value="{{$gift->name}}">
                  {!! $errors->first('name', '<p class="invalid-feedback">:message</p>') !!}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEnglishName">English Name</label>
                  <input type="text" class="form-control {!! $errors->first('name_en', 'is-invalid') !!}" id="exampleInputEnglishName" placeholder="Enter English Name" name="name_en" value="{{$gift->name_en}}">
                  {!! $errors->first('name_en', '<p class="invalid-feedback">:message</p>') !!}
                </div>
              </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="exampleInputFirstPhone">Points</label>
                    <input value="{{ $gift->points }}" min="1" type="number" class="form-control {!! $errors->first('points', 'is-invalid') !!}" id="exampleInputFirstPhone" placeholder="Enter Points" name="points" value="{{ old('points') }} ">
                    </div>
                </div>
            </div>
            <div class="row">
                <img loading="lazy" data-lazy="true"  src="{{$gift->image}}">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="exampleInputFile">Image</label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="exampleInputFile" name="image">
                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
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
  $('.custom-file-input').on('change',function(){
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
  })

$('input').change(function (e) {
        // Warning
        $(window).on('beforeunload', function(){
            return "Are you sure you want to navigate away from this page?";
        });
        
        // Form Submit
        $(document).on("submit", "form", function(event){
            // disable unload warning
            $(window).off('beforeunload');
        });

    });



</script>
@endpush
