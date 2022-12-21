@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Customers</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.customer.create')}}">Add New Customer</a></li>
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
                <th>Customer Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Area</th>
                <th>City</th>
                <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($customers as $index => $customer)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <a href="{{route('admin.customer.show' , $customer->id)}}">
                        {{ $customer->name }}
                    </a>
                </td>
                <td>{{ $customer->email }}</td>
                <th>{{ $customer->first_phone }}</th>
                <th>{{ $customer->addresses->first()->area->name_ar ?? "" }}</th>
                <th>{{ $customer->addresses->first()->city->name_ar ?? "" }}</th>
                <td style="padding: 0;text-align: center;">
                  <a href="{{ route('admin.customer.edit', $customer->id) }}" class="btn btn-primary btn-circle btn-sm" title="edit"><i class="fa fa-edit"></i></a>
                  <a onclick="deleteCustomer('{{ 'delete-customer-' . $customer->id }}')" href="#" class="btn btn-danger btn-circle btn-sm" title="delete"><i class="fas fa-trash"></i></a>
                  <!-- Form Delete customer -->
                  <form action="{{ route('admin.customer.destroy', $customer->id) }}" method="POST" id="{{ 'delete-customer-' . $customer->id }}">
                      @csrf
                      @method('DELETE')
                  </form>
                  <!-- End Delete customer -->
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
  function deleteCustomer(id) {
    event.preventDefault();
    swal({
        title: 'Are you sure to delete this customer ?',
        text: 'Once the customer has been deleted you cannot retrieve its data',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $('#' + id).submit();
            swal('Customer successfully deleted', {
                icon: 'success',
            });
        } else {
            swal('Customer undeleted');
        }
    });
  }
</script>
@endpush
