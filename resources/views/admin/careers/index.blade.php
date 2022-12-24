@extends('layouts.admin.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Careers </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.careers.create')}}">Add New Job</a></li>
                        </ol>
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
                            <th>#ID</th>
                            <th>Job Title</th>
                            <th>No. Of Applications</th>
                            <th>Status</th>
                            <th style="text-align: center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($jobs as $index => $job)
                            <tr>
                                <td>{{$index + 1 }}</td>
                                <td>{{ $job->title_en}}</td>
                                <td><a href="{{route('admin.careers.getapp',$job->id)}}">
                                    @php
                                    // dd(\App\Models\JobRequest::toSql());
                                        $req = 0;
                                        $req = \App\Models\JobRequest::where('job_id', $job->id)->count();
                                    @endphp
                                    {{ $req }}
                                </a></td>
                                <td>{{ $job->getStatus() }}</td>
                                <td style="padding: 0;text-align: center;">
                                    <a href="{{ route('admin.careers.show', $job->id) }}"
                                       class="btn btn-primary btn-circle btn-sm" title="Show"><i
                                            class="fa fa-globe"></i></a>
                                    <a href="{{ route('admin.careers.edit', $job->id) }}"
                                       class="btn btn-primary btn-circle btn-sm" title="edit"><i class="fa fa-edit"></i></a>
                                    <a href="{{ route('admin.careers.changestatus', $job->id) }}"
                                       class="btn btn-primary btn-circle btn-sm {{$job->getStatus() == 'Active' ? 'btn-success' : ''}}" title="change status"><i
                                            class="fa fa-lock"></i></a>

                                    <a onclick="deleteJob('{{ 'delete-job-' . $job->id }}')" href="#"
                                       class="btn btn-danger btn-circle btn-sm " title="delete"><i
                                            class="fas fa-trash"></i> </a>
                                    <!-- Form Delete category -->
                                    <form
                                        action="{{ route('admin.careers.delete', $job->id) }}"
                                        method="POST"
                                        id="{{ 'delete-job-' . $job->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <!-- End Delete category -->
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
        function deleteJob(id) {
            event.preventDefault();
            swal({
                title: 'Are you sure to delete this Job ?',
                text: 'Once the Job has been deleted you cannot retrieve its data',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $('#' + id).submit();
                        swal('Job successfully deleted', {
                            icon: 'success',
                        });
                    } else {
                        swal('Job undeleted');
                    }
                });
        }
    </script>
@endpush
