@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add New User</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.user.index')}}">Back</a></li>
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
            <form action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data" id="add-user">
              @csrf
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputFirstName">First Name</label>
                      <input type="text" class="form-control {!! $errors->first('first_name', 'is-invalid') !!}" id="exampleInputFirstName" placeholder="Enter First Name" name="first_name" value="{{ old('first_name') ?? '' }}">
                      {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputMiddleName">Middle Name</label>
                      <input type="text" class="form-control {!! $errors->first('middle_name', 'is-invalid') !!}" id="exampleInputMiddleName" placeholder="Enter Middle Name" name="middle_name" value="{{ old('middle_name') ?? '' }}">
                      {!! $errors->first('middle_name', '<p class="help-block">:message</p>') !!}

                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputLastName">Last Name</label>
                      <input type="text" class="form-control {!! $errors->first('last_name', 'is-invalid') !!}" id="exampleInputLastName" placeholder="Enter Last Name" name="last_name" value="{{ old('last_name') ?? '' }}">
                      {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail">Email</label>
                      <input type="email" class="form-control {!! $errors->first('email', 'is-invalid') !!}" id="exampleInputEmail" placeholder="Enter email" name="email" value="{{ old('email') ?? '' }}">
                      {!! $errors->first('email', '<p class="help-block">:message</p>') !!}

                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputRole">Role</label>
                      <select class="select2  {!! $errors->first('roles', 'is-invalid') !!}" multiple="multiple" data-placeholder="Select a Role" style="width: 100%;" name="roles[]">
                        @foreach($roles as $role)
                        <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                      </select>
                      {!! $errors->first('roles', '<p class="help-block">:message</p>') !!}

                    </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="exampleInputage">Age</label>
                          <input type="text" class="form-control {!! $errors->first('age', 'is-invalid') !!}" id="exampleInputage" placeholder="Enter Age" name="age" value="{{ old('age') ?? '' }}">
                          {!! $errors->first('age', '<p class="help-block">:message</p>') !!}
                        </div>
                      </div>
                    <div class="col-md-6">
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
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password" class="form-control {!! $errors->first('password', 'is-invalid') !!}" id="password" placeholder="Enter Password" name="password">
                      {!! $errors->first('password', '<p class="help-block">:message</p>') !!}

                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputConfirmPassword">Confirm Password</label>
                      <input type="password" class="form-control {!! $errors->first('password_confirmation', 'is-invalid') !!}" id="exampleInputConfirmPassword" placeholder="Enter Confirm Password" name="password_confirmation">
                      {!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}

                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputFirstPhone">First Phone</label>
                      <input type="text" class="form-control {!! $errors->first('first_phone', 'is-invalid') !!}" id="exampleInputFirstPhone" placeholder="Enter First Phone" name="first_phone" value="{{ old('first_phone') ?? '' }}">
                      {!! $errors->first('first_phone', '<p class="help-block">:message</p>') !!}
                    </div>

                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputSecondPhone">Second Phone</label>
                      <input type="text" class="form-control {!! $errors->first('second_phone', 'is-invalid') !!}" id="exampleInputSecondPhone" placeholder="Enter Second Phone" name="second_phone" value="{{ old('second_phone') ?? '' }}">
                      {!! $errors->first('second_phone', '<p class="help-block">:message</p>') !!}
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
  $(document).ready(() => {
    $('#add-user').validate({
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
          password_confirmation : {
            required: true,
            // minlength : 4,
            equalTo : "#password"
          }
        }
    });


    $('.custom-file-input').on('change',function(){
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
    })

  });
</script>
@endpush
