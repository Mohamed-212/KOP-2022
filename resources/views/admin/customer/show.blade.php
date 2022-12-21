@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Customer</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.customer.index')}}">Back</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Personal information</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputFirstName">First Name</label>
                                <input readonly type="text" class="form-control" name="first_name" value="{{$customer->first_name}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputMiddleName">Middle Name</label>
                                <input readonly type="text" class="form-control" name="middle_name" value="{{$customer->middle_name}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputLastName">Last Name</label>
                                <input readonly type="text" class="form-control" name="last_name" value="{{$customer->last_name}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail">Email</label>
                                <input readonly type="email" class="form-control" name="email" value="{{$customer->email}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_phone">Primary Phone</label>
                                <input readonly type="text" class="form-control" name="first_phone" value="{{$customer->first_phone}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="socond_phone">Secondary Phone</label>
                                <input readonly type="text" class="form-control" name="second_phone" value="{{$customer->second_phone}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputFile">Image</label>
                                @if ($customer->image)
                                <img loading="lazy" data-lazy="true"  src="{{ $customer->image }}" class="img-thumbnail " style="width: 120px"/>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Address Details</h3>
                                </div>
                                <div class="card-body">
                                    @foreach ($addresses as $address)
                                    <div class="card">
                                        <div class="container">
                                            <div class="card-body">

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Name</label>
                                                            <input readonly type="text" class="form-control" value="{{ $address->name }}" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>City</label>
                                                            <input readonly type="text" class="form-control" value="{{ $address->city->name_ar }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Area</label>
                                                            <input readonly type="text" class="form-control" value="{{ $address->area->name_ar}}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Street</label>
                                                            <input readonly type="text" class="form-control" value="{{ $address->street }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Building Number</label>
                                                            <input readonly type="text" class="form-control" value={{ $address->building_number}}>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Floor Number</label>
                                                            <input readonly type="text" class="form-control" value="{{ $address->floor_number }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Landmark</label>
                                                            <input readonly type="text" class="form-control" value="{{ $address->landmark }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Loyalty Points Details (<b>{{$customer->points_transactions->sum('points')}} Points</b>)</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped dataTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Points</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($customer->points_transactions as  $transaction)
                            <tr>
                                <td>{{$transaction->id}}</td>
                                <td><span style="color:<?php if ($transaction->points < 0) echo "red"; else echo "green"; ?>">{{$transaction->points > 0 ? "+" : ""}}{{$transaction->points}}</span></td>
                                <td>
                                    <?php 
                                        if ($transaction->status == 0) {
                                            echo "<span class='badge badge-success'>Valid<span>";
                                        } else if ($transaction->status == 1) {
                                            echo "<span class='badge badge-danger'>Expired<span>"; 
                                        } else if ($transaction->status == 2) {
                                            echo "<span class='badge badge-danger'>Consumed<span>"; 
                                        } else if ($transaction->status == 3) {
                                            echo "<span class='badge badge-success'>Refunded<span>"; 
                                        } else if ($transaction->status == 4) {
                                            echo "<span class='badge badge-danger'>Order Cancelled<span>"; 
                                        }
                                    ?>
                                </td>
                                <td>{{$transaction->created_at->format('d-m-Y g:i A')}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection
