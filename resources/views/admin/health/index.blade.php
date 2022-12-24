@extends('layouts.admin.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Health Info</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.healthinfo.create')}}">Add New Health Info</a>
                            </li>
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
                            <th>Title En</th>
                            <th>Title Ar</th>
                            <th>Image</th>
                            <th style="text-align: center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            
                        @foreach ($infos as $index => $info)
                            <tr>
                                <td>{{$index + 1 }}</td>
                                <td>{{ $info->title_en}}</td>
                                <td>{{ $info->title_ar}}</td>
                                <td><img loading="lazy" data-lazy="true" src="{{asset($info->image)}}" class="img-thumbnail"  style="max-width: 80px" /></td>
                                <td style="padding: 0;text-align: center;">
                                    <a href="{{ route('admin.healthinfo.show', $info->id) }}"
                                       class="btn btn-primary btn-circle btn-sm" title="Show"><i
                                            class="fa fa-globe"></i></a>
                                    <a href="{{ route('admin.healthinfo.edit', $info->id) }}"
                                       class="btn btn-primary btn-circle btn-sm" title="edit"><i class="fa fa-edit"></i></a>

                                    <a onclick="deleteInfo('{{ 'delete-info-' . $info->id }}')" href="#"
                                       class="btn btn-danger btn-circle btn-sm" title="delete"><i
                                            class="fas fa-trash"></i> </a>
                                    <!-- Form Delete category -->
                                    <form
                                        action="{{ route('admin.healthinfo.delete', $info->id) }}"
                                        method="POST"
                                        id="{{ 'delete-info-' . $info->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <!-- End Delete category -->
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
        function deleteInfo(id) {
            event.preventDefault();
            swal({
                title: 'Are you sure to delete this Blog ?',
                text: 'Once the Blog has been deleted you cannot retrieve its data',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $('#' + id).submit();
                        swal('Blog successfully deleted', {
                            icon: 'success',
                        });
                    } else {
                        swal('Blog undeleted');
                    }
                });
        }
    </script>
@endpush
