@extends('layouts.profile')

@section('title')
    {{ __('general.address_title') }}
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/jquery-gmaps-latlon-picker.css')}}"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/v4.0.0/build/css/bootstrap-datetimepicker.css"/>
<style type="text/css">
        #map {
          height: 400px;
        }
    </style>
    <style>
        .form-group {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }
        /* .d-block {
            display: block !important;
        } */
    </style>
@endsection

@section('pageName')

    <body class="page-article dm-light">
    @endsection

    @section('main')
    <fieldset class="gllpLatlonPicker" style="width:100%;padding-bottom:2%">
		<div class="row" style="width:100%;padding-bottom:2%">
      
            <div class="col-md-2">
            <button class="default-btn  gllpSearchButton" >  {{ __('general.search') }} <span></span> </button>
            </div>
            <div class="col-md-9">
                <input type="text" class="gllpSearchField" style="color:black; width:100%;height:45px;width: 115%;" placeholder="{{__('general.search address')}}">
        </div>
        <span class="d-none text-danger mb-2 font-weight-bold not_found" >{{__('general.branch_no_cover')}}</span>
        <span class="d-none text-danger mb-2 font-weight-bold riyadh" >{{__('general.no delivery riyadh')}}</span>
			<!-- <input type="button" class=" default-btn" value=" بحث عن عنوان" style="padding: 2px 15px; vertical-align: none;float:right;background:rgb(3, 169, 245); margin-right:1%"> -->
            
        </div>
		<div class="gllpMap">Google Maps</div>
		<input type="hidden" class="gllpLatitude" value="23.8859" name="lat"/>
		<input type="hidden" class="map-address" name="address[]"/>
		<input type="hidden" class="gllpLongitude" value="45.0792" name="lon"/>
		<input type="hidden" class="gllpZoom" name="gllpZoom" value="5"/>
		<input class="gllpUpdateButton" value="update map" type="button"
			   style="display:none">
	</fieldset>
   
       
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-0">

                    <div class="bg-white card addresses-item mb-4 shadow">
                        <div class="gold-members">
                            <div class="media">


                              
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-dark" id="add-address">
                                                    {{ __('general.Add Delivery Address') }}
                                                </h5>
                                                
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('new.address') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label for="inputPassword4"
                                                                class="text-dark">{{ __('general.Address Name') }}</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    placeholder="{{ __('general.Address Name') }}"
                                                                    name="name" value="" required>
                                                                <div class="input-group-append">
                                                                </div>
                                                            </div>
                                                            @if (isset($errorarray))
                                                                @if (array_key_exists('name', $errorarray))
                                                                    <span
                                                                        class="d-block text-danger mb-2 font-weight-bold">{{ $errorarray['name'] }}</span>
                                                                @endif
                                                            @endif
                                                        </div>
                                                        <div class="form-group col-md-12 wrapCity">
                                                            <label for="inputPassword4" class="text-dark">
                                                                {{ __('general.City') }}
                                                            </label>
                                                            <div class="input-group">
                                                                <select id="city-select" disabled
                                                                    class="form-control select2-cities city w-100 select2-cities"
                                                                    name="city_id" required>
                                                                    <option value="" selected>
                                                                        {{ __('general.Select City') }}
                                                                    </option>


                                                                </select>
                                                                <div class="input-group-append">

                                                                </div>

                                                            </div>
                                                            @if (isset($errorarray))
                                                                @if (array_key_exists('city_id', $errorarray))
                                                                    <span
                                                                        class="d-block text-danger mb-2 font-weight-bold">{{ $errorarray['city_id'] }}</span>
                                                                @endif
                                                            @endif
                                                        </div>
                                                        <div class="form-group col-md-12 wrapArea">
                                                            <label for="inputPassword4" class="text-dark">
                                                                {{ __('general.Area') }}
                                                            </label>
                                                            <div class="input-group">
                                                                <select class="form-control area w-100" name="area_id"
                                                                    required>
                                                                    <option value="">

                                                                    </option>

                                                                </select>
                                                                <div class="input-group-append">
                                                                    <button class="btn " type="button">
                                                                    </button>
                                                                    @if (isset($errorarray))
                                                                        @if (array_key_exists('area_id', $errorarray))
                                                                            <span
                                                                                class="d-block text-danger mb-2 font-weight-bold">{{ $errorarray['area_id'] }}</span>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label for="inputPassword5"
                                                                class="text-dark">{{ __('general.Street') }}
                                                            </label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    placeholder="{{ __('general.Delivery Area') }}"
                                                                    name="street" id="street" value="">
                                                                <div class="input-group-append">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label for="inputPassword5" class="text-dark">
                                                                {{ __('general.BuildNo') }}
                                                            </label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    placeholder="{{ __('general.BuildNo') }} "
                                                                    name="building_number" value="">
                                                                <div class="input-group-append">

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label for="inputPassword5" class="text-dark">
                                                                {{ __('general.FloorNo') }}
                                                            </label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    placeholder="{{ __('general.FloorNo') }}"
                                                                    name="floor_number" value="">
                                                                <div class="input-group-append">

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label for="inputPassword6" class="text-dark">
                                                                {{ __('general.Landmark') }}
                                                            </label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    placeholder="{{ __('general.Landmark') }}"
                                                                    name="landmark" value="">
                                                                <div class="input-group-append">

                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="modal-footer d-flex" style="flex-flow: column-reverse;">
                                 
                                                        <button type="submit"
                                                            class="btn text-center btn-outline-success default-btn rounded"
                                                            style="width: 48%!important;">
                                                            {{ __('general.SUBMIT') }}
                                                            <span></span>
                                                        </button>
                                                    </div>
                                                </form>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
    <script>
        var message=[];
        var selectedId=2;
        message.push("{{ __('general.Choose Area') }}");
        message.push("{{__('general.branch_no_cover')}}");
        message.push("{{ __('general.Select City') }}");
        var cities = [];
        var cityObj = [];
        @foreach($cities as $city)
            cityObj = [];
            cityObj.push('{{$city["id"]}}');
            cityObj.push('{{$city["name_en"]}}');
            cities.push(cityObj);
        @endforeach

    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGRuzTOs7B8UgziioeYl_-oykZDRaj2K4"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
	<script src="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/v4.0.0/src/js/bootstrap-datetimepicker.js"></script>
	<script src="{{asset('js/jquery-gmaps-latlon-picker.js')}}"></script>
	<script>
        $(document).ready(function() {
            // Copy the init code from "jquery-gmaps-latlon-picker.js" and extend it here
            $(".gllpLatlonPicker").each(function() {
                $obj = $(document).gMapsLatLonPicker();

                $obj.params.strings.markerText = "Drag this Marker (example edit)";

                $obj.params.displayError = function(message) {
                    console.log("MAPS ERROR: " + message); // instead of alert()
                };

                $obj.init( $(this) );
            });
        });
        $('input.gllpSearchField').keypress(function(e) {
            if(e.which == 13) {
                $('.gllpSearchButton').click();
                console.log("pressed");
                return false;
            }
        });
        </script>

        <script src="{{ asset('website2-assets_old/vendor/select2/js/select2.min.js') }}" type="text/javascript"></script>

        <script>
            let app_url = '{{ url('/') }}';

            $('.select2-cities').select2({
                ajax: {
                    url: app_url + "/api/v1/cities/search/",
                    dataType: 'json',
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(city) {
                                return {
                                    id: city.id,
                                    text: city["name_" + "{{ app()->getLocale() }}"]
                                }
                            })
                        };
                    },
                    cache: true
                },
            });


            $('.city').change(function() {
                let app_url = '{{ url('/') }}';
                let city_id = $(this).val();
                let selectele = $(this);
                console.log(selectele);
                $.ajax({
                    type: 'get',
                    url: app_url + "/api/cities/" + city_id + "/areas",
                    data: {},
                    success: function(data) {
                        if (data) {
                            selectele.parent().parent().next().first().find('.area').html('');
                            selectele.parent().parent().next().first().find('.area').append(
                                '<option selected value="">{{ __('general.Choose Area') }}</option>');
                            $.each(data, function(index, area) {
                                selectele.parent().parent().next().first().find('.area').append(
                                    '<option value="' + area.id + '">' + area.name_ar +
                                    '</option>');
                            });
                        }
                    },
                    error: function(jqXhr, textStatus, errorMessage) {

                    }
                })

            });
        </script>
    @endsection
