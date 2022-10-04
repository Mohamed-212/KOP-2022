@extends('layouts.admin.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Notification</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.notification.create') }}">Add New Notification</a></li>
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
                                <th>Subject</td>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Messages as $index => $Message)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                   <td>{{ $Message->subject }}</td>
                                    <td>{{ $Message->description }}</td>
                                    
                                    <td>
                                        
                                       
                                        <a onclick="deleteCategory('{{ 'delete-item-' . $Message->id }}')" href="#"
                                            class="btn btn-danger btn-circle btn-sm" title="delete">
                                            <i class="fas fa-trash"></i>
                                        </a>

                                        <form action="{{ route('admin.notification.destroy', $Message->id) }}" method="POST"
                                            id="{{ 'delete-item-' . $Message->id }}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
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
        function deleteCategory(id) {
            event.preventDefault();
            swal({
                    title: 'Are you sure to delete this Notification< ?',
                    text: 'Once the Notification has been deleted you cannot retrieve its data',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $('#' + id).submit();
                        swal('Notification successfully deleted', {
                            icon: 'success',
                        });
                    } else {
                        swal('Notification undeleted');
                    }
                });
        }
    </script>
@endpush
