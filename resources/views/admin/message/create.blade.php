@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add New Notification</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.notification.index')}}">Back</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">message Details</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.notification.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Notification  subject</label>
                                    <input class="form-control {!! $errors->first('subject', 'is-invalid') !!}" placeholder="Enter Notification  subject" name="subject" value="{{ old('subject') ?? '' }}">
                                    {!! $errors->first('subject', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Notification  Description</label>
                                    <textarea class="form-control {!! $errors->first('description', 'is-invalid') !!}" placeholder="Enter Notification  Description" name="description">{{ old('description') ?? "" }}</textarea>
                                    {!! $errors->first('description_ar', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="push_notification" value="1" name="push_notification" >
                                    <label for="push_notification">Push Notification</label>
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

    $(".categories").change(function () {
      
        id=this.value;
        let url2 = "{{ route('categoryitems', ':id') }}";
             url2 = url2.replace(':id', id);
        $.ajax({
            type: "GET",
            url:url2,
           
            success: function(response){
                console.log(response.data);
                $('select[name="item_id"]').empty();
              for (let i=0;i<response.data.length ; i++){
              $('#items').append("<option value="+response.data[i].id+">"+response.data[i].name_en+"</option>");
             }}
        }); });
</script>
@endpush
