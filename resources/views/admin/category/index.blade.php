@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Categories</h1>
        </div>
        <div class="col-sm-6">
          @if (auth()->user()->hasRole('admin')) 
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.category.create')}}">Add New Category</a></li>
          </ol>
          @endif
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
              <th>Category Name</th>
              <th>Nubmer of Items</th>
              <th>Nubmer of Extras</th>
              <th>Image</th>
              <th style="text-align: center">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($categories as $index => $category)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $category['name_'.app()->getLocale()]}}</td>
              <td>{{ $category->items->count() }}</td>
              <td>{{ $category->extras->count() }}</td>
              <td><img loading="lazy" data-lazy="true"  src="{{ $category->image }}" class="img-thumbnail"  style="max-width: 80px"></td>
              <td style="padding: 0;text-align: center;">
                <a href="{{ route('admin.category.show', $category->id) }}" class="btn btn-primary btn-circle btn-sm" title="Show"><i class="fa fa-globe"></i></a>
                @if (auth()->user()->hasRole('admin')) 
                <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-primary btn-circle btn-sm" title="edit"><i class="fa fa-edit"></i></a>
                <a onclick="deleteCategory('{{ 'delete-category-' . $category->id }}')" href="#" class="btn btn-danger btn-circle btn-sm" title="delete"><i class="fas fa-trash"></i> </a>
                <!-- Form Delete category -->
                <form
                    action="{{ route('admin.category.destroy', $category->id) }}"
                    method="POST"
                    id="{{ 'delete-category-' . $category->id }}">
                    @csrf
                    @method('DELETE')
                </form>
                <!-- End Delete category -->
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
        title: 'Are you sure to delete this category ?',
        text: 'Once the category has been deleted you cannot retrieve its data',
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
