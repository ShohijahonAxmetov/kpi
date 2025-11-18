@extends('layouts.students')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-10">
            <!-- Header -->
            @include('students.components.header', [
            	'active' => 'scholarships',
                'title' => __('main.scholarships.title')
            ])
            <!-- Form -->
            <form active="{{route('scholarships.store')}}" method="post" enctype="multipart/form-data">
            	@csrf
                <div class="row">
                    <div class="col-12 col-md-6">
                        <!-- First name -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> @lang('main.scholarships.president') </label>
                            <!-- Input -->
                            <input name="president" type="file" class="form-control">
                            @if(auth('students')->user()->scholarships()->whereNotNull('president')->first())
                            <small><a href="{{auth('students')->user()->scholarships()->whereNotNull('president')->first()->president_path}}">@lang('main.scholarships.download')</a></small>
                            <small><button type="submit" class="text-danger border-0 bg-transparent" form="president_destroy">@lang('main.scholarships.remove')</button></small>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- Last name -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> @lang('main.scholarships.beruni') </label>
                            <!-- Input -->
                            <input name="beruniy" type="file" class="form-control">
                            @if(auth('students')->user()->scholarships()->whereNotNull('beruniy')->first())
                            <small class="me-2"><a href="{{auth('students')->user()->scholarships()->whereNotNull('beruniy')->first()->beruniy_path}}">@lang('main.scholarships.download')</a></small>
                            <small><button type="submit" class="text-danger border-0 bg-transparent" form="beruniy_destroy">@lang('main.scholarships.remove')</button></small>
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                        <!-- Email address -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="mb-1"> @lang('main.scholarships.grant') </label>
                            <!-- Input -->
                            <input name="grant" type="file" class="form-control">
                            @if(auth('students')->user()->scholarships()->whereNotNull('grant')->first())
                            <small><a href="{{auth('students')->user()->scholarships()->whereNotNull('grant')->first()->grant_path}}">@lang('main.scholarships.download')</a></small>
                            <small><button type="submit" class="text-danger border-0 bg-transparent" form="grant_destroy">@lang('main.scholarships.remove')</button></small>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- / .row -->
                <!-- Button -->
                <button class="btn btn-primary"> @lang('main.save') </button>
                <!-- / .row -->
            </form>
            <form action="{{route('scholarships.destroy', ['document' => 'beruniy'])}}" id="beruniy_destroy" method="post">
                @csrf
                @method('delete')
            </form>
            <form action="{{route('scholarships.destroy', ['document' => 'grant'])}}" id="grant_destroy" method="post">
                @csrf
                @method('delete')
            </form>
            <form action="{{route('scholarships.destroy', ['document' => 'president'])}}" id="president_destroy" method="post">
                @csrf
                @method('delete')
            </form>
            <br>
        </div>
    </div>
    <!-- / .row -->
</div>

@endsection