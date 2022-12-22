@extends('layouts.admin.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Jop Requests</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.careers.create')}}">Add New Job</a></li>
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
                            <th>#ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Details</th>
                            <th>C.V</th>
                            <!-- <th>Action</th> -->
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($requests as $index => $request)
                            <tr>
                                <td>{{$index + 1 }}</td>
                                <td>{{ $request->name}}</td>
                                <td>{{ $request->email}}</td>
                                <td>{{ $request->phone}}</td>
                                <td>{{ $request->description}}</td>
                                <td><a href="{{asset($request->cv_file)}}">View C.V</a></td>

                                <!-- <td>
                                    <a href="{{ route('admin.careers.show', $request->id) }}"
                                       class="btn btn-primary btn-circle btn-sm" title="Show"><i
                                            class="fa fa-globe"></i></a>
                                    <a href="{{ route('admin.careers.edit', $request->id) }}"
                                       class="btn btn-primary btn-circle btn-sm" title="edit"><i class="fa fa-edit"></i></a>

                                    <a onclick="deleteRequest('{{ 'delete-request-' . $request->id }}')" href="#"
                                       class="btn btn-danger btn-circle btn-sm" title="delete"><i
                                            class="fas fa-trash"></i> </a>
                                  
                                    <form
                                        action="{{ route('admin.careers.delete', $request->id) }}"
                                        method="POST"
                                        id="{{ 'delete-request-' . $request->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                   
                                </td> -->
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
        function deleteRequest(id) {
            event.preventDefault();
            swal({
                title: 'Are you sure to delete this Request ?',
                text: 'Once the Request has been deleted you cannot retrieve its data',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $('#' + id).submit();
                        swal('Request successfully deleted', {
                            icon: 'success',
                        });
                    } else {
                        swal('Request undeleted');
                    }
                });
        }
    </script>
@endpush
