@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>dough</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            {{-- <li class="breadcrumb-item"><a href="{{route('admin.dough.create')}}">Add New dough</a></li> --}}
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
              {{-- <th>#ID</th> --}}
              <th>Group</th>
              <th>name_en</th>
              <th>name_ar</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $dough)
            <tr>
              {{-- <td>{{ $dough->id }}</td> --}}
              <td>#{{$dough->dough_type_id}}</td>
              <td>{{$dough->name_en}}</td>
              <td>{{$dough->name_ar}}</td>
              <td>
                  <a href="{{ route('admin.dough.edit', $dough->id) }}" class="btn btn-primary btn-circle btn-sm" title="edit"><i class="fa fa-edit"></i></a>
                  <a onclick="deleteOffer('{{ 'delete-offer-' . $dough->id }}')"
                     href="#" class="btn btn-danger btn-circle btn-sm"
                     title="delete">
                      <i class="fas fa-trash"></i>
                  </a>
                  <!-- Form Delete offer -->
                  <form
                      action="{{ route('admin.dough.destroy', $dough->id) }}"
                      method="POST"
                      id="{{ 'delete-offer-' . $dough->id }}">
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
  
</script>
@endpush
