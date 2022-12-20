@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Gallery</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.gallery.create')}}">Add New Gallery</a></li>
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
              <th>Title_en</th>
              <th>Title_ar</th>
              <th>Image</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($galleries as $gallery)
            <tr>
              <td>{{ $gallery->id }}</td>
              <td>{{$gallery->title_en}}</td>
              <td>{{$gallery->title_ar}}</td>
              <td><img src="{{ asset($gallery->url) }}" style="max-width: 75px" ></td>
              <td style="padding: 0;text-align: center;">
                  <a href="{{ route('admin.gallery.edit', $gallery->id) }}" class="btn btn-primary btn-circle btn-sm" title="edit"><i class="fa fa-edit"></i></a>
                  <a onclick="deleteOffer('{{ 'delete-offer-' . $gallery->id }}')"
                     href="#" class="btn btn-danger btn-circle btn-sm"
                     title="delete">
                      <i class="fas fa-trash"></i>
                  </a>
                  <!-- Form Delete offer -->
                  <form
                      action="{{ route('admin.gallery.destroy', $gallery->id) }}"
                      method="POST"
                      id="{{ 'delete-offer-' . $gallery->id }}">
                      @csrf
                      @method('DELETE')
                  </form>
                  <!-- End Delete offer -->
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
  function deleteOffer(id) {
    event.preventDefault();
    swal({
        title: 'Are you sure to delete this gallery ?',
        text: 'Once the gallery has been deleted you cannot retrieve its data',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $('#' + id).submit();
            swal('gallery successfully deleted', {
                icon: 'success',
            });
        } else {
            swal('gallery undeleted');
        }
    });
  }
</script>
@endpush
