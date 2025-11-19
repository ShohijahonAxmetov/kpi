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
                <div class="col-auto">
                    <!-- <a href="{{ route($route_name.'.import_form') }}" class="btn btn-primary lift">
                        Импортировать
                    </a> -->

                    <!-- Button -->
                    <a href="{{ route($route_name.'.create') }}" class="btn btn-primary lift">
                        Ma'lumot qo'shish
                    </a>

                </div>
            </div> <!-- / .row -->
        </div> <!-- / .header-body -->
        @include('app.components.breadcrumb', [
        'datas' => [
        [
        'active' => true,
        'url' => '',
        'name' => $title,
        'disabled' => false
        ]
        ]
        ])
    </div>
</div> <!-- / .header -->

<!-- CARDS -->
<div class="container-fluid">
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="mb-0">Filtr</h3>
        </div>
        <div class="card-body">
            <form action="{{ route($route_name.'.index') }}" method="get" class="d-flex justify-content-end w-100">
                <div class="form-group mb-0 w-100">
                    <select class="form-control @error('university_id') is-invalid @enderror" data-choices name="university_id" id="university_input">
                        <option value="">Universitet</option>
                        @foreach ($universities as $key => $item)
                        <option value="{{ $item->id }}" {{ $filter_university == $item->id ? 'selected' : '' }}>{{ $item->title }}</option>
                        @endforeach
                    </select>
                    @error('university_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group mb-0 w-100 ms-3">
                    <select class="form-control @error('faculty_id') is-invalid @enderror" name="faculty_id" id="faculty_input">
                        <option value="">Fakultet</option>
                        @foreach ($faculties as $key => $item)
                        <option data-parent="{{ $item->university_id }}" value="{{ $item->id }}" {{ $filter_faculty == $item->id ? 'selected' : '' }}>{{ $item->title }}</option>
                        @endforeach
                    </select>
                    @error('faculty_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group mb-0 w-100 ms-3">
                    <select class="form-control @error('direction_id') is-invalid @enderror" name="direction_id" id="direction_input">
                        <option value="">Kafedra/Yo'nalish</option>
                        @foreach ($directions as $key => $item)
                        <option data-parent="{{ $item->faculty_id }}" value="{{ $item->id }}" {{ $filter_direction == $item->id ? 'selected' : '' }}>{{ $item->title }}</option>
                        @endforeach
                    </select>
                    @error('direction_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success ms-3">Qidirish</button>
            </form>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body">
            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">F.I.Sh</th>
                            <th scope="col">Universitet</th>
                            <th scope="col">Fakultet</th>
                            <th scope="col">Umumiy ball</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $key => $item)
                        <tr>
                            <th scope="row" style="width: 100px">{{ $students->firstItem() + $key }}</th>
                            <td>{{ $item->surname.' '.$item->name.' '.$item->father_name }}</td>
                            <td>{{ $item->university->title ?? '--' }}</td>
                            <td>{{ $item->faculty->title ?? '--' }}</td>
                            <td>{{ $item->total_points }}</td>
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
            <div class="mt-4">
                {{ $students->links() }}
            </div>
        </div>
    </div>
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