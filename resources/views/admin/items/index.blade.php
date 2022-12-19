@extends('layouts.admin.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Items</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.item.create') }}">Add New Item</a></li>
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
                                <select class="form-control" name="category">
                                    <option value="all">All</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            @if (request('category') == $category->id) selected @endif>
                                            {{ $category['name_' . app()->getLocale()] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label class="form-label" style="width: 100%;"></label>
                                <div class="input-group pull-right">
                                    <button type="submit" class="btn btn-primary"
                                        style="margin-top: 6px; height: 35px;width: 80%;">Go</button>
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
                                <th>Mobile Image</th>
                                <th>Website Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    <td>
                                        @if ($item->category)
                                            {{ $item->category['name_' . app()->getLocale()] }}
                                        @endif
                                    </td>
                                    <td>{{ $item->name_ar }}</td>
                                    <td>{{ $item->name_en }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->calories }}</td>
                                    <td><img src="{{ asset($item->image) }}" style="max-width: 75px" /></td>
                                    <td><img src="{{ asset($item->website_image) }}" style="max-width: 75px" /></td>
                                    <td style="padding: 0;text-align: center;">
                                        @if (auth()->user()->hasRole('admin'))
                                            @if ($item->recommended)
                                                <form action="{{ route('admin.item.unrecommend', $item->id) }}"
                                                    method="POST" style="display: inline">
                                                    <button type="submit" class="btn btn-success btn-circle btn-sm"
                                                        title="UnRecommend"><i class="fa fa-heart"></i></button>
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            @else
                                                <form action="{{ route('admin.item.recommend', $item->id) }}"
                                                    method="POST" style="display: inline">
                                                    <button type="submit" class="btn btn-primary btn-circle btn-sm"
                                                        title="Recommend"><i class="fa fa-heart"></i></button>
                                                    @csrf
                                                    @method('put')
                                                </form>
                                            @endif
                                        @endif
                                        @if (auth()->user()->hasRole('branch_manager') && 0)
                                            @unless(count(array_intersect($userBranches, array_map(fn($a) => (int) $a, explode(',', $item->branches)))) > 0)
                                            <button type="button" onclick="confirmActon('{{ 'hide-th-item-' . $item->id }}', 'hide this item')" class="btn btn-info btn-circle btn-sm"
                                                        title="Hide"><i class="fa fa-eye-slash"></i></button>
                                                <form id="{{ 'hide-th-item-' . $item->id }}" action="{{ route('admin.item.hide', $item->id) }}" method="POST" style="display: inline">
                                                    
                                                    @csrf
                                                </form>
                                            @else
                                            <button type="button" onclick="confirmActon('{{ 'unhide-th-item-' . $item->id }}', 'un hide this item')" class="btn btn-success btn-circle btn-sm"
                                                        title="Un Hide"><i class="fa fa-eye-slash"></i></button>
                                                <form id="{{ 'unhide-th-item-' . $item->id }}" action="{{ route('admin.item.unhide', $item->id) }}" method="POST" style="display: inline">
                                                    
                                                    @csrf
                                                </form>
                                            @endunless
                                        @endif
                                        @if (auth()->user()->hasRole('branch_manager'))
                                            @unless(count(array_intersect($userBranches, array_map(fn($a) => (int) $a, explode(',', $item->out_of_stock)))) > 0)
                                            <button type="button" onclick="confirmActon('{{ 'stock_out-item-' . $item->id }}', 'set this item to out of stock')" class="btn btn-primary btn-circle btn-sm"
                                            title="Out Of Stock"><i class="fa fa-backspace"></i></button>
                                                <form id="{{ 'stock_out-item-' . $item->id }}" action="{{ route('admin.item.stock_out', $item->id) }}" method="POST" style="display: inline">
                                                    @csrf
                                                </form>
                                            @else
                                            <button type="button" class="btn btn-success btn-circle btn-sm" onclick="confirmActon('{{ 'stock_in-item-' . $item->id }}', 'set this item back to in stock')"
                                                        title="In Stock"><i class="fa fa-backspace"></i></button>
                                                <form id="{{ 'stock_in-item-' . $item->id }}" action="{{ route('admin.item.stock_in', $item->id) }}" method="POST" style="display: inline">
                                                    
                                                    @csrf
                                                </form>
                                            @endunless
                                        @endif
                                        <a href="{{ route('admin.item.show', $item->id) }}"
                                            class="btn btn-primary btn-circle btn-sm" title="Show"><i
                                                class="fa fa-globe"></i></a>

                                        @if (auth()->user()->hasRole('branch_manager'))
                                            {{-- @unless(count(array_intersect($userBranches, array_map(fn($a) => (int) $a, explode(',', $item->branches)))) > 0)
                                                <a href="{{ route('admin.item.edit', $item->id) }}"
                                                    class="btn btn-primary btn-circle btn-sm" title="edit"><i
                                                        class="fa fa-edit"></i></a>
                                                <a onclick="deleteCategory('{{ 'delete-item-' . $item->id }}')" href="#"
                                                    class="btn btn-danger btn-circle btn-sm" title="delete">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <!-- Form Delete item -->
                                                <form action="{{ route('admin.item.destroy', $item->id) }}" method="POST"
                                                    id="{{ 'delete-item-' . $item->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endunless --}}
                                        @else
                                        @if (auth()->user()->hasRole('admin'))
                                            <a href="{{ route('admin.item.edit', $item->id) }}"
                                                class="btn btn-primary btn-circle btn-sm" title="edit"><i
                                                    class="fa fa-edit"></i></a>
                                            <a onclick="deleteCategory('{{ 'delete-item-' . $item->id }}')" href="#"
                                                class="btn btn-danger btn-circle btn-sm" title="delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            <!-- Form Delete item -->
                                            <form action="{{ route('admin.item.destroy', $item->id) }}" method="POST"
                                                id="{{ 'delete-item-' . $item->id }}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endif
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
                    title: 'Are you sure to delete this item ?',
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

        function confirmActon(id, m) {
            event.preventDefault();
            swal({
                    title: 'Please Confirm',
                    text: 'Are you sure to ' + m,
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $('#' + id).submit();
                        // swal('item updated', {
                        //     icon: 'success',
                        // });
                    } else {
                        // swal('Category undeleted');
                    }
                });
        }
    </script>
@endpush
