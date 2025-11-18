@extends('layouts.students')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-10">
            <!-- Header -->
            @include('students.components.header', [
            	'active' => 'ielts',
                'title' => __('main.foreign_lang_certificates.title')
            ])
            <!-- Form -->
            <form active="{{route('ielts.store')}}" method="post" enctype="multipart/form-data">
            	@csrf
                <div class="row">
                    <div class="col-12 col-md-6">
                        <!-- Last name -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> @lang('main.foreign_lang_certificates.language') </label>
                            <!-- Input -->
                            <select name="title" class="form-select" required>
                                @foreach($certificateLanguages as $language)
                                    <option value="{{$language->id}}">{{$language->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- Last name -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> @lang('main.foreign_lang_certificates.level') </label>
                            <!-- Input -->
                            <select name="points" class="form-select" required>
                                @foreach($certificatePoints as $point)
                                    <option value="{{$point->id}}">{{$point->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- First name -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> @lang('main.foreign_lang_certificates.file') </label>
                            <!-- Input -->
                            <input name="file" required type="file" class="form-control" placeholder="Файл">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- Last name -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> @lang('main.foreign_lang_certificates.date') </label>
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
            <h3 class="mt-5">@lang('main.foreign_lang_certificates.title')</h3>
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">@lang('main.foreign_lang_certificates.language')</th>
                    <th scope="col">@lang('main.foreign_lang_certificates.level')</th>
                    <th scope="col">@lang('main.foreign_lang_certificates.date')</th>
                    <th scope="col">@lang('main.foreign_lang_certificates.file')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($certificates as $certificate)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$certificate->certificate_language->name}}</td>
                        <td>{{$certificate->certificate_point->name}}</td>
                        <td>{{$certificate->date}}</td>
                        <td><a href="{{asset($certificate->file_path)}}">@lang('main.upload')</a></td>
                        <td>
                            <form action="{{route('ielts.destroy', ['certificate' => $certificate])}}" method="post">
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
