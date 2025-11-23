@extends('layouts.app')

@section('content')
<!-- HEADER -->
<div class="header">
    <div class="container-fluid">

        <!-- Body -->
        <div class="header-body">
            <div class="row align-items-end">
                <div class="col">

                    <!-- Title -->
                    <h1 class="header-title">
                        {{ $title }}
                    </h1>

                </div>
            </div> <!-- / .row -->
        </div> <!-- / .header-body -->
        @include('app.components.breadcrumb', [
        'datas' => [
        [
        'active' => false,
        'url' => route($route_name.'.index'),
        'name' => $title,
        'disabled' => false
        ],
        [
        'active' => true,
        'url' => '',
        'name' => "Tahrirlash",
        'disabled' => true
        ],
        ]
        ])
    </div>
</div> <!-- / .header -->

<!-- CARDS -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card mw-50">
                <div class="card-body">
                    <h2 class="card-title mb-4">Ariza ma'lumotlari</h2>
                    <div class="row">
                        <div class="col-12">

                            <table class="table table-striped table-bordered">
                              <tbody>
                                <tr>
                                  <th scope="row">O'qituvchi FIOsi</th>
                                  <td>{{$application->student->name}}</td>
                                </tr>
                                <tr>
                                  <th scope="row">Mezon</th>
                                  <td>{{ $application->criterion->name }}</td>
                                </tr>
                                <tr>
                                  <th scope="row">Yuklangan ma'lumot turi</th>
                                  <td>{{ $application->criterionItem->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                  <th scope="row">Asos (hujjat, fayl)</th>
                                  <td>
                                        @if($application->basis)
                                            <a href="/upload/files/{{$application->basis}}" target="_blank">@lang('main.upload')</a>
                                        @else
                                            -
                                        @endif
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Izoh</th>
                                  <td>{{ $application->comment }}</td>
                                </tr>
                                <tr>
                                  <th scope="row">Holati</th>
                                  <td>
                                        @if($application->status == 1)
                                        Yangi
                                        @elseif($application->status == 10)
                                        Ko'rib chiqildi
                                        @endif
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Berilgan ball</th>
                                  <td>{{ $application->score ?? '-' }}</td>
                                </tr>
                                <tr>
                                  <th scope="row">Kelib tushgan vaqti</th>
                                  <td>{{ $application->created_at }}</td>
                                </tr>

                              </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card mw-50">
                <div class="card-body">
                    <form method="POST" action="{{route('admin.applications.update', ['application' => $application])}}">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-12">

                                <div class="form-group">
                                    <!-- Label -->
                                    <label class="form-label required"> Beringan ball (max ball: {{$application->criterionItem->max_score ?? $application->criterion->max_score}}) </label>
                                    <!-- Input -->
                                    <input name="score" value="{{old('score', $application->score)}}" required type="text" class="form-control" placeholder="Ballni kiriting...">
                                </div>

                                <div class="form-group">
                                    <!-- Label -->
                                    <label class="form-label required"> Izoh </label>
                                    <!-- Input -->
                                    <textarea required name="answer" rows="4" class="form-control" placeholder="Izoh...">{{old('answer', $application->answer)}}</textarea>
                                </div>

                            </div>
                        </div>
                        <!-- / .row -->
                        <!-- Button -->
                        <button class="btn btn-primary" type="submit"> @lang('main.save') </button>
                        <!-- / .row -->
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection