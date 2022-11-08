@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add New Offer</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.offer.index')}}">Back</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Offer Details</h3>
                </div>
                <form action="{{ route('admin.offer.store') }}" method="POST" enctype="multipart/form-data"
                    id="add-offer"
                      novalidate>
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputTitle">Title English</label>
                                    <input type="text"
                                        class="form-control {!! $errors->first('title', 'is-invalid') !!}"
                                        id="exampleInputTitle" placeholder="Enter Title" name="title" value="{{old('title')}}">
                                    @error('title')
                                    <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputService">Service</label>
                                    <select class="form-control {!! $errors->first('service_type', 'is-invalid') !!}"
                                        id="exampleInputService" name="service_type">
                                        <option value="">Select Service</option>
                                        <option value="all">All</option>
                                        <option value="delivery">Delivery</option>
                                        <option value="takeaway">Takeaway</option>
                                    </select>
                                    @error('service_type')
                                    <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputTitle1">Title Arabic</label>
                                    <input type="text"
                                        class="form-control {!! $errors->first('title_ar', 'is-invalid') !!}"
                                        id="exampleInputTitle1" placeholder="Enter Title" name="title_ar" value="{{old('title_ar')}}">
                                    @error('title_ar')
                                    <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date From</label>
                                    <input type="datetime-local"
                                        class="form-control {!! $errors->first('date_from', 'is-invalid') !!}"
                                        name="date_from" value="{{old('date_from')}}">
                                    @error('date_from')
                                    <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date To</label>
                                    <input type="datetime-local"
                                        class="form-control {!! $errors->first('date_to', 'is-invalid') !!}"
                                        name="date_to"
                                    value="{{old('date_to')}}">
                                    @error('date_to')
                                    <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>



                        </div>
                        <div class="row">

                        <div class="col-md-12">
                        <div class="form-group">
                          <label for="exampleInputBranch">Branches</label>
                          <select class="select2  {!! $errors->first('branches', 'is-invalid') !!}" multiple="multiple" data-placeholder="Select a branch" style="width: 100%;" name="branches[]">
                            @foreach($branches as $branch)
                            <option value="{{$branch->id}}">{{$branch->name_en}}</option>
                            @endforeach
                          </select>
                          {!! $errors->first('branches', '<p class="help-block">:message</p>') !!}

                        </div>
                      </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="offerDescription">Description English</label>
                                    <textarea class="form-control {!! $errors->first('description', 'is-invalid') !!}"
                                        name="description">{{old('description')}}</textarea>
                                    @error('description')
                                    <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="offerDescription1">Description Arabic</label>
                                    <textarea
                                        class="form-control {!! $errors->first('description_ar', 'is-invalid') !!}"
                                        name="description_ar">{{old('description_ar')}}</textarea>
                                    @error('description_ar')
                                    <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">

                                    <label for="exampleInputFile">Mobile Image </label>
                                    <div class="help-block text-info">
                                        <b>Note</b> Image Dimensions Must Be: 550 * 465
                                    </div>
                                    <div class="custom-file">
                                        <input type="file"
                                            class="custom-file-input {!! $errors->first('image', 'is-invalid') !!}"
                                            id="exampleInputFile" name="image" value="{{old('image')}}">
                                        @error('image')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputFile">Website Home Page Image</label>
                                    <div class="help-block text-info">
                                        <b>Note</b> Image Dimensions Must Be: 509 * 459
                                    </div>
                                    <div class="custom-file">
                                        <input type="file"
                                            class="custom-file-input {!! $errors->first('website_image', 'is-invalid') !!}"
                                            id="exampleInputFile" name="website_image" value="{{old('website_image')}}">
                                        @error('website_image')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputFile">Website Menu Image</label>
                                    <div class="help-block text-info">
                                        <b>Note</b> Image Dimensions Must Be: 300 * 300
                                    </div>
                                    <div class="custom-file">
                                        <input type="file"
                                            class="custom-file-input {!! $errors->first('website_image_menu', 'is-invalid') !!}"
                                            id="exampleInputFile" name="website_image_menu" value="{{old('website_image_menu')}}">
                                        @error('website_image_menu')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="exampleInputOfferType">Offer Type</label>
                                    <select class="form-control {!! $errors->first('offer_type', 'is-invalid') !!}"
                                        id="exampleInputOfferType" onchange="selectOfferType(this)" name="offer_type">
                                        <option value="">Select Offer Type</option>
                                        <option value="buy-get">Buy / Get</option>
                                        <option value="discount">Discount</option>
                                    </select>
                                    @error('offer_type')
                                    <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="card card-primary" id="buy-get" style="display: none">
                            <div class="card-header">
                                <h3 class="card-title">Buy</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputQuauntity">Quauntity</label>
                                            <input type="number"
                                                class="form-control {!! $errors->first('buy_quantity', 'is-invalid') !!}"
                                                id="exampleInputQuauntity" placeholder="Enter Quauntity"
                                                name="buy_quantity"
                                            value="{{old('buy_quantity')}}">
                                            @error('buy_quantity')
                                            <div class="help-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputCategory">Category</label>
                                            <select
                                                class="form-control category-select {!! $errors->first('buy_items', 'is-invalid') !!}"
                                                id="exampleInputCategory3" name="buy_category_id"
                                                data-target='buy_items'>
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $item)
                                                <option value="{{ $item->id }}">{{ $item['name_'.app()->getLocale()] }}</option>
                                                @endforeach

                                                @error('buy_category_id')
                                                <div class="help-block">{{ $message }}</div>
                                                @enderror
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Items</label>
                                            <select id="items3"
                                                class="select2 item-select {!! $errors->first('buy_items', 'is-invalid') !!}" required
                                                multiple="multiple" data-placeholder="Select a Item"
                                                style="width: 100%;" name="buy_items[]">
                                                @error('buy_items[]')
                                                <div class="help-block">{{ $message }}</div>
                                                @enderror

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header">
                                <h3 class="card-title">Get</h3>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputQuauntity">Quauntity</label>
                                        <input type="number"
                                            class="form-control {!! $errors->first('get_quantity', 'is-invalid') !!}"
                                            id="exampleInputQuauntity" placeholder="Enter Quauntity"
                                            name="get_quantity"
                                               value="{{old('get_quantity')}}">
                                        @error('get_quantity')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- todo --}}

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputCategory2">Category</label>
                                        <select
                                            class="form-control category-select {!! $errors->first('get_category_id', 'is-invalid') !!}"
                                            id="exampleInputCategory2" name="get_category_id" data-target='get_items'>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $item)
                                            <option value="{{ $item->id }}">{{ $item['name_'.app()->getLocale()] }}</option>
                                            @endforeach
                                        </select>
                                         @error('get_category_id')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Items</label>
                                        <select id="items2"
                                            class="select2 item-select {!! $errors->first('get_items', 'is-invalid') !!}" required
                                            multiple="multiple" data-placeholder="Select a Item" style="width: 100%;"
                                            name="get_items[]">
                                            @error('get_items[]')
                                            <div class="help-block">{{ $message }}</div>
                                            @enderror
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleInputOfferPrice">Offer Price</label>
                                        <select class="form-control {!! $errors->first('offer_price', 'is-invalid') !!}" required
                                            id="exampleInputOfferPrice" name="offer_price">
                                            <option value="0">Free</option>
                                        </select>
                                        @error('offer_price')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-primary" id="discount" style="display: none">
                            <div class="card-header">
                                <h3 class="card-title">Discount</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputQuauntity">Quauntity</label> --}}
                                            <input type="hidden" hidden
                                                class="form-control"
                                                id="exampleInputQuauntity" placeholder="Enter Quauntity"
                                                name="discount_quantity"
                                            value="1">
                                            {{-- @error('discount_quantity')
                                            <div class="help-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputCategory">Category</label>
                                            <select
                                                class="form-control category-select {!! $errors->first('category_id', 'is-invalid') !!}"
                                                id="exampleInputCategory1" name="category_id" data-target='items'>
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $item)
                                                <option value="{{ $item->id }}">{{ $item['name_'.app()->getLocale()] }}</option>
                                                @endforeach
                                            </select>
                                             @error('category_id')
                                            <div class="help-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Items</label>
                                            <select id="items1"
                                                class="select2 item_select {!! $errors->first('items', 'is-invalid') !!}"
                                                multiple="multiple" data-placeholder="Select a Item"
                                                style="width: 100%;" name="items[]">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputDiscountType">Discount Type</label>
                                            <select
                                                class="form-control {!! $errors->first('discount_type', 'is-invalid') !!}"
                                                id="exampleInputDiscountType" name="discount_type">
                                                <option>Select Discount Type</option>
                                                <option value="1">percentage</option>
                                                <option value="2">Amount</option>
                                            </select>
                                            @error('discount_type')
                                            <div class="help-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputValue">Value</label>
                                            <input type="number"
                                                class="form-control {!! $errors->first('discount_value', 'is-invalid') !!}"
                                                name="discount_value"
                                            value="{{old('discount_value')}}">
                                            @error('discount_value')
                                            <div class="help-block">{{ $message }}</div>
                                            @enderror
                                        </div>
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
    $("#exampleInputCategory1").click(function(e){
    e.preventDefault();
    var category_id = $("#exampleInputCategory1").val();
    if(category_id)
    {
      $.ajax({
        url : "{{url('/categories/ ')}}"+category_id,
        type : 'get',
        success : function(data){
          if(data.status == 1)
          {
            $("#items1").empty();
            $("#items1").append('<option value="">Choose Item</option>');
            $.each(data.data, function(index, item){
              $("#items1").append('<option value="'+item.id+'">'+item['name_'+'{{app()->getLocale()}}']+'</option>');
            });
          }
        },
        error: function (jqXhr, textStatus, errorMessage){
          alert(errorMessage);
        }
      });
    }
    else
    {
      $("#items1").empty();
      $("#items1").append('<option value="">Choose Item</option>');
    }
  });
</script>

<script>
    $("#exampleInputCategory2").click(function(e){
    e.preventDefault();
    var category_id = $("#exampleInputCategory2").val();
    if(category_id)
    {
      $.ajax({
        url : "{{url('/categories/ ')}}"+category_id,
        type : 'get',
        success : function(data){
          if(data.status == 1)
          {
            $("#items2").empty();
            $("#items2").append('<option value="">Choose Item</option>');
            $.each(data.data, function(index, item){
              $("#items2").append('<option value="'+item.id+'">'+item['name_'+'{{app()->getLocale()}}']+'</option>');
            });
          }
        },
        error: function (jqXhr, textStatus, errorMessage){
          alert(errorMessage);
        }
      });
    }
    else
    {
      $("#items2").empty();
      $("#items2").append('<option value="">Choose Item</option>');
    }
  });
</script>

<script>
    $("#exampleInputCategory3").click(function(e){
    e.preventDefault();
    var category_id = $("#exampleInputCategory3").val();
    if(category_id)
    {
      $.ajax({
        url : "{{url('/categories/ ')}}"+category_id,
        type : 'get',
        success : function(data){
          if(data.status == 1)
          {
            $("#items3").empty();
            $("#items3").append('<option value="">Choose Item</option>');
            $.each(data.data, function(index, item){
              $("#items3").append('<option value="'+item.id+'">'+item['name_'+'{{app()->getLocale()}}']+'</option>');
            });
          }
        },
        error: function (jqXhr, textStatus, errorMessage){
          alert(errorMessage);
        }
      });
    }
    else
    {
      $("#items3").empty();
      $("#items3").append('<option value="">Choose Item</option>');
    }
  });
</script>

<script>
    function selectOfferType(select) {
        if (select.value=='buy-get') {
            document.getElementById('buy-get').style.display = "block";
            document.getElementById('discount').style.display = "none";
        } else if (select.value=='discount') {
            document.getElementById('buy-get').style.display = "none";
            document.getElementById('discount').style.display = "block";
        } else {
            document.getElementById('buy-get').style.display = "none";
            document.getElementById('discount').style.display = "none";
        }
    }
    $('.custom-file-input').on('change',function(){
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
    })
</script>
@endpush