@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Extra </h1>
                </div>
                <div class="col-sm-6">
                    @if (auth()->user()->hasRole('admin'))
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.extra.create')}}">Add New Extra</a></li>
                    </ol>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">

            <form method=get>
                <div class="row card-body">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>category</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="category">
                                <option value="all" >All</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if(request('category') == $category->id) selected @endif>
                                    {{ $category['name_'.app()->getLocale()] }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label class="form-label" style="width: 100%;"></label>
                            <div class="input-group pull-right">
                                <button type="submit" class="btn btn-primary" style="margin-top: 6px; height: 35px;width: 80%;">Go</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

                <div class="card-body">
                    <table class="table table-bordered table-striped dataTable">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Category Name</th>
                                <th>Name En</th>
                                <th>Name Ar</th>
                                <th>Price</th>
                                <th>Calories</th>
                                {{-- <th>Image</th> --}}
                                <th style="text-align: center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($extras as $extra)
                            <tr>
                                <td>{{ $extra->id }}</td>
                                <td>{{ $extra->category['name_'.app()->getLocale()] }}</td>
                                <td>{{ $extra->name_ar }}</td>
                                <td>{{ $extra->name_en }}</td>
                                <td>{{ $extra->price }}</td>
                                <td>{{ $extra->calories }}</td>
                                {{-- <td><img loading="lazy" data-lazy="true"  src="{{ $extra->image }}" class="img-thumbnail"  style="max-width: 80px" ></td> --}}
                                <td style="padding: 0;text-align: center;">
                                    
                                    <a href="{{ route('admin.extra.show', $extra->id) }}" class="btn btn-primary btn-circle btn-sm" title="Show"><i class="fa fa-globe"></i></a>
                                    @if (auth()->user()->hasRole('admin'))
                                    <a href="{{ route('admin.extra.edit', $extra->id) }}" class="btn btn-primary btn-circle btn-sm" title="edit"><i class="fa fa-edit"></i></a>
                                    <a onclick="deleteCategory('{{ 'delete-extra-' . $extra->id }}')" href="#" class="btn btn-danger btn-circle btn-sm" title="delete"> <i class="fas fa-trash"></i></a>
                                    <form action="{{ route('admin.extra.destroy', $extra->id) }}" method="POST" id="{{ 'delete-extra-' . $extra->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @endif
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
                title: 'Are you sure to delete this extra ?',
                text: 'Once the extra has been deleted you cannot retrieve its data',
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
