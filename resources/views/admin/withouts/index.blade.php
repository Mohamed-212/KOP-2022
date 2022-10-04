@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Without </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.without.create')}}">Add New Without</a></li>
                    </ol>
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
                                <th>Name AR</th>
                                <th>Name EN</th>
                                <th>Price</th>
                                <th>Calories</th>
                                {{-- <th>Image</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($withouts as $without)
                            <tr>
                                <td>{{ $without->id }}</td>
                                <td>{{ $without->category['name_'.app()->getLocale()] }}</td>
                                <td>{{ $without->name_ar }}</td>
                                <td>{{ $without->name_en }}</td>
                                <td>{{ $without->price }}</td>
                                <td>{{ $without->calories }}</td>
                                {{-- <td><img src="{{ $without->image }}" style="max-width: 75px" ></td> --}}
                                <td>
                                    <a href="{{ route('admin.without.show', $without->id) }}" class="btn btn-primary btn-circle btn-sm" title="Show"><i class="fa fa-globe"></i></a>
                                    <a href="{{ route('admin.without.edit', $without->id) }}" class="btn btn-primary btn-circle btn-sm" title="edit"><i class="fa fa-edit"></i></a>
                                    <a onclick="deleteCategory('{{ 'delete-without-' . $without->id }}')" href="#" class="btn btn-danger btn-circle btn-sm" title="delete"> <i class="fas fa-trash"></i></a>
                                    <form action="{{ route('admin.without.destroy', $without->id) }}" method="POST" id="{{ 'delete-without-' . $without->id }}">
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
                title: 'Are you sure to delete this field ?',
                text: 'Once the Without has been deleted you cannot retrieve its data',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $('#' + id).submit();
                    swal('Field successfully deleted', {
                        icon: 'success',
                    });
                } else {
                    swal('Field undeleted');
                }
            });
        }

    </script>
    @endpush
