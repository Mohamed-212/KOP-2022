@extends('layouts.admin.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $user->name }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.reasons-report.index') }}">Back</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">reason Details</h3>
                    </div>
                    <form>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputArabicName">Arabic reason</label>
                                        <input type="text" class="form-control" id="exampleInputArabicName"
                                            value="{{ $reson->reason_ar }}" name="reason_ar" readonly>
                                        @error('reason_ar')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEnglishName">English reason</label>
                                        <input type="text" class="form-control" id="exampleInputEnglishName"
                                            value="{{ $reson->reason_en }}" name="reason_en" readonly>
                                        @error('reason_en')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputArabicDescription">cancellation reason</label>
                                        <textarea class="form-control" id="exampleInputArabicDescription" readonly name="description_ar" rows="7"
                                            cols="4">{{ $user->cancellation_reason }}</textarea>
                                        @error('description_ar')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{-- <button type="button" class="btn btn-primary float-right">Submit</button> --}}
                        </div>
                    </form>
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">change user status</h3>
                    </div>
                    <form action="{{ route('admin.reasons-report.store') }}" method="POST" enctype="multipart/form-data"
                        id="add-category">
                        @csrf
                        <input type="hidden" name="user_id" value="{{$user->id}}" />
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputArabicDescription">user account status</label>
                                        <select class="font-control select2" name="status" id="exampleInputArabicDescription" style="width: 100%">
                                            <option value="0" {{ $user->status ?: 'selected' }}>Deactivate</option>
                                            <option value="1" {{ $user->status ? 'selected' : '' }}>Activate</option>
                                        </select>
                                        @error('status')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script>
        window.onbeforeunload = function() {
            return 'Are you sure? Your work will be lost. ';
        };
        $('.custom-file-input').on('change', function() {
            //get the file name
            var fileName = $(this).val();
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        })


        $('input').change(function(e) {
            // Warning
            $(window).on('beforeunload', function() {
                return "Are you sure you want to navigate away from this page?";
            });

            // Form Submit
            $(document).on("submit", "form", function(event) {
                // disable unload warning
                $(window).off('beforeunload');
            });

        });
    </script>
@endpush
