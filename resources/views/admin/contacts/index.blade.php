@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Contact Us </h1>
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
                                <th>Subject</th>
                                <th>date</th>
                                <th>Customer Name</th>
                                <th style="text-align: center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contacts as $contact)
                            <tr>
                                <td>{{ $contact->id }}</td>
                                <td>{{ $contact->subject }}</td>
                                <td>{{ $contact->created_at }}</td> 
                                <td>{{ $contact->customer->name }}</td>
                                <td><a class="btn btn-primary btn-sm" title="Show" href="{{route('admin.contact.show',$contact->id)}}"><i class='fas fa fa-globe'></i></a></td>
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
                title: 'Are you sure to delete this message ?',
                text: 'Once the message has been deleted you cannot retrieve its data',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $('#' + id).submit();
                    swal('Category successfully deleted', {
                        icon: 'success',
                    });
                } else {
                    swal('Category undeleted');
                }
            });
        }

    </script>
    @endpush
