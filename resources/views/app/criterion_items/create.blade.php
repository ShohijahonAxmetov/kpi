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
                                    <label class="form-label required">Mezon bo'limi</label>
                                    <select required class="form-control @error('criterion_main_category_id') is-invalid @enderror" data-choices name="criterion_main_category_id" id="main_parent">
                                        @foreach ($criterionMainCategories as $key => $item)
                                        <option value="{{ $item->id }}" {{ (old('criterion_main_category_id') == $item->id ?  : '') ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('criterion_main_category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label required">Mezon ichki bo'limi</label>
                                    <select required class="form-control @error('criterion_category_id') is-invalid @enderror" name="criterion_category_id" id="parent">
                                        <option value="">Выберите из списка</option>
                                        @foreach ($criterionCategories as $key => $item)
                                        <option data-parent="{{ $item->criterion_main_category_id }}" value="{{ $item->id }}" {{ (old('criterion_category_id') == $item->id ?  : '') ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('criterion_category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label required">Mezon</label>
                                    <select required class="form-control @error('criterion_id') is-invalid @enderror" name="criterion_id" id="parent_junior">
                                        <option value="">Выберите из списка</option>
                                        @foreach ($criterions as $key => $item)
                                        <option data-parent="{{ $item->criterion_category_id }}" value="{{ $item->id }}" {{ (old('criterion_id') == $item->id ?  : '') ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('criterion_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="name" class="form-label required">Nomi</label>
                                    <input type="text" required class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" id="name" placeholder="Nomi...">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="max_score" class="form-label required">Eng yuqori beriladigan ball</label>
                                    <input type="text" required class="form-control @error('max_score') is-invalid @enderror" name="max_score" value="{{ old('max_score') }}" id="max_score" placeholder="Eng yuqori beriladigan ball...">
                                    @error('max_score')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="order" class="form-label">Tartibi</label>
                                    <input type="text" class="form-control @error('order') is-invalid @enderror" name="order" value="{{ old('order') }}" id="order" placeholder="Tartibi...">
                                    @error('order')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label required">Asos (hujjat) talab etiladimi?</label>
                                    <select required class="form-control @error('is_need_basis') is-invalid @enderror" name="is_need_basis">
                                        @foreach (['YOQ' => "Yo'q", 'HA' => 'Ha'] as $key => $item)
                                        <option value="{{ $key }}" {{ (old('is_need_basis') == $key ?  : '') ? 'selected' : '' }}>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                    @error('is_need_basis')
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

@section('scripts')

<script>
    let mainParent = document.getElementById('main_parent');
    let parent = document.getElementById('parent');
    let parentJunior = document.getElementById('parent_junior');

    parentJunior.children.forEach(element => {
        element.classList.remove('d-none');
        if (element.getAttribute('data-parent') != parent.value) {
            element.classList.add('d-none');
        }
    });

    parent.addEventListener('change', function() {
        parentJunior.children.forEach(element => {
            element.classList.remove('d-none');
            if (element.getAttribute('data-parent') != parent.value) {
                element.classList.add('d-none');
            }
        });
    });

    parent.children.forEach(element => {
        element.classList.remove('d-none');
        if (element.getAttribute('data-parent') != mainParent.value) {
            element.classList.add('d-none');
        }
    });

    mainParent.addEventListener('change', function() {
        parent.children.forEach(element => {
            element.classList.remove('d-none');
            if (element.getAttribute('data-parent') != mainParent.value) {
                element.classList.add('d-none');
            }
        });
    });
</script>

@endsection