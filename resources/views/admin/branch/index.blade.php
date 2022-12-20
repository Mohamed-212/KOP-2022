@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Branches</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.branch.create')}}">Add New Branch</a></li>
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
                            <th>English Name</th>
                            <th>Arabic Name</th>
                            <th>Service Type</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($branches as  $branch)
                        <tr>
                            <td>{{$branch->name_en}}</td>
                            <td>{{$branch->name_ar}}</td>
                            <td>{{$branch->service_type}}</td>
                            <td>{{$branch->address_description}}</td>
                            <td style="padding: 0;text-align: center;">
                                <a href="{{ route('admin.branch.edit', $branch->id) }}" class="btn btn-primary btn-circle btn-sm" title="edit"><i class="fa fa-edit"></i></a>
                                <a onclick="deleteBranch('{{ 'delete-branch-' . $branch->id }}')" href="#" class="btn btn-danger btn-circle btn-sm" title="delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <!-- Form Delete branch -->
                                <form action="{{ route('admin.branch.destroy', $branch->id) }}" method="POST" id="{{ 'delete-branch-' . $branch->id }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
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
    function deleteBranch(id) {
        event.preventDefault();
        swal({
            title: 'Are you sure to delete this branch ?',
            text: 'Once the branch has been deleted you cannot retrieve its data',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $('#' + id).submit();
                swal('Branch successfully deleted', {
                    icon: 'success',
                });
            } else {
                swal('Branch undeleted');
            }
        });
    }
</script>
@endpush
