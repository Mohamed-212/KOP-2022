@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Offer</h1>
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
                <form action="{{ route('admin.offer.update' , $offer->id) }}" method="POST"
                    enctype="multipart/form-data" id="edit-offer">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputTitle">Title English</label>
                                    <input type="text" class="form-control" id="exampleInputTitle"
                                        placeholder="Enter Title" name="title" value="{{$offer->title}}">
                                    @error('title')
                                    <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputService">Service</label>
                                    <select class="form-control" id="exampleInputService" name="service_type">
                                        <option value="">Select Service</option>
                                        <option value="delivery" @if($offer->service_type == 'delivery') selected
                                            @endif>Delivery</option>
                                        <option value="takeaway" @if($offer->service_type == 'takeaway') selected
                                            @endif>Take awy</option>
                                    </select>
                                    @error('service_type')
                                    <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputTitle1">Title Arabic</label>
                                    <input type="text" class="form-control" id="exampleInputTitle1"
                                        placeholder="Enter Title" name="title_ar" value="{{$offer->title_ar}}">
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
                                    <input type="datetime-local" class="form-control" name="date_from"
                                        value="{{ $offer->date_from->format('Y-m-d\TH:i') }}">
                                    @error('date_from')
                                    <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date To</label>
                                    <input type="datetime-local" class="form-control" name="date_to"
                                        value="{{ $offer->date_to->format('Y-m-d\TH:i') }}">
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
                                        <select class="select2  {!! $errors->first('branches', 'is-invalid') !!}"
                                                multiple="multiple" data-placeholder="Select a branch"
                                                style="width: 100%;" name="branches[]">
                                            @foreach($branches as $branch)
                                                <option value="{{$branch->id}}"
                                                        @if($offer->branches->contains($branch->id)) selected @endif>{{$branch->name_en}}</option>
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
                                    <textarea class="form-control" name="description">{{$offer->description}}</textarea>
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
                                    <textarea class="form-control"
                                        name="description_ar">{{$offer->description_ar}}</textarea>
                                    @error('description_ar')
                                    <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">

                                    <label for="exampleInputFile">Mobile Image</label>
                                    @if($offer->image)
                                    <img loading="lazy" data-lazy="true"  src="{{ $offer->image }}" alt="..." class="img-thumbnail">
                                    @endif
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile" name="image"
                                            value="{{$offer->image}}">
                                        @error('image')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                    <div class="help-block text-info">
                                        <b>Note</b> Image Dimensions Must Be: 550 * 465
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputFile">Website Home Image</label>
                                    
                                    @if($offer->website_image)
                                    <img loading="lazy" data-lazy="true"  src="{{ asset($offer->website_image) }}" alt="..." class="img-thumbnail">
                                    @endif
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile" name="website_image"
                                            value="{{ asset($offer->website_image)}}">
                                        @error('website_image')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                    <div class="help-block text-info">
                                        <b>Note</b> Image Dimensions Must Be: 509 * 459
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
                                    @if($offer->website_image_menu)
                                    <img loading="lazy" data-lazy="true"  src="{{ asset($offer->website_image_menu) }}" alt="..." class="img-thumbnail">
                                    @endif
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile" name="website_image_menu"
                                            value="{{$offer->website_image_menu}}">
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
                                    <select class="form-control" id="exampleInputOfferType" name="offer_type" readonly>
                                    @if($offer->offer_type == 'buy-get')
                                        <option value="buy-get" selected>Buy / Get</option>
                                    @else
                                        <option value="discount"  selected >Discount</option>
                                        @endif
                                    </select>
                                    @error('offer_type')
                                    <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @if ($offer->offer_type == 'buy-get')
                        <div class="card card-primary" id="buy-get">
                            <div class="card-header">
                                <h3 class="card-title">Buy</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="buy_quantity">Quauntity</label>
                                            <input type="number" class="form-control" id="buy_quantity"
                                                placeholder="Enter Quauntity" name="buy_quantity"
                                                value="{{ $offer->buyGet->buy_quantity }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="buy_category_id">Category</label>
                                            <select class="form-control  category-select" id="exampleInputCategory3"
                                                name="buy_category_id" data-target="buy_items">
                                                @foreach($categories as $category)
                                                <option value="{{ $category->id }}" @if($offer->
                                                    buyGet->buyCategory_id==$category->id) selected @endif>
                                                    {{ $category['name_'.app()->getLocale()] }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Items</label>
                                            <select id="items3" class="select2" multiple="multiple" required
                                                data-placeholder="Select a Item" style="width: 100%;"
                                                name="buy_items[]">
                                                @foreach($offer->buyGet->buyCategory->items as $item)
                                                <option value="{{ $item->id }}" @if($offer->
                                                    buyGet->buyItems->contains($item)) selected @endif>
                                                    {{ $item['name_'.app()->getLocale()] }}
                                                </option>
                                                @endforeach
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
                                        <label for="get_quantity">Quauntity</label>
                                        <input type="number" class="form-control" id="get_quantity"
                                            placeholder="Enter Quauntity" name="get_quantity"
                                            value="{{ $offer->buyGet->get_quantity }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="get_category_id">Category</label>
                                        <select class="form-control category-select" id="exampleInputCategory2"
                                            name="get_category_id" data-target="get_items">
                                            <option value="" desabled></option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ ($offer->buyGet->getCategory->id == $category->id) ? "selected" : "" }}>
                                                {{ $category['name_'.app()->getLocale()] }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Items</label>
                                        <select id="items2" class="select2" multiple="multiple" required
                                            data-placeholder="Select a Item" style="width: 100%;" name="get_items[]">
                                            @foreach($offer->buyGet->getCategory->items as $item)
                                            <option value="{{ $item->id }}" @if($offer->
                                                buyGet->getItems->contains($item)) selected @endif>
                                                {{ $item['name_'.app()->getLocale()] }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleInputOfferPrice">Offer Price</label>
                                        <select class="form-control" id="exampleInputOfferPrice" name="offer_price" required>
                                            <option value="100" @if($offer->buyGet->offer_price == 0) selected @endif>
                                                Free
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif ($offer->offer_type == 'discount')
                        <div class="card card-primary" id="discount">
                            <div class="card-header">
                                <h3 class="card-title">Discount</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    {{-- <div class="col-md-6">
                                        <div class="form-group"> --}}
                                            {{-- <label for="exampleInputQuauntity">Quauntity</label> --}}
                                            <input type="hidden" hidden class="form-control" id="exampleInputQuauntity"
                                                placeholder="Enter Quauntity" name="discount_quantity"
                                                value="1">
                                        {{-- </div>
                                    </div> --}}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputCategory">Category</label>
                                            <select class="form-control category-select" id="exampleInputCategory1"
                                                name="category_id" data-target="items">
                                                @foreach($categories as $item)
                                                <option value="{{ $item->id }}" @if($offer->discount->category->id ==
                                                    $item->id) selected @endif>
                                                    {{ $item['name_'.app()->getLocale()] }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Items</label>
                                            <select id="items1" class="select2" multiple="multiple"
                                                data-placeholder="Select a Item" style="width: 100%;" name="items[]">
                                                @foreach($offer->discount->category->items as $item)
                                                <option value="{{ $item->id }}" @if($offer->
                                                    discount->items->contains($item)) selected @endif>
                                                    {{ $item['name_'.app()->getLocale()] }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputDiscountType">Discount Type</label>
                                            <select class="form-control" id="exampleInputDiscountType"
                                                name="discount_type">
                                                <option value="1" @if($offer->discount->discount_type == 1) selected
                                                    @endif>percentage</option>
                                                <option value="2" @if($offer->discount->discount_type == 2) selected
                                                    @endif>Amount</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputValue">Value</label>
                                            <input type="number" class="form-control" name="discount_value"
                                                value="{{ $offer->discount->discount_value }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
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
//    $("a").on('click', function(event) {
//         alert('hi');
//         e.preventDefault();
//         return false;
//    }
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
  function con() {
    alert('hi');
    var answer = confirm("do you want to check our other products")
    if (answer){

        alert("bye");
    }
    else{
        window.location = "http://www.example.com";
    }
}
</script>
@endpush