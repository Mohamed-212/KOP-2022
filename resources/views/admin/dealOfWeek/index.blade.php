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
            <form method=get>
                <div class="row card-body">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>category</label>
                            <select class="form-control" name="category">
                                <option value="all">All</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if(request('category')==$category->id) selected @endif>
                                    {{ $category['name_'.app()->getLocale()] }}
                                </option>
                                @endforeach
                            </select>
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
            <div class="card-body">
                <table class="table table-bordered table-striped dataTable">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Category Name</th>
                            <th>Name En</th>
                            <th>Name Ar</th>
                            <th>Price</th>
                            <th>Deal Of Week</th>
                            <th>Image</th>
                            <th style="text-align: center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>@if(isset($item->category['name_'.app()->getLocale()])) {{$item->category['name_'.app()->getLocale()]}} @endif</td>
                            <td>{{ $item->name_ar }}</td>
                            <td>{{ $item->name_en }}</td>
                            <td>{{ $item->price }} SR</td>
                            <td>
                                <a href="" data_id="{{$item->id}}"  class="status btn {{($item->best_seller == 'activate')?'btn-danger':'btn-success'}} btn-circle">{{($item->best_seller == 'activate')?'deactivate':'activate'}}</a>
                            </td>
                            <td><img loading="lazy" data-lazy="true"  src="{{ $item->image }}" class="img-thumbnail"  style="max-width: 80px" /></td>
                            <td style="padding: 0;text-align: center;">
                                <a href="{{ route('admin.item.show', $item->id) }}" class="btn btn-primary btn-circle btn-sm" title="Show"><i class="fa fa-globe"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection
@push('js')
<script type="text/javascript">
    window.onload = function() {
        $(document).on('click','.status',function (e){
            e.preventDefault();
            let app_url = '{{ url('/') }}';
            let itemId = $(this).attr('data_id');
            let element = $(this);
            $.ajax({
                type:'get',
                url:app_url + "/deal-of-week/status/" + itemId,
                data:{},
                success:function (data){
                    if(data.message === 'success')
                    {
                        element.html();
                        element.removeClass('btn-danger');
                        element.removeClass('btn-success');
                        if(data.data == 'deactivate'){
                            element.html('activate');
                            element.addClass('btn-success');
                        }
                        else {
                            element.html('deactivate');
                            element.addClass('btn-danger');
                        }
                    }
                },
                error:function (reject){
                }
            })
        });
    };
</script>
@endpush
