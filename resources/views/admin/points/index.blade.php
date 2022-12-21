@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Point Values</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.points.create')}}">Add New Point Value</a></li>
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
                            <th>Discount (SR)</th>
                            <th>Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($points as  $point)
                        <tr>
                            {{-- <td>#{{$point->id}}</td> --}}
                            <td>{{$point->value}} {{__('general.SR')}}</td>
                            <td>{{$point->for}}</td>
                            <td style="padding: 0;text-align: center;">
                                <a href="{{ route('admin.points.edit', $point->id) }}" class="btn btn-primary btn-circle btn-sm" title="edit"><i class="fa fa-edit"></i></a>
                                <a onclick="deletepoint('{{ 'delete-point-' . $point->id }}')" href="#" class="btn btn-danger btn-circle btn-sm" title="delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <!-- Form Delete branch -->
                                <form action="{{ route('admin.points.destroy', $point->id) }}" method="POST" id="{{ 'delete-point-' . $point->id }}">
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
