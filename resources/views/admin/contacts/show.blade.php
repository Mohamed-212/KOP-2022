@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Contact US - {{ $contacts->customer->name }}</h1>
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
                    <h3 class="card-title">Contact Details</h3>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Customer Name</label>
                                <input readonly type="text" class="form-control" name="Customer_Name" value="{{ $contacts->customer->name }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Subject</label>
                                <input readonly type="text" class="form-control" name="subject" value="{{ $contacts->subject }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12">
                            <div class="form-group">
                                <label>Message</label>
                                <textarea readonly type="text" class="form-control" name="name_en" value="{{ $contacts->body }}">{{ $contacts->body }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @endsection
