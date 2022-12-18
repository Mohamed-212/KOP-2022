@extends('layouts.profile')

@section('title')
    {{ __('general.address_title') }}
@endsection

@section('styles')
    <style>
        .form-group {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }
    </style>
@endsection

@section('pageName')

    <body class="page-article dm-light">
    @endsection

    @section('main')

        <div class="row">
            <div class="col-12 text-end mb-2" >
                <button data-bs-toggle="modal" data-bs-target="#add-address-modal " href="#" type="button"
                    class="btn btn- btn-floating default-btn rounded">
                    <i class="fas fa-plus"></i>
                    {{__('general.ADD')}}
                    <span></span>
                </button>
            </div>
        </div>
        <div class="row">
            @forelse ($addresses as $address)
                <div class="col-md-6">
                    <div class="bg-white card addresses-item mb-4 shadow">
                        <div class="gold-members p-4">
                            <div class="media">
                                <div class="branches-list">
                                    <h3 class="text-white mb-0 pb-0">
                                        {{ $address->name }}
                                    </h3>
                                    <ul>
                                        <li>
                                            {{ app()->getLocale() == 'ar' ? $address->city->name_ar : $address->name_en }}

                                            {{ app()->getLocale() == 'ar' ? $address->area->name_ar : $address->area->name_en }}
                                            , {{ $address->street }}
                                            ,{{ __('general.BuildNo') }}:
                                            {{ $address->building_number }}
                                            ,{{ __('general.FloorNo') }}:{{ $address->floor_number }}
                                            ,{{ __('general.Landmark') }}:{{ $address->landmark }}
                                        </li>
                                    </ul>
                                    <p class="mb-0 text-black font-weight-bold">
                                        <a style="padding: 0 0.75rem;" class="mr-3 bg-info default-btn btn btn-sm rounded"
                                            data-bs-toggle="modal" data-bs-target="#edit-address-modal{{ $address->id }}"
                                            href="#"><i class="icofont-ui-edit  "></i>
                                            {{ __('general.EDIT') }}
                                            <span></span>
                                        </a>
                                        <a style="padding: 0 0.75rem;" class="default-btn bg-danger btn btn-sm rounded"
                                            data-bs-toggle="modal"
                                            data-bs-target="#delete-address-modal{{ $address->id }}"
                                            href="{{ route('delete_address', $address->id) }}"><i
                                                class="icofont-ui-delete"></i>
                                            {{ __('general.DELETE') }}
                                            <span></span>
                                        </a>
                                    </p>
                                </div>

                                <div class="modal fade" id="edit-address-modal{{ $address->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="add-address" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-dark" id="add-address">
                                                    {{ __('general.Edit Delivery Address') }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('update_address', $address->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label for="inputPassword4"
                                                                class="text-dark">{{ __('general.Delivery Area') }}</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    placeholder="{{ __('general.Address Name') }}"
                                                                    name="name" value="{{ $address->name }}" required>
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
                                                                <select
                                                                    class="form-control select2-cities city w-100 select2-cities"
                                                                    name="city_id" required>
                                                                    <option value="{{ $address->city_id }}">
                                                                        {{ $address->city['name_' . app()->getLocale()] }}
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
                                                                    <option value="{{ $address->area->id }}">
                                                                        {{ app()->getLocale() == 'ar' ? $address->area->name_ar : $address->area->name_en }}
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
                                                                    name="street" value="{{ $address->street }}">
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
                                                                    name="building_number"
                                                                    value="{{ $address->building_number }}">
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
                                                                    name="floor_number"
                                                                    value="{{ $address->floor_number }}">
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
                                                                    name="landmark" value="{{ $address->landmark }}">
                                                                <div class="input-group-append">

                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="modal-footer d-flex">
                                                        <button type="button" class="btn text-center btn-outline-danger"
                                                            data-bs-dismiss="modal" style="width: 48%!important;">
                                                            {{ __('general.Cancel') }}
                                                        </button>
                                                        <button type="submit"
                                                            class="btn text-center btn-outline-success default-btn"
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


                                <div class="modal fade" id="delete-address-modal{{ $address->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="delete-address" aria-hidden="true">
                                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-dark" id="delete-address">
                                                    {{ __('general.DELETE') }}
                                                </h5>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="mb-0 text-black">
                                                    {{ __('general.Are you sure you want to delete this Address') }}?
                                                </p>
                                            </div>
                                            <div class="modal-footer" style="justify-content:center ">
                                                <button type="button" class="btn text-center btn-outline-danger"
                                                    data-bs-dismiss="modal">
                                                    {{ __('general.Cancel') }}
                                                </button>
                                                <form action="{{ route('delete_address', $address->id) }}"
                                                    method='post' >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn text-center btn-outline-success default-btn rounded">
                                                        {{ __('general.DELETE') }}
                                                        <span></span>
                                                    </button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 d-flex justify-content-center align-items-center shadow">
                    <div class="alert alert-primary">
                        <i class="fas fa-exclamation mx-1"></i>
                        {{__('general.add_address')}}
                    </div>
                </div>
            @endforelse
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-0">

                    <div class="bg-white card addresses-item mb-4 shadow">
                        <div class="gold-members">
                            <div class="media">


                                <div class="modal fade" id="add-address-modal" tabindex="-1" role="dialog"
                                    aria-labelledby="add-address" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-dark" id="add-address">
                                                    {{ __('general.Add Delivery Address') }}
                                                </h5>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('new.address') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label for="inputPassword4"
                                                                class="text-dark">{{ __('general.Delivery Area') }}</label>
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
                                                                <select
                                                                    class="form-control select2-cities city w-100 select2-cities"
                                                                    name="city_id" required>
                                                                    <option value="">
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
                                                                    name="street" value="">
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
                                                    <div class="modal-footer d-flex">
                                                        <button type="button" class="btn text-center btn-outline-danger"
                                                            data-bs-dismiss="modal" style="width: 48%!important;">
                                                            {{ __('general.Cancel') }}
                                                        </button>

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
        </div>
    @endsection

    @section('scripts')
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
                                if (city.name_en != 'Riyadh') {                                
                                return {
                                    id: city.id,
                                    text: city["name_" + "{{ app()->getLocale() }}"]
                                };
                                }
                            })
                        };
                    },
                    cache: true
                },
                dropdownParent: $('#add-address-modal')
            });


            $('.city').change(function() {
                let app_url = '{{ url('/') }}';
                let city_id = $(this).val();
                let selectele = $(this);
                $.ajax({
                    type: 'get',
                    url: app_url + "/api/cities/" + city_id + "/areas",
                    data: {},
                    success: function(data) {
                        if (data) {
                            selectele.parent().parent().next().first().find('.area').html('');
                            selectele.parent().parent().next().first().find('.area').append(
                                '<option selected value="">{{ __('general.Choose Area') }}</option>');
                                console.log(data);
                            $.each(data.data, function(index, area) {
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
