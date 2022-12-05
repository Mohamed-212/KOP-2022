@extends('layouts.admin.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>edit reason</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.reasons.index') }}">Back</a></li>
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
                    <form action="{{ route('admin.reasons.update', $reson->id) }}" method="POST" enctype="multipart/form-data"
                        id="add-category">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputArabicName">Arabic reason</label>
                                        <input type="text" class="form-control" id="exampleInputArabicName"
                                            placeholder="Enter Arabic Name" value="{{ old('reason_ar', $reson->reason_ar) }}" name="reason_ar">
                                        @error('reason_ar')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEnglishName">English reason</label>
                                        <input type="text" class="form-control" id="exampleInputEnglishName"
                                            value="{{ old('reason_en', $reson->reason_en) }}" placeholder="Enter English Name" name="reason_en">
                                        @error('reason_en')
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
        window.onbeforeunload = function () {
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
