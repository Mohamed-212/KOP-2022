@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add New Branch</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.branch.index')}}">Back</a></li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Branch Details</h3>
        </div>
        <form action="{{ route('admin.branch.store') }}" method="POST" id="add-branch">
          @csrf
          <div class="card-body">

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputArabicName">Arabic Name</label>
                  <input type="text" class="form-control {!! $errors->first('name_ar', 'is-invalid') !!}" id="exampleInputArabicName" placeholder="Enter Arabic Name" name="name_ar" value="{{old('name_ar')}}">
                    @error('name_ar')
                    <div class="help-block">{{ $message }}</div>
                    @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEnglishName">English Name</label>
                  <input type="text" value="{{old('name_en')}}" class="form-control  {!! $errors->first('name_en', 'is-invalid') !!}" id="exampleInputEnglishName" placeholder="Enter English Name" name="name_en">
                    @error('name_en')
                    <div class="help-block">{{ $message }}</div>
                    @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputCity">City</label>
                  <select class="form-control select2-cities {!! $errors->first('branch_city_id', 'is-invalid') !!} branch-city-select" id="exampleInputCity" name="branch_city_id" data-target="area_id">
                      <option
                          value="">
                          {{__('general.Select City')}}
                      </option>
                  </select>
                    @error('branch_city_id')
                    <div class="help-block">{{ $message }}</div>
                    @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputArea">Area</label>
                  <select class="form-control select2 {!! $errors->first('area_id', 'is-invalid') !!}" id="exampleInputArea" name="area_id">
                    <option value="">Select Area</option>
                  </select>
                    @error('area_id')
                    <div class="help-block">{{ $message }}</div>
                    @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="exampleInputAddressDescription"> Address Description</label>
                  <textarea class="form-control {!! $errors->first('address_description', 'is-invalid') !!}" id="exampleInputAddressDescription" name="address_description">{{old('address_description')}}</textarea>
                    @error('address_description')
                    <div class="help-block">{{ $message }}</div>
                    @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="exampleInputAddressDescriptionEN"> Address Description English</label>
                  <textarea class="form-control {!! $errors->first('address_description_en', 'is-invalid') !!}" id="exampleInputAddressDescriptionEN" name="address_description_en">{{old('address_description_en')}}</textarea>
                    @error('address_description_en')
                    <div class="help-block">{{ $message }}</div>
                    @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputFirstPhone">First Phone</label>
                  <input type="text" value="{{old('first_phone')}}" class="form-control {!! $errors->first('first_phone', 'is-invalid') !!}" id="exampleInputFirstPhone" placeholder="Enter First Phone" name="first_phone">
                    @error('first_phone')
                    <div class="help-block">{{ $message }}</div>
                    @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputSecondPhone">Second Phone</label>
                  <input type="text" value="{{old('second_phone')}}" class="form-control {!! $errors->first('second_phone', 'is-invalid') !!}" id="exampleInputSecondPhone" placeholder="Enter Second Phone" name="second_phone">
                    @error('second_phone')
                    <div class="help-block">{{ $message }}</div>
                    @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="exampleInputEmail">Email</label>
                  <input type="email" value="{{old('email')}}" class="form-control {!! $errors->first('email', 'is-invalid') !!}" id="exampleInputEmail" placeholder="Enter Email" name="email">
                    @error('email')
                    <div class="help-block">{{ $message }}</div>
                    @enderror
                </div>
              </div>
            </div>
              {{-- <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="exampleInputEmail">Delivery Fees</label>
                          <input type="number" value="{{old('delivery_fees')}}" class="form-control {!! $errors->first('delivery_fees', 'is-invalid') !!}" id="exampleInputDeliveryFees" placeholder="Enter Delivery Fess" name="delivery_fees">
                          @error('delivery_fees')
                          <div class="help-block">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>
              </div> --}}
            <div class="row">
              <div class="col-md-4">
                <label for="exampleInputServiceType">ServiceType</label>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <div class="icheck-primary d-inline">
                    <input type="checkbox" id="delivery" name="service_type[]" value="delivery">
                    <label for="delivery">
                     Delivery
                   </label>
                 </div>
               </div>
             </div>
             <div class="col-md-4">
              <div class="form-group">
                <div class="icheck-primary d-inline">
                  <input type="checkbox" id="takeaway" name="service_type[]" value="takeaway">
                  <label for="takeaway">
                    Take away
                  </label>
                </div>
              </div>
            </div>
                @error('service_type')
                <div class="help-block">{{ $message }}</div>
                @enderror
          </div>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Working Days</h3>
                </div>
                <div class="card-body">
                  <div id="accordion">
                    <div class="card card-primary">
                      <div class="card-header">
                        <h4 class="card-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseWorkingDays" class="collapsed" aria-expanded="false">
                            Add Working Days For This Branch
                          </a>
                        </h4>
                      </div>
                      <div id="collapseWorkingDays" class="panel-collapse in collapse">
                        <div class="card-body">

                          <div class="row py-1">
                      <div class="col-md-3">
                        <div class="form-group">
                          <div class="icheck-primary d-inline">
                            <input type="checkbox" id="Sunday" class="working-day-bool" name="WorkingDay[sunday][on]" value="true">
                            <label for="Sunday">Sunday</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <label>From:</label>
                            <div class="input-group date" id="timepicker1" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" data-target="#timepicker1" name="WorkingDay[sunday][time_from]">
                              <div class="input-group-append" data-target="#timepicker1" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <div class="form-group">
                              <label>To:</label>
                              <div class="input-group date" id="timepicker2" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#timepicker2" name="WorkingDay[sunday][time_to]">
                                <div class="input-group-append" data-target="#timepicker2" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row py-1">
                      <div class="col-md-3">

                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <label>From (Second shift):</label>
                            <div class="input-group date" id="timepicker19" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" data-target="#timepicker19" name="WorkingDay[sunday][time_from2]">
                              <div class="input-group-append" data-target="#timepicker19" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <div class="form-group">
                              <label>To (Second shift):</label>
                              <div class="input-group date" id="timepicker29" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#timepicker29" name="WorkingDay[sunday][time_to2]">
                                <div class="input-group-append" data-target="#timepicker29" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <hr>

                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <div class="icheck-primary d-inline">
                            <input type="checkbox" id="Monday" class="working-day-bool" name="WorkingDay[monday][on]" value="true">
                            <label for="Monday">Monday</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <label>From:</label>
                            <div class="input-group date" id="timepicker3" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" data-target="#timepicker3" name="WorkingDay[monday][time_from]">
                              <div class="input-group-append" data-target="#timepicker3" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <div class="form-group">
                              <label>To:</label>
                              <div class="input-group date" id="timepicker4" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#timepicker4" name="WorkingDay[monday][time_to]">
                                <div class="input-group-append" data-target="#timepicker4" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">

                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <label>From (Second shift):</label>
                            <div class="input-group date" id="timepicker39" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" data-target="#timepicker39" name="WorkingDay[monday][time_from2]">
                              <div class="input-group-append" data-target="#timepicker39" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <div class="form-group">
                              <label>To (Second shift):</label>
                              <div class="input-group date" id="timepicker49" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#timepicker49" name="WorkingDay[monday][time_to2]">
                                <div class="input-group-append" data-target="#timepicker49" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <hr>

                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <div class="icheck-primary d-inline">
                            <input type="checkbox" id="Tuesday" class="working-day-bool" name="WorkingDay[tuesday][on]" value="true">
                            <label for="Tuesday">Tuesday</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <label>From:</label>
                            <div class="input-group date" id="timepicker5" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" data-target="#timepicker5" name="WorkingDay[tuesday][time_from]">
                              <div class="input-group-append" data-target="#timepicker5" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <div class="form-group">
                              <label>To:</label>
                              <div class="input-group date" id="timepicker6" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#timepicker6" name="WorkingDay[tuesday][time_to]">
                                <div class="input-group-append" data-target="#timepicker6" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">

                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <label>From (Second shift):</label>
                            <div class="input-group date" id="timepicker59" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" data-target="#timepicker59" name="WorkingDay[tuesday][time_from2]">
                              <div class="input-group-append" data-target="#timepicker59" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <div class="form-group">
                              <label>To (Second shift):</label>
                              <div class="input-group date" id="timepicker69" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#timepicker69" name="WorkingDay[tuesday][time_to2]">
                                <div class="input-group-append" data-target="#timepicker69" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <hr>

                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <div class="icheck-primary d-inline">
                            <input type="checkbox" id="Wednesday" class="working-day-bool" name="WorkingDay[wednesday][on]" value="true">
                            <label for="Wednesday">Wednesday</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <label>From:</label>
                            <div class="input-group date" id="timepicker7" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" data-target="#timepicker7" name="WorkingDay[wednesday][time_from]">
                              <div class="input-group-append" data-target="#timepicker7" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <div class="form-group">
                              <label>To:</label>

                              <div class="input-group date" id="timepicker8" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#timepicker8" name="WorkingDay[wednesday][time_to]">
                                <div class="input-group-append" data-target="#timepicker8" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-3">

                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <label>From (Second shift):</label>
                            <div class="input-group date" id="timepicker79" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" data-target="#timepicker79" name="WorkingDay[wednesday][time_from2]">
                              <div class="input-group-append" data-target="#timepicker79" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <div class="form-group">
                              <label>To (Second shift):</label>
                              <div class="input-group date" id="timepicker89" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#timepicker89" name="WorkingDay[wednesday][time_to2]">
                                <div class="input-group-append" data-target="#timepicker89" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <hr>

                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <div class="icheck-primary d-inline">
                            <input type="checkbox" id="Thursday" class="working-day-bool" name="WorkingDay[thursday][on]" value="true">
                            <label for="Thursday">Thursday</label>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <label>From:</label>
                            <div class="input-group date" id="timepicker9" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" data-target="#timepicker9" name="WorkingDay[thursday][time_from]">
                              <div class="input-group-append" data-target="#timepicker9" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <div class="form-group">
                              <label>To:</label>
                              <div class="input-group date" id="timepicker10" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#timepicker10" name="WorkingDay[thursday][time_to]">
                                <div class="input-group-append" data-target="#timepicker10" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-3">

                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <label>From (Second shift):</label>
                            <div class="input-group date" id="timepicker99" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" data-target="#timepicker99" name="WorkingDay[thursday][time_from2]">
                              <div class="input-group-append" data-target="#timepicker99" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <div class="form-group">
                              <label>To (Second shift):</label>
                              <div class="input-group date" id="timepicker109" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#timepicker109" name="WorkingDay[thursday][time_to2]">
                                <div class="input-group-append" data-target="#timepicker109" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <hr>

                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <div class="icheck-primary d-inline">
                            <input type="checkbox" id="Friday" class="working-day-bool" name="WorkingDay[friday][on]" value="true">
                            <label for="Friday">Friday</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <label>From:</label>
                            <div class="input-group date" id="timepicker11" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" data-target="#timepicker11" name="WorkingDay[friday][time_from]">
                              <div class="input-group-append" data-target="#timepicker11" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <div class="form-group">
                              <label>To:</label>
                              <div class="input-group date" id="timepicker12" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#timepicker12" name="WorkingDay[friday][time_to]">
                                <div class="input-group-append" data-target="#timepicker12" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-3">

                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <label>From (Second shift):</label>
                            <div class="input-group date" id="timepicker119" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" data-target="#timepicker119" name="WorkingDay[friday][time_from2]">
                              <div class="input-group-append" data-target="#timepicker119" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <div class="form-group">
                              <label>To (Second shift):</label>
                              <div class="input-group date" id="timepicker129" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#timepicker129" name="WorkingDay[friday][time_to2]">
                                <div class="input-group-append" data-target="#timepicker129" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <hr>

                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <div class="icheck-primary d-inline">
                            <input type="checkbox" id="Saturday" class="working-day-bool" name="WorkingDay[saturday][on]" value="true">
                            <label for="Saturday">Saturday</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <label>From:</label>
                            <div class="input-group date" id="timepicker13" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" data-target="#timepicker13" name="WorkingDay[saturday][time_from]">
                              <div class="input-group-append" data-target="#timepicker13" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <div class="form-group">
                              <label>To:</label>
                              <div class="input-group date" id="timepicker14" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#timepicker14" name="WorkingDay[saturday][time_to]">
                                <div class="input-group-append" data-target="#timepicker14" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">

                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <label>From (Second shift):</label>
                            <div class="input-group date" id="timepicker139" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" data-target="#timepicker139" name="WorkingDay[saturday][time_from2]">
                              <div class="input-group-append" data-target="#timepicker139" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="bootstrap-timepicker">
                            <div class="form-group">
                              <label>To (Second shift):</label>
                              <div class="input-group date" id="timepicker149" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#timepicker149" name="WorkingDay[saturday][time_to2]"  >
                                <div class="input-group-append" data-target="#timepicker149" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                        <hr>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Delivery Areas</h3>
              </div>
              <div class="card-body">
                <div id="accordion">
                  <div class="card card-primary">
                    <div class="card-header">
                      <h4 class="card-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseDeliveryAreas" class="collapsed" aria-expanded="false">
                          Add Delivery Areas For This Branch
                        </a>
                      </h4>
                    </div>
                    <div id="collapseDeliveryAreas" class="panel-collapse in collapse" style="">
                      <div class="card-body">
                        <div class="row py-3">
                          <div class="col-md-12">
                            <div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="city">Select City</label>
                                    <select class="form-control select2-cities-delivery {!! $errors->first('city_id', 'is-invalid') !!}" id="city-select" name="city_id">
                                      <option>Select Delivery City</option>

                                    </select>
                                      @error('city_id')
                                      <div class="help-block">{{ $message }}</div>
                                      @enderror
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row py-3" id="areas-section">

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

    $( document ).ready(function() {

        let app_url = '{{ url('/') }}';
        $('.select2-cities-delivery').select2(
            {
                ajax: {
                    url: app_url + "/api/cities/",
                    dataType: 'json',
                    processResults: function (data) {
                      console.log('www');
                        console.log(data)

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

        $('.select2-cities').select2(
            {

                ajax: {
                    url: app_url + "/api/cities/",
                    dataType: 'json',
                    processResults: function (data) {
                        console.log(data)

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


    $(":checkbox.working-day-bool").change(e => {
      console.log(e.target);
    })

    $('.branch-city-select').change(e => {


        let target_name = e.target.dataset.target;
        // console.log(target_name);
        let target_selector = "select[name='" + target_name + "']";
        // console.log(target_selector);

        let city_id = e.target.value;
        let app_url = '{{ url('/') }}';

        let endpoint = `${app_url}/api/cities/${city_id}/areas`;

            // console.log(endpoint);

        $.get(endpoint, res => {



            let elements = '';

            res.data.forEach(element => {
                elements += `<option value="${element.id}">${element['name_'+'{{app()->getLocale()}}']}</option>`;
            });

            $(target_selector).html(elements);

        });

    });

    $('#city-select').change(e => {


      let app_url = '{{ url('/') }}';

      var city_id = e.target.value;


      var endpoint = app_url + "/api/cities/" + city_id+ "/areas";

      var section = $('#areas-section');

      $.get(endpoint, function(res) {;

        var element = '';
        var size = res.data.length;

        for(let i=0; i < res.data.length; i++) {

          let name = res.data[i]['name_'+'{{app()->getLocale()}}'];
          let index = i+1;
          let id = res.data[i].id;

          element += `
          <div class="col-md-4">
          <div class="form-group">
          <div class="icheck-primary d-inline">
          <input type="checkbox" id="area-${index}" name="areas[]" value="${id}">
          <label for="area-${index}">${name}</label>
          </div>
          </div>
          </div>
          `;
        }

        section.html(element);

      });
    });
  });







  $('.custom-file-input').on('change',function(){
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
    })




</script>
@endpush
