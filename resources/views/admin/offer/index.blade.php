@extends('layouts.admin.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Offers</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.offer.create') }}">Add New Offer</a></li>
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
                                <th>Name</th>
                                <th>Date From</th>
                                <th>Date To</th>
                                <th>Service</th>
                                <th>Mobile Image</th>
                                <th>Website Home Image</th>
                                <th>Website Menu Image</th>
                                <th style="text-align: center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($offers as $index => $offer)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $offer->title }}</td>
                                    <td>{{ $offer->date_from }}</td>
                                    <td>{{ $offer->date_to }}</td>
                                    <td>{{ $offer->service_type }}</td>
                                    <td>
                                        <img loading="lazy" data-lazy="true"  src="{{asset($offer->image)}}" class="img-thumbnail"  style="max-width: 80px" />
                                    </td>
                                    <td>
                                        <img loading="lazy" data-lazy="true"  src="{{asset($offer->website_image)}}" class="img-thumbnail"  style="max-width: 80px" />
                                    </td>
                                    <td>
                                        <img loading="lazy" data-lazy="true"  src="{{asset($offer->website_image_menu)}}" class="img-thumbnail"  style="max-width: 80px" />
                                    </td>
                                    <td style="padding: 0;text-align: center;">
                                        @if (auth()->user()->hasRole('admin'))
                                        @if ($offer->main)
                                            <form action="{{ route('admin.offer.unmain', $offer->id) }}" method="POST" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-success btn-sm"
                                                    title="show on home screen">
                                                    <i class="fas fa-home"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.offer.main', $offer->id) }}" method="POST" style="display: inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-primary btn-sm"
                                                    title="show on home screen">
                                                    <i class="fas fa-home"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @endif
                                        <a href="{{ route('admin.offer.show', $offer->id) }}" class="btn btn-primary btn-circle btn-sm" title="Show"><i class="fa fa-globe"></i></a>
                                        <a href="{{ route('admin.offer.edit', $offer->id) }}"
                                            class="btn btn-primary btn-circle btn-sm" title="edit"><i
                                                class="fa fa-edit"></i></a>
                                        <a onclick="deleteOffer('{{ 'delete-offer-' . $offer->id }}')" href="#"
                                            class="btn btn-danger btn-circle btn-sm" title="delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <!-- Form Delete offer -->
                                        <form action="{{ route('admin.offer.destroy', $offer->id) }}" method="POST"
                                            id="{{ 'delete-offer-' . $offer->id }}">
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
                    title: 'Are you sure to delete this offer ?',
                    text: 'Once the offer has been deleted you cannot retrieve its data',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $('#' + id).submit();
                        swal('Offer successfully deleted', {
                            icon: 'success',
                        });
                    } else {
                        swal('Offer undeleted');
                    }
                });
        }
    </script>
@endpush
