@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Payment</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url()->previous()}}">Back</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Payment Details</h3>
                </div>
                <div class="card-body">
                    

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Payment ID</label>
                                <input readonly type="text" class="form-control" placeholder="Enter Item Arabic Name" name="name_ar" value="{{ $py->payment_id }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Order ID</label>
                                <input readonly type="text" class="form-control" placeholder="Enter Item English Name" name="name_en" value="{{ $py->order_id }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Customer ID</label>
                                <input readonly type="text" class="form-control" placeholder="Enter Item English Name" name="name_en" value="{{ $py->customer_id }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Total Paid</label>
                                <input readonly type="text" class="form-control" placeholder="Enter Item English Name" name="name_en" value="{{ $py->total_paid }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Created at</label>
                                <input readonly type="text" class="form-control {!! $errors->first('price', 'is-invalid') !!}" placeholder="Enter Item Price" name="price" value="{{ $py->created_at->format('d M Y H:i:sa') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>All Data</label>
                                    <?php
                                        $data = collect(json_decode($py->data, true));

                                        $source = $data->toArray()['source'];
                                    ?>
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        @foreach ($data->toArray() as $key => $val)

                                            <tr>
                                                <td>
                                                    {{$key }}
                                                </td>
                                                <td>
                                                    {{$key === 'source' ? '' : $val}}
                                                </td>
                                            </tr>

                                            @if($key === 'source')
                                                @foreach ($source as $k => $v)
                                                    <tr>
                                                        <td>
                                                            {{$k}}
                                                        </td>
                                                        <td>
                                                            {{$v}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @endsection
