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
    <form method="post" action="{{ route($route_name . '.update', [$route_parameter => $student]) }}" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-12">
                <div class="card mw-50">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="university_id" class="form-label required">Университет</label>
                                    <select required class="form-control @error('university_id') is-invalid @enderror" data-choices name="university_id" id="university_input">
                                        @foreach ($universities as $key => $item)
                                        <option value="{{ $item->id }}" {{ old('university_id', $student->university_id) == $item->id ? 'selected' : '' }}>{{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('university_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="faculty_id" class="form-label required">Факультет</label>
                                    <select required class="form-control mb-4 @error('faculty_id') is-invalid @enderror" name="faculty_id" id="faculty_input">
                                        <option value="">Выберите из списка</option>
                                        @foreach ($faculties as $key => $item)
                                        <option data-parent="{{ $item->university_id }}" value="{{ $item->id }}" {{ old('faculty_id', $student->faculty_id) == $item->id ? 'selected' : '' }}>{{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('faculty_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="direction_id" class="form-label required">Направления</label>
                                    <select required class="form-control mb-4 @error('direction_id') is-invalid @enderror" name="direction_id" id="direction_input">
                                        <option value="">Выберите из списка</option>
                                        @foreach ($directions as $key => $item)
                                        <option data-parent="{{ $item->faculty_id }}" value="{{ $item->id }}" {{ old('direction_id', $student->direction_id) == $item->id ? 'selected' : '' }}>{{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('direction_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="surname" class="form-label required">Фамилия</label>
                                    <input type="text" required class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname', $student->surname) }}" id="surname" placeholder="Фамилия...">
                                    @error('surname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="name" class="form-label required">Имя</label>
                                    <input type="text" required class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $student->name) }}" id="name" placeholder="Имя...">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="father_name" class="form-label ">Отечество</label>
                                    <input type="text" class="form-control @error('father_name') is-invalid @enderror" name="father_name" value="{{ old('father_name', $student->father_name) }}" id="father_name" placeholder="Отечество...">
                                    @error('father_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="passport_number" class="form-label required">Номер паспорта</label>
                                    <input type="text" required class="form-control @error('passport_number') is-invalid @enderror" name="passport_number" value="{{ old('passport_number', $student->passport_number) }}" id="passport_number" placeholder="Номер паспорта...">
                                    @error('passport_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="student_passport_number" class="form-label required">Номер студентского</label>
                                    <input type="text" required class="form-control @error('student_passport_number') is-invalid @enderror" name="student_passport_number" value="{{ old('student_passport_number', $student->student_passport_number) }}" id="student_passport_number" placeholder="Номер студентского...">
                                    @error('student_passport_number')
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
    var university = document.getElementById('university_input');
    var faculty = document.getElementById('faculty_input');
    var direction = document.getElementById('direction_input');

    direction.children.forEach(element => {
        element.classList.remove('d-none');
        if (element.getAttribute('data-parent') != faculty.value) {
            element.classList.add('d-none');
        }
    });

    faculty.children.forEach(element => {
        element.classList.remove('d-none');
        if (element.getAttribute('data-parent') != university.value) {
            element.classList.add('d-none');
        }
    });

    university.addEventListener('change', function() {
        faculty.children.forEach(element => {
            element.classList.remove('d-none');
            if (element.getAttribute('data-parent') != university.value) {
                element.classList.add('d-none');
            }
        });
        faculty.value = '';
        
        direction.children.forEach(element => {
            element.classList.remove('d-none');
            if (element.getAttribute('data-parent') != faculty.value) {
                element.classList.add('d-none');
            }
        });
        direction.value = '';
    });

    faculty.addEventListener('change', function() {
        direction.children.forEach(element => {
            element.classList.remove('d-none');
            if (element.getAttribute('data-parent') != faculty.value) {
                element.classList.add('d-none');
            }
        });
        direction.value = '';
    });
</script>

@endsection