@extends('layouts.students')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-10">
            <!-- Header -->
            @include('students.components.header', [
            	'active' => 'tests',
                'title' => __('main.test.title')
            ])
            <!-- Form -->
            @if(auth()->user()->tests_points == 0)
            <form active="{{route('tests.store')}}" method="post" enctype="multipart/form-data">
            	@csrf
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link me-4 active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Билимларни текшириш</button>
                        <button class="nav-link me-4" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Малака бўйича тестлар</button>
                        <button class="nav-link me-4" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Маҳорат тести</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="py-5">
                            @foreach($tests[0] as $order => $test)
                            <div class="test-block mb-5">
                                <p class="h3">{{$order+1}}. {{$test['question']}}</p>
                                <div class="options">
                                    @foreach($test['options'] as $optionOrder => $option)
                                    <div class="form-check form-check-block">
                                        <input class="form-check-input" required type="radio" name="answers[1][{{$optionOrder+1}}]" id="inlineRadio{{$optionOrder+1}}" value="A">
                                        <label class="form-check-label" for="inlineRadio{{$optionOrder+1}}">{{$option}}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="py-5">
                            @foreach($tests[1] as $order => $test)
                            <div class="test-block mb-5">
                                <p class="h3">{{$order+1}}. {{$test['question']}}</p>
                                <div class="options">
                                    @foreach($test['options'] as $optionOrder => $option)
                                    <div class="form-check form-check-block">
                                        <input class="form-check-input" required type="radio" name="answers[2][{{$optionOrder+1}}]" id="inlineRadio{{$optionOrder+1}}" value="A">
                                        <label class="form-check-label" for="inlineRadio{{$optionOrder+1}}">{{$option}}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <div class="py-5">
                            @foreach($tests[2] as $order => $test)
                            <div class="test-block mb-5">
                                <p class="h3">{{$order+1}}. {{$test['question']}}</p>
                                <div class="options">
                                    @foreach($test['options'] as $optionOrder => $option)
                                    <div class="form-check form-check-block">
                                        <input class="form-check-input" required type="radio" name="answers[3][{{$optionOrder+1}}]" id="inlineRadio{{$optionOrder+1}}" value="A">
                                        <label class="form-check-label" for="inlineRadio{{$optionOrder+1}}">{{$option}}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- / .row -->
                <!-- Button -->
                <button class="btn btn-primary mb-5"> Сохранить </button>
                <!-- / .row -->
            </form>
            @else
                <p>Ваш результат: {{auth()->user()->tests_points}}/15</p>
            @endif
        </div>
    </div>
    <!-- / .row -->
</div>

@endsection