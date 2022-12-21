@extends('layouts.website.app')

@section('title')
    {{ __('general.Careers') }}
@endsection

@section('styles')
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> --}}
    <style>
        .accordion-button:after {
            content: "\f067" !important;
        }
        .accordion-button:not(.collapsed):after {
            content: "\f068" !important;
        }
        .text-danger {
            color: #f32129;
        }

        .help-block {
            font-size: .85rem;
        }
    </style>
@endsection

@section('pageName')

    <body class="page-home dm-dark">
    @endsection

    @section('content')
        <main class="page-main">
            <section class="page-header"
            style="background-image: url('{{asset('/website2-assets/img/page-header-theme.jpg')}}')">
                <div class="bg-shape grey"></div>
                <div class="container">
                    <div class="page-header-content">
                        <h4>{{ __('general.Job Information') }}</h4>
                        <h2>{!! __('general.carrer_title') !!}</h2>
                    </div>
                </div>
            </section>
            <!--/.page-header-->

            <section class="blogs-section bg-grey padding">
                <div class="bg-shape white"></div>
                <div class="container">
                    <div class="row">
                        

                        <div class="col-md-8">
                            <div class="accordion accordion-flush" id="accordionPanelsStayOpenExample">
                                @foreach ($jobs as $job)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="panelsStayOpen-heading{{ $job->id }}">
                                            <button
                                                class="accordion-button @unless($loop->first) collapsed @endif"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-collapse{{ $job->id }}"
                                                aria-expanded="false"
                                                aria-controls="panelsStayOpen-collapse{{ $job->id }}">
                                                <div class="d-flex justify-content-between align-items-center flex-wrap"
                                                    style="width: 90%;">
                                                    <div>
                                                        {{ $job['title_' . app()->getLocale()] }}
                                                    </div>
                                                    <div class="badge badge-primary">
                                                        <i class="fas fa-clock mx-1"></i>
                                                        {{ $job->created_at }}
                                                    </div>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-collapse{{ $job->id }}"
                                            class="accordion-collapse collapse @if ($loop->first) show @endif"
                                            aria-labelledby="panelsStayOpen-heading{{ $job->id }}">
                                            <div class="accordion-body">
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-body pb-0">
                                                            <h5 class="card-title">
                                                                {{ __('general.Description') }}:
                                                            </h5>
                                                            <h6 class="card-subtitle mb-2 text-muted"
                                                                style="font-size: .75rem;">
                                                                {{ $job['brief_description_' . app()->getLocale()] }}
                                                            </h6>
                                                            <p class="card-text text-sm px-2"
                                                                style="
                                                    color: #625b52;">
                                                            <ol class="list-group list-group-flush list-group-numbered"
                                                                style="font-size: .8rem;">
                                                                @foreach (explode("\r\n", $job['description_' . app()->getLocale()]) as $desc)
                                                                    <li class="list-group-item"
                                                                        style="padding: 0.2rem 1rem;">
                                                                        {{ $desc }}
                                                                    </li>
                                                                @endforeach
                                                            </ol>
                                                            </p>
                                                        </div>

                                                        <div class="card-body mt-0 pt-0">
                                                            <h5 class="card-title text-capitalize">
                                                                {{ __('general.responsibilities') }}:
                                                            </h5>
                                                            <p class="card-text text-sm px-2"
                                                                style="font-size: .85rem;
                                                    color: #625b52;">
                                                            <ol class="list-group list-group-flush list-numbered"
                                                                style="font-size: .85rem;">
                                                                @foreach (explode("\r\n", $job['responsibilities_' . app()->getLocale()]) as $res)
                                                                    <li class="list-group-item"
                                                                        style="padding: 0.2rem 1rem;">
                                                                        {{ $res }}
                                                                    </li>
                                                                @endforeach
                                                            </ol>
                                                            {{-- {{ $job['responsibilities_' . app()->getLocale()] }} --}}
                                                            </p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-4 position-relative">
                            <div>
                                <div class="card card-primary position-sticky" style="top:25%">
                                    <div class="card-header bg-primary">
                                        <h3 class="card-title text-white">{{ __('general.Apply') }}</h3>
                                    </div>
                                    <form method="post" action="{{ route('career.request') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">
                                            <div class="row mb-2">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        {{-- <label class="form-label" for="job_id"></label> --}}
                                                        <select class="select form-control"
                                                            data-placeholder="{{ __('general.Careers') }}" style="width: 100%;"
                                                            name="job_id">
                                                            @foreach ($jobs as $job)
                                                                <option value="{{ $job->id }}">
                                                                    {{ $job['title_' . app()->getLocale()] }}</option>
                                                            @endforeach
                                                        </select>
                                                        {!! $errors->first('roles', '<p class="help-block">:message</p>') !!}
    
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        {{-- <label class="form-label" for="name"></label> --}}
                                                        <input type="text" class="form-control " id="name"
                                                            placeholder="{{ __('general.Name') }}" name="name" required>
                                                        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        {{-- <label class="form-label" for="phone"> </label> --}}
                                                        <input type="text" class="form-control {!! $errors->first('phone', 'is-invalid') !!}"
                                                            id="phone" placeholder="{{ __('general.Mobile') }}"
                                                            name="phone" pattern="[0-9]+" required>
                                                    </div>
    
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        {{-- <label class="form-label" for="email"></label> --}}
                                                        <input type="email" class="form-control" id="email"
                                                            placeholder="{{ __('general.Email') }}" name="email" required>
                                                        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    
                                                    </div>
                                                </div>
                                            </div>
    
                                            
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        {{-- <label class="form-label" for="description"> </label> --}}
                                                        <textarea name="description" class="form-control" rows="3" cols="20"
                                                            placeholder="{{ __('general.Details') }}">{{ old('description') }}</textarea>
                                                        @error('description')
                                                            <div class="help-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
    
                                                </div>
                                            </div>
                                            <div class="row my-2">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="mb-3 d-flex align-items-center">
                                                            <label for="cv_file" class="form-label px-1">C.V</label>
                                                            <input class="form-control" type="file" name="cv_file"
                                                                id="cv_file">
                                                        </div>
                                                        @error('cv_file')
                                                            <div class="help-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div class="row">
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-default btn-sm default-btn rounded">
                                                        {{ __('general.SUBMIT') }}
                                                        <span></span>
                                                    </button>
                                                </div>
                                            </div>
                                    </form>
                                </div>
                            </div>
                            </div>

                            <div class="card card-primary" style="border: none;background: transparent;">
                                <div class="row" style="margin-top: 1rem">
                                    <div class="col-12 d-flex align-items-center justify-content-center">
                                        @if (Session::has('success'))
                                            <div class="row mr-2 ml-2">
                                                <div class="alert alert-success mb-2">{{ Session::get('success') }}
                                                </div>
                                            </div>
                                        @endif
                                        @if (Session::has('error'))
                                            <div class="row mr-2 ml-2">
                                                <div class="alert alert-danger mb-2">{{ Session::get('error') }}
                                                </div>
                                            </div>
                                        @endif

                                        {{-- <div class="row mr-2 ml-2">
                                            <div class="alert alert-success mb-2">wasd asd asdas dasdasd asd
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </main>
    @endsection

    @section('scripts')
    @endsection
