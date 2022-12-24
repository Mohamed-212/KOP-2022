@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Items</h1>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="card-body">
          <form method="get">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                    <label>Select Category</label>
                    <select class="form-control" name="category">
                      <option value="all">All</option>
                      @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if(request('category') == $category->id) selected @endif >{{$category->name_en}}</option>
                      @endforeach
                    </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>From</label>
                  <input type="date" class="form-control" name="from" value="{{ request('from') }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>To</label>
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
  @if(!is_null($items))
    <section class="content">
      <div class="container-fluid">
        <div class="card-body">
          <table class="table table-bordered table-striped dataTable">
            <thead>
              <tr>
                <th>Category</th>
                <th>Item</th>
                <th>Price</th>
                <th>Calories</th>
                <th>Datetime</th>
              </tr>
            </thead>
            <tbody>
              @foreach($items as $item)
                <tr>
                  <td>{{$item->category->name_en}}</td>
                  <td>{{$item->name_en}}</td>
                  <td>{{$item->price}}</td>
                  <td>{{$item->calories}}</td>
                  <td>{{$item->created_at->format('Y-m-d H:i:s')}}</td>
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
