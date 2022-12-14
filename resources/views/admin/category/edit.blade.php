@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.category.index')}}">Back</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Category Details</h3>
                </div>
                <form action="{{ route('admin.category.update' , $category->id) }}" method="POST"
                    enctype="multipart/form-data" id="add-category">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputArabicName">Arabic Name</label>
                                    <input type="text" class="form-control" id="exampleInputArabicName"
                                        placeholder="Enter Arabic Name" name="name_ar" value="{{$category->name_ar}}">
                                    @error('name_ar')
                                    <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEnglishName">English Name</label>
                                    <input type="text" class="form-control" id="exampleInputEnglishName"
                                        placeholder="Enter English Name" name="name_en" value="{{$category->name_en}}">
                                    @error('name_en')
                                    <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputArabicDescription">Arabic Description</label>
                                    <textarea class="form-control" id="exampleInputArabicDescription"
                                        placeholder="Enter Arabic Description"
                                        name="description_ar">{{$category->description_ar}}</textarea>
                                    @error('description_ar')
                                    <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEnglishDescription">English Description</label>
                                    <textarea class="form-control" id="exampleInputEnglishDescription"
                                        placeholder="Enter English Description"
                                        name="description_en">{{$category->description_en}}</textarea>
                                    @error('description_en')
                                    <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                @if (auth()->user()->hasRole('admin'))
                                <div class="form-group">
                                    <label for="exampleInputRole">Hide In</label>
                                    <select class="select2" multiple="multiple" data-placeholder="Select a Branch" style="width: 100%;" name="branches[]">
                                        @foreach($userBranches as $userBranch)
                                        @if(in_array($userBranch->id, $itemBranches))
                                        <option value="{{ $userBranch->id }}" selected>{{ $userBranch->name_en }}</option>
                                        @else
                                        <option value="{{ $userBranch->id }}">{{ $userBranch->name_en }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="pl-3 card-title mb-2">
                                    <b>Dough</b>
                                </div>
                                <div class="card-body">
                                    @foreach ($doughTypes->groupBy('dough_type_id') as $doughGroup)
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" name="dough_type{{$loop->index > 0 ? '_2' : ''}}_id" type="checkbox"
                                                    value="{{ $doughGroup->first()->dough_type_id }}"
                                                    id="flexCheckDefault{{ $doughGroup->first()->dough_type_id }}" @if($category->dough_type_id === $doughGroup->first()->dough_type_id) checked @endif>
                                                <label class="form-check-label"
                                                    for="flexCheckDefault{{ $doughGroup->first()->dough_type_id }}">
                                                    ({{ $doughGroup->first()->name_en }} -
                                                    {{ $doughGroup->first()->name_ar }},
                                                    {{ $doughGroup->last()->name_en }} -
                                                    {{ $doughGroup->last()->name_ar }})
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="dough_type_id">Dough Type</label>
                                    <select class="form-control" name="dough_type_id">
                                        @if($category->dough_type_id == 0)
                                        <option selected value=0>مشروبات</option>
                                        <option value=1>غير المعجنات</option>
                                        <option value=2>معجنات</option>
                                        @elseif($category->dough_type_id == 1)
                                        <option value=0>مشروبات</option>
                                        <option selected value=1>غير معجنات</option>
                                        <option value=2>معجنات</option>
                                        @else
                                        <option value=0>مشروبات</option>
                                        <option value=1>غير معجنات</option>
                                        <option selected value=2>معجنات</option>
                                        @endif

                                    </select>
                                    @error('dough_type_id')
                                    <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputFile">Image</label>
                                    <img src="{{ $category->image }}" class="mg-fluid img-thumbnail"
                                        style="max-width: 75px"></td>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile" name="image">
                                        @error('image')
                                        <div class="help-block">{{ $message }}</div>
                                        @enderror
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
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
    
    $( document ).ready(function() {

        $('.custom-file-input').on('change',function(){

            //get the file name
            var fileName = $(this).val();

            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        })

        $('input').change(function (e) {
        // Warning
        $(window).on('beforeunload', function(){
            return "Are you sure you want to navigate away from this page?";
        });

        // Form Submit
        $(document).on("submit", "form", function(event){
            // disable unload warning
            $(window).off('beforeunload');
        });

    });

    });
</script>
@endpush
