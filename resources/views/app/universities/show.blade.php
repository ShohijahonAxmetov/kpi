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
    <div class="row">
        <div class="col-12">
            <div class="card mw-50">
                <div class="card-body">
                    <h2 class="card-title mb-4">Основная информация</h2>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="title" class="form-label required">Заголовок</label>
                                <input type="text" required class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? $university->title }}" id="title" placeholder="Заголовок...">
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="region" class="form-label required">Где расположен (регион)</label>
                                <select required class="form-control mb-4 @error('region') is-invalid @enderror" name="region" id="region_input">
                                    @foreach ($regions as $key => $item)
                                    <option value="{{ $item->id }}" {{ old('region', $university->region_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('region')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="district" class="form-label required">Где расположен (район)</label>
                                <select required class="form-control mb-4 @error('district') is-invalid @enderror" name="district" id="district_input">
                                    <option value="">Выберите из списка</option>
                                    @foreach ($districts as $key => $item)
                                    <option data-parent="{{ $item->region_id }}" value="{{ $item->id }}" {{ old('region', $university->district_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('district')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <!-- <div class="form-group">
                                <label for="desc" class="form-label">Описание</label>
                                <textarea name="desc" id="desc" cols="30" rows="10" class="form-control @error('desc') is-invalid @enderror ckeditor" name="desc" placeholder="Описание...">{{ old('desc') ?? $university->desc }}</textarea>
                                @error('desc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h2 class="card-title mb-4">Показатели</h2>
                    <div class="row">
                        <div class="col-4">
                            <div class="card">
                              <div class="card-body">
                                <div class="row align-items-center gx-0">
                                  <div class="col">

                                    <!-- Title -->
                                    <h6 class="text-uppercase text-muted mb-2">
                                      Кол-во студентов
                                    </h6>

                                    <!-- Heading -->
                                    <span class="h2 mb-0">
                                      {{$university->students->count()}}
                                    </span>

                                  </div>
                                  <div class="col-auto">

                                    <!-- Icon -->
                                    <span class="h2 fe fe-briefcase text-muted mb-0"></span>

                                  </div>
                                </div> <!-- / .row -->
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="card">
                <div class="card-body">
                    <h2 class="card-title mb-3">Факультеты</h2>
                    <a href="{{ route('faculties.create') }}" class="btn btn-info mb-5">Добавить</a>
                    @if(isset($faculties[0]))
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        @foreach ($faculties as $key => $item)
                        <div class="accordion-item border-0">
                            <h2 class="accordion-header" id="panelsStayOpen-heading{{ $key }}">
                                <button class="accordion-button bg-white p-0 {{ $loop->iteration != 1 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse{{ $key }}" aria-expanded="{{ $loop->iteration == 1 ? 'true' : 'false' }}" aria-controls="panelsStayOpen-collapse{{ $key }}">
                                    <table class="table table-sm table-hover mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row" style="width: 100px">{{ $loop->iteration }}</th>
                                                <td>{{ $item->title }}</td>
                                                <td style="width: 200px">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route($route_name.'.edit', [$route_parameter => $item]) }}" class="btn btn-sm btn-info"><i class="fe fe-edit-2"></i></a>
                                                        <a class="btn btn-sm btn-danger ms-3" onclick="var result = confirm('Want to delete?');if (result){event.preventDefault();document.getElementById('delete-form{{ $item->id }}').submit();}"><i class="fe fe-trash"></i></a>
                                                        <form action="{{ route($route_name.'.destroy', [$route_parameter => $item]) }}" id="delete-form{{ $item->id }}" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapse{{ $key }}" class="accordion-collapse collapse {{ $loop->iteration == 1 ? 'show' : '' }}" aria-labelledby="panelsStayOpen-heading{{ $key }}">
                                <div class="accordion-body">
                                    <h3 class="mt-5 mb-4">Направлении</h3>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Название</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($faculties as $key => $item)
                                                <tr>
                                                    <th scope="row" style="width: 100px">{{ $loop->iteration }}</th>
                                                    <td>{{ $item->title }}</td>
                                                    <td style="width: 200px">
                                                        <div class="d-flex justify-content-end">
                                                            <a href="{{ route($route_name.'.edit', [$route_parameter => $item]) }}" class="btn btn-sm btn-info"><i class="fe fe-edit-2"></i></a>
                                                            <a class="btn btn-sm btn-danger ms-3" onclick="var result = confirm('Want to delete?');if (result){event.preventDefault();document.getElementById('delete-form{{ $item->id }}').submit();}"><i class="fe fe-trash"></i></a>
                                                            <form action="{{ route($route_name.'.destroy', [$route_parameter => $item]) }}" id="delete-form{{ $item->id }}" method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div> -->
        </div>
    </div>
</div>
@endsection