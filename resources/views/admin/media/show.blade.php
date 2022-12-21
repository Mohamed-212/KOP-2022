@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Media: {{ $media->title_en }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.media.index')}}">Back</a></li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Media Details</h3>
        </div>

          <div class="card-body">
              <div class="row">
                  <div class="col-md-6">
                      <iframe class="w-100" height="250"
                              src="{{asset($media->url)}}?controls=0">
                      </iframe>

                      <img loading="lazy" data-lazy="true"  src="{{$media->img}}" class="img-thumbnail" />
                  </div>
                  <div class="col-md-6">
                      <div class="row">
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label for="title_en">Title English</label>
                                  <input type="text"
                                         class="form-control"
                                         id="title_en" disabled placeholder="Enter Title" value="{{$media->title_en}}">
                              </div>
                          </div>
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label for="title_ar">Title Arabic</label>
                                  <input type="text"
                                         class="form-control "
                                         id="title_ar" disabled placeholder="Enter Title" value="{{$media->title_ar}}">
                              </div>
                          </div>
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label for="author">Author</label>
                                  <input type="text"
                                         class="form-control"
                                         id="author" disabled placeholder="Enter Author Name" value="{{$media->author}}" name="author">
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

      </div>
    </div>
  </section>
</div>
@endsection
