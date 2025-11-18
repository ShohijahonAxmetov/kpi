@extends('layouts.students')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-10">
            <!-- Header -->
            <div class="header mt-md-5">
                <div class="header-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <!-- Pretitle -->
                            <!-- <h6 class="header-pretitle"> Overview </h6> -->
                            <!-- Title -->
                            <h1 class="header-title"> @lang('main.profile.title') </h1>
                        </div>
                    </div>
                    <!-- / .row -->
                </div>
            </div>
            <!-- Form -->
            <form action="{{route('students.update')}}" method="post">
                @csrf
                @method('put')
                <div class="row justify-content-between align-items-center mb-3 ">
                    <div class="col">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <!-- Avatar -->
                                <div class="avatar">
                                    <img class="avatar-img rounded-circle" src="/assets/img/avatars/profiles/default_user.png" alt="...">
                                </div>
                            </div>
                            <div class="col ms-n2">
                                <!-- Heading -->
                                <h4 class="mb-1"> @lang('main.profile.your_avatar') </h4>
                                <!-- Text -->
                                <small class="text-muted"> @lang('main.profile.avatar_size') </small>
                            </div>
                        </div>
                        <!-- / .row -->
                    </div>
                    <div class="col-auto">
                        <!-- Button -->
                        <button class="btn btn-sm btn-primary" disabled> @lang('main.profile.upload') </button>
                    </div>
                </div>
                <!-- / .row -->
                <div class="row">
                    <div class="col-12">
                        <p>@lang('main.profile.total'): <span>{{$total}}</span></p>
                    </div>
                </div>
                <!-- Divider -->
                <hr class="my-5">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <!-- First name -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> @lang('main.profile.name') </label>
                            <!-- Input -->
                            <input type="text" name="name" value="{{auth()->user()->name}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- Last name -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> @lang('main.profile.surname') </label>
                            <!-- Input -->
                            <input type="text" name="surname" value="{{auth()->user()->surname}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <!-- Email address -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="mb-1"> @lang('main.profile.third_name') </label>
                            <!-- Input -->
                            <input type="text" name="father_name" value="{{auth()->user()->father_name}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- Phone -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> @lang('main.profile.username') </label>
                            <!-- Input -->
                            <input type="text" disabled value="{{auth()->user()->passport_number}}" required class="form-control mb-3">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- Birthday -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> @lang('main.profile.password') </label>
                            <!-- Input -->
                            <input type="password" name="password" class="form-control">
                        </div>
                    </div>
                </div>
                <!-- / .row -->
                <!-- Button -->
                <button class="btn btn-primary"> @lang('main.profile.save_changes') </button>
                <!-- / .row -->
            </form>
            <br>
            <br>
        </div>
    </div>
    <!-- / .row -->
</div>

@endsection