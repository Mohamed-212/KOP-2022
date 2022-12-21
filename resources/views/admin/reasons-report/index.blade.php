@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Reasons Report</h1>
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
                            <th>user id</th>
                            <th>user name</th>
                            <th>user phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as  $u)
                        <tr>
                            <td>#{{$u->id}}</td>
                            <td>
                                {{$u->name}}
                            </td>
                            <td>
                                {{$u->first_phone}}
                            </td>
                            <td>
                                <a href="{{ route('admin.reasons-report.show', $u->id) }}" class="btn btn-primary btn-circle btn-sm" title="edit"><i class="fa fa-edit"></i></a>
                                {{-- <a onclick="deletepoint('{{ 'delete-reason-' . $u->id }}')" href="#" class="btn btn-danger btn-circle btn-sm" title="delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <!-- Form Delete branch -->
                                <form action="{{ route('admin.reasons-report.destroy', $u->id) }}" method="POST" id="{{ 'delete-reason-' . $u->id }}">
                                    @csrf
                                    @method('DELETE')
                                </form> --}}
                                <!-- End Delete branch -->
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
    function deletepoint(id) {
        event.preventDefault();
        swal({
            title: 'Are you sure to delete this point ?',
            text: 'Once the branch has been deleted you cannot retrieve its data',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $('#' + id).submit();
                swal('point successfully deleted', {
                    icon: 'success',
                });
            } else {
                swal('point undeleted');
            }
        });
    }
</script>
@endpush
