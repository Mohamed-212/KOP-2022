@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Roles</h1>
        </div>
        <div class="col-sm-6">
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="card-body">
        <style>
          tr th, tr td {
            text-align: center;
          }
        </style>
        <table class="table table-bordered table-striped dataTable">
          <thead>
            <tr>
              <th>Role Name</th>
              {{-- <th>Action</th> --}}
            </tr>
          </thead>
          <tbody>
            @foreach ($roles as  $role)
              <tr>
                <td>{{$role->name}}</td>
                {{-- <td>
                  <a href="{{ route('admin.role.edit', $role->id) }}" class="btn btn-primary btn-circle btn-sm" title="edit"><i class="fa fa-edit"></i></a>
                  <a onclick="deleteRole('delete-role-{{ $role->id }}')" href="#" class="btn btn-danger btn-circle btn-sm" title="delete">
                      <i class="fas fa-trash"></i>
                  </a>
                  <a href="{{ route('admin.get.permission' , $role->id) }}" class="btn btn-info btn-circle btn-sm"><i class="fas fa-user-secret" title="permission"></i></a>
                  <!-- Form Delete role -->
                  <form action="{{ route('admin.role.destroy', $role->id) }}" method="POST" id="{{ 'delete-role-' . $role->id }}">
                      @csrf
                      @method('DELETE')
                  </form>
                  <!-- End Delete role -->
                </td> --}}
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
  function deleteRole(id) {
    event.preventDefault();
    swal({
        title: 'Are you sure to delete this role ?',
        text: 'Once the role has been deleted you cannot retrieve its data',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $('#' + id).submit();
            swal('Role successfully deleted', {
                icon: 'success',
            });
        } else {
            swal('Role undeleted');
        }
    });
  }
</script>
@endpush