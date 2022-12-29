@extends('layouts.admin.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Orders</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <div class="card-body">

                    <form action="{{ route('admin.order.index') }}">

                        @csrf
                        @method('post')

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <select name="order_from"  class="form-control" id="">
                                        @foreach(['all','website', 'mobile'] as $from)
                                            <option value="{{ $from }}">{{ $from }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div><!-- end of col -->

                            <div class="col-md-6">
                                <button class="btn btn-primary">Go</button>
                            </div>

                        </div><!-- end of row -->

                    </form>


                    <table class="table table-bordered table-striped dataTable" id="order_table">
                        <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer Name</th>
                            <th>Branch Name</th>
                            <th>Order From</th>
                            <th>Type</th>
                            <th>Total</th>
                            <th>State</th>
                            <th>Date</th>
                            <!--<th>Cancellation Reason</th>-->
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td><a href="{{route('admin.order.show', $order->id)}}">{{ $order->id }}</a></td>
                                <td>{{ $order->customer->name }}</td>
                                <td>{{ $order->branch->name_en }}</td>
                                <td>{{ $order->order_from }}</td>
                                <td>{{ $order->service_type }}</td>
                                <td>{{ $order->total }}</td>
                                <td>{{ $order->state }}</td>
                                <!--<td>{{ $order->cancellation_reason? $order->cancellation_reason : "-" }}</td>-->
                                <td>{{ $order->created_at }}</td>
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


    <script>

        $(document).ready(function () {

           });
    </script>
@endpush
