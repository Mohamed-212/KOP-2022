@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Offer - {{ $offer->title }}</h1>
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
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputTitle">Title English</label>
                    <input type="text" class="form-control" value="{{ $offer->title }} " disabled>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputTitle1">Title Arabic</label>
                    <input type="text" class="form-control" value="{{ $offer->title_ar }} " disabled>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputService">Service</label>
                  <input type="text" class="form-control" value="{{ $offer->service_type }}" disabled>
                </div>
              </div>
              
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Date From</label>
                  <?php $from = $offer->date_from->format('Y-m-d\TH:i'); ?>
                  <?php $to = $offer->date_to->format('Y-m-d\TH:i'); ?>
                  <input type="datetime-local" class="form-control" value="{{ $from }}" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Date To</label>
                  <input type="datetime-local" class="form-control" value="{{ $to }}" disabled>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Branches</label>
                  <select class="select2" multiple="multiple" data-placeholder="Select a State" style="width: 100%;" name="branches[]" disabled>
                    @foreach($branches as $branch)
                        <option value="{{$branch->id}}"
                                @if($offer->branches->contains($branch->id)) selected @endif>{{$branch->name_en}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="offerDescription">Description English</label>
                  <textarea disabled class="form-control">{{$offer->description}}</textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="offerDescription1">Description Arabic</label>
                  <textarea disabled class="form-control">{{$offer->description_ar}}</textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <label>Mobile Image</label>
                <br>
                @if($offer->image)
                <img loading="lazy" data-lazy="true"  src="{{ $offer->image }}" class="img-thumbnail w-100" style="height: 250px">
                @endif
              </div>
              <div class="col-md-4">
                <label>Website Home Image</label>
                <br>
                @if($offer->website_image)
                <img loading="lazy" data-lazy="true"  src="{{ $offer->website_image }}" class="img-thumbnail w-100" style="height: 250px">
                @endif
              </div>
              <div class="col-md-4">
                <label>Website Menu Image</label>
                <br>
                @if($offer->website_image_menu)
                <img loading="lazy" data-lazy="true"  src="{{ $offer->website_image_menu }}" class="img-thumbnail w-100" style="height: 250px">
                @endif
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputOfferType">Offer Type</label>
                  <input type="text" class="form-control" value="{{ $offer->offer_type }} " disabled>
                </div>
              </div>
            </div>
            @if($offer->offer_type == 'buy-get')
            <div class="card card-primary" id="buy-get">
              <div class="card-header">
                <h3 class="card-title">Buy</h3>
              </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputQuauntity">Quauntity</label>
                        <input type="text" class="form-control" value="{{ $offer->buyGet->buy_quantity }} " disabled>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputCategory">Category</label>
                        <input type="text" class="form-control" value="{{ $offer->buyGet->buyCategory['name_'.app()->getLocale()] }} " disabled>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Items</label>
                            <select disabled class="select2" multiple="multiple" data-placeholder="Select a Item" style="width: 100%;" name="buy_items[]">
                                @foreach($offer->buyGet->buyCategory->items as $item)
                                <option value="{{ $item->id }}" @if($offer->buyGet->buyItems->contains($item)) selected @endif>
                                    {{ $item['name_'.app()->getLocale()] }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                </div>
                </div>
                <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Get</h3>
                </div>
                <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputQuauntity">Quauntity</label>
                        <input type="text" class="form-control" value="{{ $offer->buyGet->get_quantity }} " disabled>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputCategory2">Category</label>
                        <input type="text" class="form-control" value="{{ $offer->buyGet->getCategory['name_'.app()->getLocale()] }} " disabled>
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Items</label>
                            <select disabled class="select2" multiple="multiple" data-placeholder="Select a Item" style="width: 100%;" name="get_items[]">
                                @foreach($offer->buyGet->getCategory->items as $item)
                                    <option value="{{ $item->id }}" @if($offer->buyGet->getItems->contains($item)) selected @endif>
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
                            <select disabled class="form-control" id="exampleInputOfferPrice" name="offer_price">
                                <option value="">Select Offer Price</option>
                                <option value="0" @if($offer->buyGet->offer_price == 0) selected @endif>
                                    Free
                                </option>
                                <option value="20" @if($offer->buyGet->offer_price == 20) selected @endif>
                                    20%
                                </option>
                                <option value="30" @if($offer->buyGet->offer_price == 30) selected @endif>
                                    30%
                                </option>
                                <option value="40" @if($offer->buyGet->offer_price == 40) selected @endif>
                                    40%
                                </option>
                                <option value="50" @if($offer->buyGet->offer_price == 50) selected @endif>
                                    50%
                                </option>
                                <option value="60" @if($offer->buyGet->offer_price == 60) selected @endif>
                                    60%
                                </option>
                                <option value="70" @if($offer->buyGet->offer_price == 70) selected @endif>
                                    70%
                                </option>
                                <option value="80" @if($offer->buyGet->offer_price == 80) selected @endif>
                                    80%
                                </option>
                                <option value="90" @if($offer->buyGet->offer_price == 90) selected @endif>
                                    90%
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            @endif
            @if($offer->offer_type == 'discount')
            <div class="card card-primary" id="discount">
              <div class="card-header">
                <h3 class="card-title">Discount</h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputQuauntity">Quauntity</label>
                      <input type="text" class="form-control" value="{{ $offer->discount->quantity }} " disabled>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputCategory">Category</label>
                      <input type="text" class="form-control" value="{{ $offer->details->category['name_'.app()->getLocale()] }} " disabled>
                    </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Items</label>
                            <select disabled class="select2" multiple="multiple" data-placeholder="Select a Item" style="width: 100%;" name="items[]">
                                @foreach($offer->discount->category->items as $item)
                                <option value="{{ $item->id }}" @if($offer->discount->items->contains($item)) selected @endif>
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
                      @if($offer->details->discount_type == 1)
                          <input type="text" class="form-control" value="Percentage" disabled>
                      @elseif($offer->details->discount_type == 2))
                          <input type="text" class="form-control" value="Ammount" disabled>
                      @endif
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputValue">Value</label>
                      <input type="text" class="form-control" value="{{ $offer->details->discount_value }} " disabled>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif
          </div>

        </form>
      </div>
    </div>
  </section>
</div>
@endsection
