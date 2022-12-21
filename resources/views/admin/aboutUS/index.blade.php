@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>AboutUS</h1>
        </div>
      {{-- @if($aboutUS->where('type', '!=', 'feat')->count() <= 3) --}}
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.aboutUS.create')}}">Add New AboutUS</a></li>
          </ol>
        </div>
      {{-- @endif --}}
      </div>
    </div>
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="card-body">
        <table class="table table-bordered table-striped dataTable">
          <thead>
            <tr>
              <th>Type</th>
              <th>Title_en</th>
              <th>Title_ar</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($aboutUS as $about)
            <tr>
              <td>
                {{__('general.' . $about->type)}}
              </td>
              <td><a href="{{ route('admin.aboutUS.show', $about->id) }}">{{ $about->id }}</a>
                <img loading="lazy" data-lazy="true"  src="{{asset($about->image)}}" class="img-thumbnail" style="    height: 200px;" />
              </td>
              <td>{{$about->title_en}}</td>
              <td>{{$about->title_ar}}</td>
              <td style="padding: 0;text-align: center;">
                  <a href="{{ route('admin.aboutUS.edit', $about->id) }}" class="btn btn-primary btn-circle btn-sm" title="edit"><i class="fa fa-edit"></i></a>
                  <a onclick="deleteOffer('{{ 'delete-offer-' . $about->id }}')"
                     href="#" class="btn btn-danger btn-circle btn-sm"
                     title="delete">
                      <i class="fas fa-trash"></i>
                  </a>
                  <!-- Form Delete offer -->
                  <form
                      action="{{ route('admin.aboutUS.destroy', $about->id) }}"
                      method="POST"
                      id="{{ 'delete-offer-' . $about->id }}">
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
        title: 'Are you sure to delete this AboutUS ?',
        text: 'Once the AboutUS has been deleted you cannot retrieve its data',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $('#' + id).submit();
            swal('AboutUS successfully deleted', {
                icon: 'success',
            });
        } else {
            swal('AboutUS undeleted');
        }
    });
  }
</script>
@endpush
