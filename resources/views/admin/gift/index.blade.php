@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gifts</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.gift.create')}}">Add New Gift</a></li>
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
                            <th>English Name</th>
                            <th>Arabic Name</th>
                            <th>Points</th>
                            <th>Image</th>
                            <th style="text-align: center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gifts as  $gift)
                        <tr>
                            <td>{{$gift->name_en}}</td>
                            <td>{{$gift->name}}</td>
                            <td>{{$gift->points}}</td>
                            <td><img loading="lazy" data-lazy="true" src="{{$gift->image}}" class="img-thumbnail"  style="max-width: 80px" ></td>
                            <td style="padding: 0;text-align: center;">
                                <a href="{{ route('admin.gift.edit', $gift->id) }}" class="btn btn-primary btn-circle btn-sm" title="edit"><i class="fa fa-edit"></i></a>
                                <a onclick="deleteGift('{{ 'delete-gift-' . $gift->id }}')" href="#" class="btn btn-danger btn-circle btn-sm" title="delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <!-- Form Delete branch -->
                                <form action="{{ route('admin.gift.destroy', $gift->id) }}" method="POST" id="{{ 'delete-gift-' . $gift->id }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <!-- End Delete branch -->
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
    function deleteGift(id) {
        event.preventDefault();
        swal({
            title: 'Are you sure to delete this Gift ?',
            text: 'Once the branch has been deleted you cannot retrieve its data',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $('#' + id).submit();
                swal('Gift successfully deleted', {
                    icon: 'success',
                });
            } else {
                swal('Gift undeleted');
            }
        });
    }
</script>
@endpush
