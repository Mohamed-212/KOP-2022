@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Home Item</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.homeitem.index')}}">Back</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Home Item Details</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.homeitem.update',$homeitem->id) }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Choose Category</label>
                                    <select class="form-control categories select2" id="categories" name="category_id">
                                        <option value="" disabled>Select Category</option>
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}" @if($item->id==$homeitem->category_id)  selected @endif>
                                                {{ $item['name_'.app()->getLocale()] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                    <label>Choose Item</label>
                                    <select class="form-control select2" id="items" name="item_id">
                                    <option value="" disabled>Select Items</option>
                                    @if($homeitem->item_id)
                                        <option value="{{ $homeitem->item_id }}" selected>
                                                {{ $homeitem->item['name_'.app()->getLocale()] }}
                                            </option>
                                    @endif        
                                    </select>
                                    {!! $errors->first('item_id', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Home Item Arabic Description</label>
                                    <textarea class="form-control {!! $errors->first('description_ar', 'is-invalid') !!}" placeholder="Enter Item Arabic Description" name="description_ar">{{ old('description_ar') ?? "" }}</textarea>
                                    {!! $errors->first('description_ar', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Home Item English Description</label>
                                    <textarea class="form-control {!! $errors->first('description_en', 'is-invalid') !!}" placeholder="Enter Item English Description" name="description_en">{{ old('description_en') }}</textarea>
                                    {!! $errors->first('description_en', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Home Item Number</label>
                                    <input type="number" step="any" class="form-control {!! $errors->first('number', 'is-invalid') !!}" placeholder="Enter homeitem number" name="number" min='1' max='4' value="{{ old('number') }}">
                                    {!! $errors->first('number', '<p class="help-block">:message</p>') !!}
                                </div>
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
                                @if($homeitem->number==1)
                                    <div class="help-block text-info">
                                            <b>Note</b> Image dimensions: 550 * 450
                                        </div>
                                    @elseif($homeitem->number==2)
                                    <div class="help-block text-info">
                                            <b>Note</b> Image dimensions: 550 * 465
                                        </div>
                                    @elseif($homeitem->number==3)
                                    <div class="help-block text-info">
                                            <b>Note</b> Image dimensions: 550 * 465
                                        </div>
                                    @elseif($homeitem->number==4)
                                    <div class="help-block text-info">
                                            <b>Note</b> Image dimensions: 550 * 220
                                        </div>
                                    @endif
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
