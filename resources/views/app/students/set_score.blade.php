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
                    <h2 class="card-title mb-4">O'qituvchi ma'lumotlari</h2>
                    <form method="POST" action="{{route('admin.students.set_score.update', ['student' => $student])}}">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-12">

                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Mezon</th>
                                            <th scope="col">Ball</th>
                                            <th scope="col">Izoh</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                    @foreach($criterionMainCategories as $criterionMainCategory)
                                        <tr>
                                          <th scope="row" colspan="3">{{$criterionMainCategory->name}}</th>  
                                        </tr>
                                        @foreach($criterionMainCategory->criterionCategories as $criterionCategory)
                                            <tr>
                                              <th class="ps-4" colspan="3">- {{$criterionCategory->name}}</th> 
                                            </tr>
                                            @foreach($criterionCategory->criterions->where('entered_manually', 0) as $criterion)
                                                @php
                                                    $application = \App\Models\Application::where(['student_id' => $student->id, 'criterion_id' => $criterion->id])->first();
                                                @endphp
                                                <tr>
                                                  <th class="ps-5">-- {{$criterion->name}}</th>
                                                  <td>
                                                    <div class="d-flex align-items-center">
                                                        <input name="data[{{$criterion->id}}][score]" value="{{old('data.'.$criterion.'.score', $application->score ?? '')}}" required type="number" class="form-control" placeholder="...">/{{$criterion->max_score}}
                                                    </div>
                                                  </td>
                                                  <td>
                                                      <textarea required name="data[{{$criterion->id}}][comment]" rows="4" class="form-control" placeholder="Izoh...">{{old('data.'.$criterion.'.comment', $application->answer ?? '')}}</textarea>
                                                  </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                  </tbody>
                                </table>

                            </div>
                        </div>
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