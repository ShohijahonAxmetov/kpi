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
        'name' => 'Kiritish',
        'disabled' => true
        ],
        ]
        ])
    </div>
</div> <!-- / .header -->

<!-- CARDS -->
<div class="container-fluid">
    <form method="post" action="{{ route($route_name . '.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card mw-50">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">

                                <div class="form-group">
                                    <label for="university_id" class="form-label required">Universitet</label>
                                    <select required class="form-control @error('university_id') is-invalid @enderror" data-choices name="university_id" id="university_input">
                                        @foreach ($universities as $key => $item)
                                        <option value="{{ $item->id }}" {{ (old('university_id') == $item->id ?  : '') ? 'selected' : '' }}>{{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('university_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="faculty_id" class="form-label required">Fakultet</label>
                                    <select required class="form-control @error('faculty_id') is-invalid @enderror" name="faculty_id" id="faculty_input">
                                        <option value="">Ro'yxatdan tanlang</option>
                                        @foreach ($faculties as $key => $item)
                                        <option data-parent="{{ $item->university_id }}" value="{{ $item->id }}" {{ (old('faculty_id') == $item->id ?  : '') ? 'selected' : '' }}>{{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('faculty_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="direction_id" class="form-label required">Kafedra/Yo'nalish</label>
                                    <select required class="form-control @error('direction_id') is-invalid @enderror" name="direction_id" id="direction_input">
                                        <option value="">Ro'yxatdan tanlang</option>
                                        @foreach ($directions as $key => $item)
                                        <option data-parent="{{ $item->faculty_id }}" value="{{ $item->id }}" {{ (old('direction_id') == $item->id ?  : '') ? 'selected' : '' }}>{{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('direction_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="surname" class="form-label required">Familiyasi</label>
                                    <input type="text" required class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" id="surname" placeholder="Familiyasi...">
                                    @error('surname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="name" class="form-label required">Ismi</label>
                                    <input type="text" required class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" id="surname" placeholder="Ismi...">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="father_name" class="form-label">Otasining ismi</label>
                                    <input type="text" class="form-control @error('father_name') is-invalid @enderror" name="father_name" value="{{ old('father_name') }}" id="title" placeholder="Otasining ismi...">
                                    @error('father_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="rank_id" class="form-label required">Unvoni</label>
                                    <select required class="form-control @error('rank_id') is-invalid @enderror" data-choices name="rank_id">
                                        @foreach ($ranks as $key => $item)
                                        <option value="{{ $item->id }}" {{ (old('rank_id') == $item->id ?  : '') ? 'selected' : '' }}>{{ $item->name }} ({{$item->code}})</option>
                                        @endforeach
                                    </select>
                                    @error('rank_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="academic_degree_id" class="form-label required">Ilmiy darajasi</label>
                                            <select required class="form-control @error('academic_degree_id') is-invalid @enderror" data-choices name="academic_degree_id">
                                                @foreach ($academicDegrees as $key => $item)
                                                <option value="{{ $item->id }}" {{ (old('academic_degree_id') == $item->id ?  : '') ? 'selected' : '' }}>{{ $item->name }} ({{$item->code}})</option>
                                                @endforeach
                                            </select>
                                            @error('academic_degree_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="academic_title_id" class="form-label required">Ilmiy unvoni</label>
                                            <select required class="form-control @error('academic_title_id') is-invalid @enderror" data-choices name="academic_title_id">
                                                @foreach ($academicTitles as $key => $item)
                                                <option value="{{ $item->id }}" {{ (old('academic_title_id') == $item->id ?  : '') ? 'selected' : '' }}>{{ $item->name }} ({{$item->code}})</option>
                                                @endforeach
                                            </select>
                                            @error('academic_title_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                

                                <div class="form-group">
                                    <label for="passport_number" class="form-label required">Foydalanuvchi logini</label>
                                    <input type="text" required class="form-control @error('passport_number') is-invalid @enderror" name="passport_number" value="{{ old('passport_number') }}" id="title" placeholder="Foydalanuvchi logini...">
                                    @error('passport_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="model-btns d-flex justify-content-end">
                            <a href="{{ route($route_name.'.index') }}" type="button" class="btn btn-secondary">Bekor qilish</a>
                            <button type="submit" class="btn btn-primary ms-2">Saqlash</button>
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