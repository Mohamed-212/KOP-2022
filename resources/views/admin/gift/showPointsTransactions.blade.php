@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Points Transactions</h1>
                </div>
                <div class="col-sm-6">
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
                            {{-- <th>ID</th> --}}
                            {{-- <th>Points</th> --}}
                            <th class="text-center">Users</th>
                            {{-- <th>Status</th> --}}
                            <th class="text-center">Points Transactions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as  $transaction)
                        <tr>
                            <!--
                            <td>{{$transaction->id}}</td>
                            <td><span style="color:<?php if ($transaction->points < 0) echo "red"; else echo "green"; ?>">{{$transaction->points > 0 ? "+" : ""}}{{$transaction->points}}</span></td> -->
                            <td align="center">{{$transaction->user->name}}</td>
                            <td align="center">
                                <a class="btn btn-primary" href="{{  route('admin.showPointsTransactionsForUser', $transaction->user->id) }}"><i class="fas fa fa-eye"></i></a>
                            </td>
                            <!-- <td>
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
                            </td> --->
                            {{-- <td>{{$transaction->created_at->format('d-m-Y g:i A')}}</td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection
