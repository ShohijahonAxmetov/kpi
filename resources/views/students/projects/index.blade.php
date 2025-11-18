@extends('layouts.students')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-10">
            <!-- Header -->
            @include('students.components.header', [
            	'active' => 'projects',
                'title' => __('main.projects.title')
            ])
            <!-- Form -->
            <form active="{{route('projects.store')}}" method="post" enctype="multipart/form-data">
            	@csrf
                <div class="row">
                    <div class="col-12 col-md-6">
                        <!-- First name -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> @lang('main.projects.name') </label>
                            <!-- Input -->
                            <input name="title" value="{{old('title')}}" type="text" class="form-control" placeholder="@lang('main.projects.name')">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- Last name -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> @lang('main.projects.date') </label>
                            <!-- Input -->
                            <input name="date" value="{{old('date')}}" type="date" class="form-control">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- First name -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> @lang('main.projects.file') </label>
                            <!-- Input -->
                            <input name="file" required type="file" class="form-control">
                        </div>
                    </div>
                </div>
                <!-- / .row -->
                <!-- Button -->
                <button class="btn btn-primary"> @lang('main.save') </button>
                <!-- / .row -->
            </form>
            <br>
            <h3 class="mt-5">@lang('main.projects.title')</h3>
            <table class="table table-sm table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">@lang('main.projects.name')</th>
                    <th scope="col">@lang('main.projects.date')</th>
                    <th scope="col">@lang('main.projects.file')</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($projects as $project)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$project->title}}</td>
                        <td>{{$project->date}}</td>
                        <td><a href="{{asset($project->file_path)}}">@lang('main.upload')</a></td>
                        <td>
                            <form action="{{route('projects.destroy', ['project' => $project])}}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger">x</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- / .row -->
</div>

@endsection
