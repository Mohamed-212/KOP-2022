@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Deactivation Reasons</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @if ($reasons->count() < 5)
                        <li class="breadcrumb-item"><a href="{{route('admin.reasons.create')}}">Add New Reason</a></li>
                        @endif
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
                            {{-- <th>id</th> --}}
                            <th>Reason Ar</th>
                            <th>Reason En</th>
                            <th style="text-align: center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reasons as  $re)
                        <tr>
                            {{-- <td>#{{$re->id}}</td> --}}
                            <td>{{$re['reason_ar']}}</td>
                            <td>{{$re['reason_en']}}</td>
                            <td style="padding: 0;text-align: center;">
                                <a href="{{ route('admin.reasons.edit', $re->id) }}" class="btn btn-primary btn-circle btn-sm" title="edit"><i class="fa fa-edit"></i></a>
                                <a onclick="deletepoint('{{ 'delete-reason-' . $re->id }}')" href="#" class="btn btn-danger btn-circle btn-sm" title="delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <!-- Form Delete branch -->
                                <form action="{{ route('admin.reasons.destroy', $re->id) }}" method="POST" id="{{ 'delete-reason-' . $re->id }}">
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
