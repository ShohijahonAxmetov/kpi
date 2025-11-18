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
        'name' => 'Добавление',
        'disabled' => true
        ],
        ]
        ])
    </div>
</div> <!-- / .header -->

<!-- CARDS -->
<div class="container-fluid">
    <form method="post" action="{{ route($route_name . '.update', [$route_parameter => ${$route_parameter}]) }}" id="add">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-12">
                <div class="card mw-50">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">

                                <div class="form-group">
                                    <label for="name" class="form-label required">Название</label>
                                    <input type="text" required class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? ${$route_parameter}->name }}" id="name" placeholder="Название...">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="code" class="form-label required">Код</label>
                                    <input type="text" required class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') ?? ${$route_parameter}->code }}" id="code" placeholder="Код...">
                                    @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <!-- Button -->
                        <div class="model-btns d-flex justify-content-end">
                            <a href="{{ route($route_name.'.index') }}" type="button" class="btn btn-secondary">Отмена</a>
                            <button type="submit" class="btn btn-primary ms-2">Сохранить</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
