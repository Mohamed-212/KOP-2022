@extends('layouts.admin.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Blogs</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.news.create')}}">Add New Blog</a></li>
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
                             <th>Blog Title</th>
                             <th>Image</th>
                             <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($news as $index => $new)
                            <tr>
                                <td>{{$index + 1 }}</td>
                                <td>{{ $new->title_en}}</td>
                                 <td><img src="{{ $new->image }}" style="max-width: 75px" /></td>
                                 <td style="padding: 0;text-align: center;">
                                    <a href="{{ route('admin.news.show', $new->id) }}" class="btn btn-primary btn-circle btn-sm" title="Show"><i class="fa fa-globe"></i></a>
                                    <a href="{{ route('admin.news.edit', $new->id) }}" class="btn btn-primary btn-circle btn-sm" title="edit"><i class="fa fa-edit"></i></a>

                                     <a onclick="deleteBlog('{{ 'delete-blog-' . $new->id }}')" href="#" class="btn btn-danger btn-circle btn-sm" title="delete"><i class="fas fa-trash"></i> </a>
                                    <!-- Form Delete category -->
                                    <form
                                        action="{{ route('admin.news.delete', $new->id) }}"
                                        method="POST"
                                        id="{{ 'delete-blog-' . $new->id }}">
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
        function deleteBlog(id) {
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
