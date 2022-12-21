@extends('layouts.admin.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Home Items</h1>
                    </div>
                    @if(count($homeitems) < 4)
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.homeitem.create') }}">Add New homeitem</a></li>
                        </ol>
                    </div>
                    @endif
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
                                <th>Category Name</th>
                                <th>Description AR</th>
                                <th>Description EN</th>
                                <th>Item Name</th>
                                <th>Number</td>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($homeitems as $index => $homeitem)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                   
                                    <td> @if ($homeitem->category){{ $homeitem->category['name_' . app()->getLocale()] }} @endif</td>
                                    <td>{{ $homeitem->description_ar }}</td>
                                    <td>{{ $homeitem->description_en }}</td>
                                    <td>@if($homeitem->item){{ $homeitem->item->name_en }}@endif</td>
                                    <td>{{ $homeitem->number }}</td>
                                    <td><img loading="lazy" data-lazy="true"  src="{{ asset($homeitem->image) }}" style="max-width: 75px" /></td>
                                    <td style="padding: 0;text-align: center;">
                                        <a href="{{ route('admin.homeitem.edit', $homeitem->id) }}"
                                            class="btn btn-primary btn-circle btn-sm" title="edit"><i
                                                class="fa fa-edit"></i></a>

                                        <a onclick="deleteCategory('{{ 'delete-item-' . $homeitem->id }}')" href="#"
                                            class="btn btn-danger btn-circle btn-sm" title="delete">
                                            <i class="fas fa-trash"></i>
                                        </a>

                                        <form action="{{ route('admin.homeitem.destroy', $homeitem->id) }}" method="POST"
                                            id="{{ 'delete-item-' . $homeitem->id }}">
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
                    title: 'Are you sure to delete this homeitem ?',
                    text: 'Once the item has been deleted you cannot retrieve its data',
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
