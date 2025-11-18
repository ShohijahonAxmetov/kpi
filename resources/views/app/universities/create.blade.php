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
    <form method="post" action="{{ route($route_name . '.store') }}" enctype="multipart/form-data" id="add">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card mw-50">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="title" class="form-label required">Название</label>
                                    <input type="text" required class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" id="title" placeholder="Название...">
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="region" class="form-label required">Где расположен (регион)</label>
                                    <select required class="form-control @error('region') is-invalid @enderror" name="region" id="region_input">
                                        @foreach ($regions as $key => $item)
                                        <option value="{{ $item->id }}" {{ (old('region') == $item->id ?  : '') ? 'selected' : '' }}>{{ $item->name }}</option>
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
                                    <select required class="form-control @error('district') is-invalid @enderror" name="district" id="district_input">
                                        <option value="">Выберите из списка</option>
                                        @foreach ($districts as $key => $item)
                                        <option data-parent="{{ $item->region_id }}" value="{{ $item->id }}" {{ (old('district') == $item->id ?  : '') ? 'selected' : '' }} class="{{ $item->region_id == $regions->first()->id ? '' : 'd-none' }}">{{ $item->name }}</option>
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
                                    <textarea name="desc" id="desc" cols="30" rows="10" class="form-control @error('desc') is-invalid @enderror ckeditor" name="desc" placeholder="Описание...">{{ old('desc') }}</textarea>
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
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')

<script>

    // function update_districts() {
    var region = document.getElementById('region_input');
    var district = document.getElementById('district_input');

    region.addEventListener('change', function() {
        var data = [];

        district.children.forEach(element => {
            element.classList.remove('d-none');
            if (element.getAttribute('data-parent') != region.value) {
                element.classList.add('d-none');
            }
        });

        // district.innerHTML = '';

        // data.forEach(element => {
        //     district.append(element);
        // });
    });
    // }
</script>

@endsection