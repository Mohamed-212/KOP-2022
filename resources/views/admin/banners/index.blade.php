@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Banners</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.banner.create')}}">Add New Banner</a></li>
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
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banners as $banner)
                            <tr>
                                <td>{{ $banner->id }}</td>
                                <td><img loading="lazy" data-lazy="true"  src="{{ asset($banner->image) }}" style="max-width: 75px" ></td>
                                <td style="padding: 0;text-align: center;">
                                    <a href="{{ route('admin.banner.edit', $banner->id) }}" class="btn btn-primary btn-circle btn-sm" title="edit"><i class="fa fa-edit"></i></a>
                                    <a onclick="deleteCategory('{{ 'delete-banner-' . $banner->id }}')" href="#" class="btn btn-danger btn-circle btn-sm" title="delete"> <i class="fas fa-trash"></i></a>
                                    <form action="{{ route('admin.banner.destroy', $banner->id) }}" method="POST" id="{{ 'delete-banner-' . $banner->id }}">
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
                title: 'Are you sure to delete this banner ?',
                text: 'Once the banner has been deleted you cannot retrieve its data',
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
