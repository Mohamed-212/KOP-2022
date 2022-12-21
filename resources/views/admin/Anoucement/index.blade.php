@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Anoucement</h1>
        </div>
        <!-- <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.Anoucement.create')}}">Add New Anoucement</a></li>
          </ol>
        </div> -->
      </div>
    </div>
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="card-body">
        <table class="table table-bordered table-striped dataTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Name_en</th>
              <th>Name_ar</th>
              <th>Description_en</th>
              <th>Description_ar</th>
              <th>Image</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($Anoucement as $Anouce)
            <tr>
              <td>{{ $Anouce->id }}</td>
              <td>{{$Anouce->name_en}}</td>
              <td>{{$Anouce->name_ar}}</td>
              <td>{{$Anouce->description_en}}</td>
              <td>{{$Anouce->description_ar}}</td>
              <td><img loading="lazy" data-lazy="true"  src="{{ asset($Anouce->image) }}" style="max-width: 75px" /></td>
              <td style="padding: 0;text-align: center;">
                  <a href="{{ route('admin.Anoucement.edit', $Anouce->id) }}" class="btn btn-primary btn-circle btn-sm" title="edit"><i class="fa fa-edit"></i></a>
                  <a onclick="deleteOffer('{{ 'delete-offer-' . $Anouce->id }}')"
                     href="#" class="btn btn-danger btn-circle btn-sm"
                     title="delete">
                      <i class="fas fa-trash"></i>
                  </a>
                  <!-- Form Delete offer -->
                  <form
                      action="{{ route('admin.Anoucement.destroy', $Anouce->id) }}"
                      method="POST"
                      id="{{ 'delete-offer-' . $Anouce->id }}">
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
        title: 'Are you sure to delete this Anoucement ?',
        text: 'Once the Anoucement has been deleted you cannot retrieve its data',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $('#' + id).submit();
            swal('Anoucement successfully deleted', {
                icon: 'success',
            });
        } else {
            swal('Anoucement undeleted');
        }
    });
  }
</script>
@endpush