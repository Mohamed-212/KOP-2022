@extends('layouts.admin.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add New Customer</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.customer.index')}}">Back</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Personal information</h3>
                    </div>
                    <form action="{{ route('admin.customer.store') }}" method="POST" enctype="multipart/form-data"
                          id="add-customer">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputFirstName">First Name</label>
                                        <input type="text" class="form-control" id="exampleInputFirstName"
                                               placeholder="Enter First Name" required value="{{old('first_name')}}"
                                               name="first_name">
                                        @error('first_name')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputMiddleName">Middle Name</label>
                                        <input type="text" class="form-control" id="exampleInputMiddleName"
                                               placeholder="Enter Middle Name" value="{{old('middle_name')}}"
                                               name="middle_name">
                                        @error('middle_name')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputLastName">Last Name</label>
                                        <input type="text" class="form-control" id="exampleInputLastName"
                                               placeholder="Enter Last Name" required value="{{old('last_name')}}"
                                               name="last_name">
                                        @error('last_name')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail">Email</label>
                                        <input type="email" class="form-control" id="exampleInputEmail"
                                               placeholder="Enter email" required value="{{old('email')}}" name="email">
                                        @error('email')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password"
                                               placeholder="Enter Password" required name="password">
                                        @error('password')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputConfirmPassword">Confirm Password</label>
                                        <input type="password" class="form-control" id="exampleInputConfirmPassword"
                                               placeholder="Enter Confirm Password" name="password_confirmation">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputFirstPhone">Primary Phone</label>
                                        <input type="text" class="form-control" id="exampleInputFirstPhone"
                                               placeholder="Enter First Phone" required value="{{old('first_phone')}}"
                                               name="first_phone">
                                        @error('first_phone')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputSecondPhone">Secondary Phone</label>
                                        <input type="text" class="form-control" id="exampleInputSecondPhone"
                                               placeholder="Enter Second Phone" name="second_phone">
                                        @error('second_phone')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Image</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile"
                                                   name="image">
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
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Address Details</h3>
                                        </div>
                                        <div class="card-body">
                                            <div id="accordion">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h4 class="card-title">
                                                            <a data-toggle="collapse" data-parent="#accordion"
                                                               href="#collapseOne" class="collapsed"
                                                               aria-expanded="false">
                                                                Add Address Details
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseOne" class="panel-collapse in collapse" style="">
                                                        <div id="newAddress"></div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <a style="float: right;" href="javascript:void(0);"
                                                                   class="btn btn-primary block" id="add_new_address"><i
                                                                        class="fas fa-plus mr-2"></i>Add Address</a>
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
        var i = 1;
        $(document).ready(function () {
            $('#add-customer').validate({
                rules: {
                    // first_name: "required",
                    // last_name: "required",
                    // email: {
                    //   required: true,
                    //   email: true
                    // },
                    // password : {
                    //   required: true,
                    //   minlength : 4
                    // },
                    password_confirmation: {
                        required: true,
                        // minlength : 4,
                        equalTo: "#password"
                    }
                }
            });
            var rmoveID = 0;
            $("#add_new_address").click(function (event) {
                var append = '<div class="container" id="block_' + rmoveID + '">';
                append += '<h3 class="card-title">Address #' + i + '</h3>';
                append += '<div class="card-body">';
                append += '<div class="row container-fluid">';
                append += '<div class="col-md-6">';
                append += '<div class="form-group">';
                append += '<label>City' + i + '</label>';
                append += '<select data-id="' + i + '" id="city' + i + '" onclick="selectCity(' + i + ')" class="form-control select2-cities" name="Address[' + rmoveID + '][city_id]" required>';
                append += '<option value="">Select City</option>';

                append += '</select>';
                append += '</div>';
                append += '</div>';
                append += '<div class="col-md-6">';
                append += '<div class="form-group">';
                append += '<label>Area' + i + '</label>';
                append += '<select id="area' + i + '" class="form-control select2-areas" name="Address[' + rmoveID + '][area_id]" required>';
                append += '</select>';
                append += '</div>';
                append += '</div>';
                append += '</div>';
                append += '<div class="row">';
                append += '<div class="col-md-6">';
                append += '<div class="form-group">';
                append += '<label>Street' + i + '</label>';
                append += '<input type="text" class="form-control" placeholder="Enter Street" name="Address[' + rmoveID + '][street]">';
                append += '</div>';
                append += '</div>';
                append += '<div class="col-md-6">';
                append += '<div class="form-group">';
                append += '<label>Building Number' + i + '</label>';
                append += '<input type="text" class="form-control" placeholder="Enter Building Number" name="Address[' + rmoveID + '][building_number]">';
                append += '</div>';
                append += '</div>';
                append += '</div>';

                append += '<div class="row">';
                append += '<div class="col-md-6">';
                append += '<div class="form-group">';
                append += '<label>Floor Number' + i + '</label>';
                append += '<input type="text" class="form-control" placeholder="Enter Floor Number" name="Address[' + rmoveID + '][floor_number]">';
                append += '</div>';
                append += '</div>';
                append += '<div class="col-md-6">';
                append += '<div class="form-group">';
                append += '<label>Special Marque' + i + '</label>';
                append += '<input type="text" class="form-control" placeholder="Enter Special Marque" name="Address[' + rmoveID + '][special_marque]">';
                append += '</div>';
                append += '</div>';
                append += '</div>';

                append += '<div class="row" id="removeBtn_' + rmoveID + '">';
                append += '<div class="col-md-6">';
                append += '<a style="float: right;" href="javascript:void(0);" class="btn btn-danger block" onclick="removeBlock(' + rmoveID + ')"><i class="fas fa-trash-alt mr-2"></i>Delete Address</a>';
                append += '</div>';
                append += '</div>';
                append += '<hr style="border-top: 1px solid #343a40;">';

                rmoveID++;

                $("#newAddress").last().append(append);
                $(".select2-areas").select2();
                let app_url = '{{ url('/') }}';

                $('.select2-cities').select2(
                    {
                        ajax: {
                            url: app_url + "/api/cities/",
                            dataType: 'json',
                            processResults: function (data) {
                                return {
                                    results: $.map(data['data'], function (city) {
                                        return {
                                            id: city.id,
                                            text: city["name_" + "{{app()->getLocale()}}"]
                                        }
                                    })
                                };
                            },

                            cache: true
                        }
                    }
                );

                $(document).on('change', '#city' + i + '', function (e) {
                    var city_id = $(this).val();
                    let app_url = '{{ url('/') }}';
                    var endpoint = app_url + "/api/cities/" + city_id + "/areas";

                    var section = $('#area' + $(this).attr('data-id'));
                  
                    $.get(endpoint, function (res) {
                        var element = '';
                        var size = res.length;
                     
                        for (var k = 0; k < res.length; k++) {
                            var name = res[k]['name_'+'{{app()->getLocale()}}'];
                            var index = k + 1;
                            var id = res[k].id;

                            element += `<option value="${id}">${name}</option>`;
                        }

                        section.html(element);

                    });

                })
                i++;

            });


        });

        function removeBlock(id) {
            $("#block_" + id).remove();
            i--;
        }

        function removeBtn(id) {
            id = id - 2;
            $("#removeBtn_" + id).remove();
        }




        $('.custom-file-input').on('change', function () {
            //get the file name
            var fileName = $(this).val();
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        })


        $('input').change(function (e) {
            // Warning
            $(window).on('beforeunload', function () {
                return "Are you sure you want to navigate away from this page?";
            });

            // Form Submit
            $(document).on("submit", "form", function (event) {
                // disable unload warning
                $(window).off('beforeunload');
            });

        });


    </script>
@endpush
