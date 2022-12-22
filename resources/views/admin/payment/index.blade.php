@extends('layouts.admin.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Payments</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card-body">
                    <form method="get">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Search</label>
                                    <input type="text" class="form-control" name="search"
                                        value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>From</label>
                                    <input type="date" class="form-control" name="from" value="{{ request('from') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>To</label>
                                    <input type="date" class="form-control" name="to" value="{{ request('to') }}">
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
                </div>
            </div>
        </section>
        @if (!is_null($payments))
            <section class="content">
                <div class="container-fluid">
                    <div class="card-body">
                        <table class="table table-bordered table-striped dataTable">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Payment Id</th>
                                    <th>Order Id</th>
                                    <th>Customer Id</th>
                                    <th>Total Paid</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $py)
                                    <tr>
                                        <td>{{ $py->id }}</td>
                                        <td>
                                            <a href="{{ route('admin.report.payments.one', $py->id) }}">
                                                {{ $py->payment_id }}
                                            </a>
                                        </td>
                                        <td>{{ ($py->order)?$py->order->id:'' }}</td>
                                        
                                        <td>
                                        <a href="{{route('admin.customer.show' , $py->customer->id)}}">
                                            {{ $py->customer->name }}
                                        </a>
                                        </td>
                                        <td>{{ number_format((float)($py->total_paid / 100), 2, '.', '') }}</td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        @endif
    </div>
@endsection
