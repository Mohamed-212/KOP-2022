@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Users</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.user.create')}}">Add New User</a></li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="card-body">
        <table class="table table-bordered table-striped dataTable">
          <thead>
            <tr>
              <th>User Name</th>
              <th>Email</th>
              <th>Role</th>
              <th style="text-align: center">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as  $user)
              <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>
                  @foreach($user->roles as $role)
                    {{$role->name}}
                  @endforeach
                </td>
                <td style="padding: 0;text-align: center;">
                  <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-primary btn-circle btn-sm" title="edit"><i class="fa fa-edit"></i></a>
                  <a onclick="deleteUser('{{ 'delete-user-' . $user->id }}')"
                     href="#" class="btn btn-danger btn-circle btn-sm"
                     title="delete">
                      <i class="fas fa-trash"></i>
                  </a>
                  <!-- Form Delete user -->
                  <form
                      action="{{ route('admin.user.destroy', $user->id) }}"
                      method="POST"
                      id="{{ 'delete-user-' . $user->id }}">
                      @csrf
                      @method('DELETE')
                  </form>
                  <!-- End Delete user -->
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
@endsection 
@push('js')
<script type="text/javascript">
  function deleteUser(id) {
    event.preventDefault();
    swal({
        title: 'Are you sure to delete this user ?',
        text: 'Once the user has been deleted you cannot retrieve its data',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $('#' + id).submit();
            swal('User successfully deleted', {
                icon: 'success',
            });
        } else {
            swal('User undeleted');
        }
    });
  }
</script>
@endpush