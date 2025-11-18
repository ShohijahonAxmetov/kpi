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
    <form method="post" action="{{ route($route_name . '.update', [$route_parameter => $university]) }}" enctype="multipart/form-data" id="add">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-12">
                <div class="card mw-50">
                    <div class="card-body">
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
                                    <label for="region_id" class="form-label required">Где расположен (регион)</label>
                                    <select required class="form-control mb-4 @error('region_id') is-invalid @enderror" name="region_id" id="region_input">
                                        @foreach ($regions as $key => $item)
                                        <option value="{{ $item->id }}" {{ old('region_id', $university->region_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('region_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="district_id" class="form-label required">Где расположен (район)</label>
                                    <select required class="form-control mb-4 @error('district_id') is-invalid @enderror" name="district_id" id="district_input">
                                        <option value="">Выберите из списка</option>
                                        @foreach ($districts as $key => $item)
                                        <option data-parent="{{ $item->region_id }}" value="{{ $item->id }}" {{ old('district_id', $university->district_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('district_id')
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
                        <!-- Button -->
                        <div class="model-btns d-flex justify-content-end">
                            <a href="{{ route($route_name.'.index') }}" type="button" class="btn btn-secondary">Отмена</a>
                            <button type="submit" class="btn btn-primary ms-2">Сохранить</button>
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
    </form>
</div>
@endsection

@section('scripts')

<script>
    var region = document.getElementById('region_input');
    var district = document.getElementById('district_input');

    district.children.forEach(element => {
        element.classList.remove('d-none');
        if (element.getAttribute('data-parent') != region.value) {
            element.classList.add('d-none');
        }
    });

    region.addEventListener('change', function() {
        var data = [];

        district.children.forEach(element => {
            element.classList.remove('d-none');
            if (element.getAttribute('data-parent') != region.value) {
                element.classList.add('d-none');
            }
        });

    });
</script>

@endsection