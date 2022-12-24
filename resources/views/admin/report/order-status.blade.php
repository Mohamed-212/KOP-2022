@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Order Status</h1>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="card-body">
        <form method="get">
          <div class="row">
            <div class="col-md-2">
              <div class="form-group">
                <label>Order From</label>
                <select name="order_from"  class="form-control" id="">
                    @foreach(['website', 'mobile'] as $from)
                        <option value="{{ $from }}" @if(request('order_from') == $from) selected @endif>{{ $from }}</option>
                    @endforeach
                </select>
              </div>
            </div>
              <div class="col-md-3">
              <div class="form-group">
                <label>Status</label>
                <select name="state" class="form-control">
                  <option value="all">All</option>
                  <option value="pending" @if(request('state') == 'pending') selected @endif>Pending</option>
                  <option value="rejected" @if(request('state') == 'rejected') selected @endif>Rejected</option>
                  <option value="in-progress" @if(request('state') == 'in-progress') selected @endif>In Progress</option>
                  <option value="completed" @if(request('state') == 'completed') selected @endif>Completed</option>
                  <option value="canceled" @if(request('state') == 'canceled') selected @endif>Calnceled</option>
                </select>
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
                <label>From</label>
                <input type="date" class="form-control" name="to" value="{{ request('to') }}">
              </div>
            </div>
            <div class="col-md-1">
              <div class="form-group">
                <label class="form-label" style="width: 100%;"></label>
                <div class="input-group pull-right">
                    <button type="submit" class="btn btn-primary" style="margin-top: 6px; height: 35px;width: 80%;">Go</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
  @if(!is_null($orders))
    <section class="content">
      <div class="container-fluid">
        <div class="card-body">
          <table class="table table-bordered table-striped dataTable">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Order From</th>
                <th>Total</th>
                <th>Status</th>
                <th>Datetime</th>
              </tr>
            </thead>
            <tbody>
              @foreach($orders as $order)
                <tr>
                  <td>{{$order->id}}</td>
                  <td>{{$order->customer->name}}</td>
                    <td>{{$order->order_from}}</td>
                    <td>{{$order->total}} SR</td>
                  <td>{{$order->state}}</td>
                  <td>{{$order->updated_at->format('Y-m-d H:i:s')}}</td>
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
