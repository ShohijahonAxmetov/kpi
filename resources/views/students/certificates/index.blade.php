@extends('layouts.students')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-10">
            <!-- Header -->
            @include('students.components.header', [
            	'active' => 'certificates',
                'title' => __('main.certificates.title')
            ])
            <!-- Form -->
            <form active="{{route('certificates.store')}}" method="post" enctype="multipart/form-data">
            	@csrf
                <div class="row">
                    <div class="col-12 col-md-6">
                        <!-- Last name -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> @lang('main.certificates.type') </label>
                            <!-- Input -->
                            <select name="type" class="form-select" required>
                                <option value="1">Dastur sertifikati</option>
                                <option value="2">MB guvohnomasi</option>
                                <option value="3">Patent sertifikati</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- First name -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> @lang('main.certificates.work_name') </label>
                            <!-- Input -->
                            <input name="title" value="{{old('title')}}" required type="text" class="form-control" placeholder="@lang('main.certificates.work_name')">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- First name -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> @lang('main.certificates.file') </label>
                            <!-- Input -->
                            <input name="file" required type="file" class="form-control" placeholder="Файл">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- Last name -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> @lang('main.certificates.date') </label>
                            <!-- Input -->
                            <input name="date" value="{{old('date')}}" required type="date" class="form-control">
                        </div>
                    </div>
                </div>
                <!-- / .row -->
                <!-- Button -->
                <button class="btn btn-primary"> @lang('main.save') </button>
                <!-- / .row -->
            </form>
            <br>
            <h3 class="mt-5">@lang('main.certificates.title')</h3>
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">@lang('main.certificates.work_name')</th>
                    <th scope="col">@lang('main.certificates.date')</th>
                    <th scope="col">@lang('main.certificates.type')</th>
                    <th scope="col">@lang('main.certificates.file')</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($certificates as $certificate)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$certificate->title}}</td>
                        <td>{{$certificate->date}}</td>
                        <td>{{$certificate->type_string}}</td>
                        <td><a href="{{asset($certificate->file_path)}}">@lang('main.upload')</a></td>
                        <td>
                            <form action="{{route('certificates.destroy', ['certificate' => $certificate])}}" method="post">
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
