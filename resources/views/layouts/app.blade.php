<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="/assets/favicon/favicon.ico" type="image/x-icon" />

    <!-- Map CSS -->
    <link rel="stylesheet" href="/assets/css/mapbox-gl.css" />

    <!-- Libs CSS -->
    <link rel="stylesheet" href="/assets/css/libs.bundle.css" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="/assets/css/theme.bundle.css" />

    <link rel="stylesheet" href="/assets/css/notyf.min.css">

    <script src="/assets/js/ckeditor.js"></script>
    <script>
        // CKEDITOR.config.toolbar = [
        // 	{ name: 'document', items : [ 'Undo','Redo'] },
        // ];
        // 	{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Subscript','Superscript','Format' ] },
        // CKEDITOR.config.filebrowserBrowseUrl = '/browse.php';
        // CKEDITOR.config.extraPlugins = 'uploadimage';
        CKEDITOR.config.filebrowserUploadUrl = "{{ route('upload-image', ['_token' => csrf_token()]) }}";
        CKEDITOR.config.filebrowserUploadMethod = 'form';
    </script>

    <!-- Title -->
    <title>Dashboard | KPI dasturi</title>

    @yield('links')

    <style>
        .required:after {
            content: '*';
            color: red;
        }

        .active {
            color: #12263f;
        }

        .dz-success-mark,
        .dz-error-mark,
        .dz-details {
            display: none;
        }

        .imb-block {
            width: 80px;
            height: 80px;
        }

        .imb-block>img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .dropzone {
            flex-direction: row;
            flex-wrap: wrap;
        }

        .dz-default.dz-message {
            width: 100%;
            margin-bottom: 12px;
        }

        .dz-preview {
            width: fit-content;
            margin-right: 12px;
            margin-bottom: 32px;
            max-width: 120px;
            height: 120px;
        }

        .dz-preview .dz-image {
            width: 100%;
            height: 100%;
        }

        .dz-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div id="preloader" style="
        position: fixed;
        top: 0;
        left: 0;
        background: rgba(255,255,255,0.9);
        width: 100%;
        height: 100%;
        z-index: 9999;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    ">
        <img src="/assets/img/preloader.gif" style="width: 100px;">
    </div>
    @if(!isset($no_sidebar))
    <!-- NAVIGATION -->
    <nav class="navbar navbar-vertical fixed-start navbar-expand-md navbar-light" id="sidebar">
        <div class="container-fluid">

            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Brand -->
            @include('components.logo')

            <!-- User (xs) -->
            <div class="navbar-user d-md-none">

                <!-- Dropdown -->
                <div class="dropdown">

                    <!-- Toggle -->
                    <a href="#" id="sidebarIcon" class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar avatar-sm avatar-online">
                            <img src="/assets/img/avatars/profiles/default_user.png" class="avatar-img rounded-circle" alt="...">
                        </div>
                    </a>

                    <!-- Menu -->
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarIcon">
                        <a href="{{ route('logout') }}" class="dropdown-item">Chiqish</a>
                    </div>

                </div>

            </div>

            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidebarCollapse">

                <!-- Navigation -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin') ? 'active' : '' }}" href="{{ route('admin') }}">
                            <i class="fe fe-home"></i> Bosh sahifa
                        </a>
                    </li>
                    <hr class="navbar-divider my-3">
                    <li class="nav-item">
                        <a class="nav-link" href="#universities" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->is('posts') || request()->is('posts/*') || request()->is('posts_categories') || request()->is('posts_categories/*') ? 'true' : 'false' }}" aria-controls="universities">
                            <i class="fe fe-book-open"></i> Universitet
                        </a>
                        <div class="collapse {{ request()->is('admin/universities') || request()->is('admin/universities/*') || request()->is('admin/faculties') || request()->is('admin/faculties/*') || request()->is('admin/directions') || request()->is('admin/directions/*') ? 'show' : '' }}" id="universities">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/universities') || request()->is('admin/universities/*') ? 'active' : '' }}" href="{{ route('universities.index') }}">
                                        Universitet
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/faculties') || request()->is('admin/faculties/*') ? 'active' : '' }}" href="{{ route('faculties.index') }}">
                                        Fakultetlar
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/directions') || request()->is('admin/directions/*') ? 'active' : '' }}" href="{{ route('directions.index') }}">
                                        Kafedralar va yo'nalishlar
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/students') || request()->is('admin/students/*') ? 'active' : '' }}" href="{{ route('students.index') }}">
                            <i class="fe fe-users"></i> O'qituvchilar ro'yxati
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/applications') || request()->is('admin/applications/*') ? 'active' : '' }}" href="{{ route('admin.applications.index') }}">
                            <i class="fe fe-bell"></i> Arizalar
                        </a>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link {{ request()->is('admin/experts') || request()->is('admin/experts/*') ? 'active' : '' }}" href="{{ route('experts.index') }}">--}}
{{--                            <i class="fe fe-users"></i> Эксперты--}}
{{--                        </a>--}}
{{--                    </li>--}}
                    <hr class="navbar-divider my-3">
                    <li class="nav-item">
                        <a class="nav-link" href="#static_info" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->is('admin/site_infos') || request()->is('admin/site_infos/*') || request()->is('admin/additional_functions') || request()->is('admin/additional_functions/*') || request()->is('admin/users') || request()->is('admin/users/*') || request()->is('admin/translations') || request()->is('admin/translations/*') || request()->is('admin/langs') || request()->is('admin/langs/*') || request()->is('admin/logs') || request()->is('admin/logs/*') ? 'true' : 'false' }}" aria-controls="documents">
                            <i class="fe fe-settings"></i> Sozlamalar
                        </a>
                        <div class="collapse {{ request()->is('admin/site_infos') || request()->is('admin/site_infos/*') || request()->is('admin/additional_functions') || request()->is('admin/additional_functions/*') || request()->is('admin/users') || request()->is('admin/users/*') || request()->is('admin/translations') || request()->is('admin/translations/*') || request()->is('admin/langs') || request()->is('admin/langs/*') || request()->is('admin/logs') || request()->is('admin/logs/*') ? 'show' : '' }}" id="static_info">
                            <ul class="nav nav-sm flex-column">
                                @if(auth()->user()->role == 'admin')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/logs') || request()->is('admin/logs/*') ? 'active' : '' }}" href="{{ route('logs.index') }}">
                                        <i class="fe fe-file-text"></i> Loglar
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                        <i class="fe fe-users"></i> Tizim adminlari
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#books" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->is('admin/academic_degrees') || request()->is('admin/academic_degrees/*') || request()->is('admin/academic_titles') || request()->is('admin/academic_titles/*') || request()->is('admin/ranks') || request()->is('admin/ranks/*') || request()->is('admin/lang_certificate_langs') || request()->is('admin/lang_certificate_langs/*') || request()->is('admin/certificate_points') || request()->is('admin/certificate_points/*') ? 'true' : 'false' }}" aria-controls="documents">
                            <i class="fe fe-book"></i> Ma'lumotnomalar
                        </a>
                        <div class="collapse {{ request()->is('admin/academic_degrees') || request()->is('admin/academic_degrees/*') || request()->is('admin/academic_titles') || request()->is('admin/academic_titles/*') || request()->is('admin/ranks') || request()->is('admin/ranks/*') || request()->is('admin/lang_certificate_langs') || request()->is('admin/lang_certificate_langs/*') || request()->is('admin/certificate_points') || request()->is('admin/certificate_points/*') ? 'show' : '' }}" id="books">
                            <ul class="nav nav-sm flex-column">
                                @if(auth()->user()->role == 'admin')
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is('admin/ranks') || request()->is('admin/ranks/*') ? 'active' : '' }}" href="{{ route('ranks.index') }}">
                                            Unvonlar
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is('admin/academic_degrees') || request()->is('admin/academic_degrees/*') ? 'active' : '' }}" href="{{ route('academic_degrees.index') }}">
                                            Ilmiy darajalar
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is('admin/academic_titles') || request()->is('admin/academic_titles/*') ? 'active' : '' }}" href="{{ route('academic_titles.index') }}">
                                            Ilmiy unvonlar
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is('admin/lang_certificate_langs') || request()->is('admin/lang_certificate_langs/*') ? 'active' : '' }}" href="{{ route('lang_certificate_langs.index') }}">
                                            Chet til sertifikati tillari
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is('admin/certificate_points') || request()->is('admin/certificate_points/*') ? 'active' : '' }}" href="{{ route('certificate_points.index') }}">
                                            Chet tili sertifikati darajalari
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#criterions" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->is('admin/criterion_main_categories') || request()->is('admin/criterion_main_categories/*') || request()->is('admin/criterion_categories') || request()->is('admin/criterion_categories/*') || request()->is('admin/criterions') || request()->is('admin/criterions/*') || request()->is('admin/criterion_items') || request()->is('admin/criterion_items/*') ? 'true' : 'false' }}" aria-controls="documents">
                            <i class="fe fe-book"></i> Baholash mezonlari
                        </a>
                        <div class="collapse {{ request()->is('admin/criterion_main_categories') || request()->is('admin/criterion_main_categories/*') || request()->is('admin/criterion_categories') || request()->is('admin/criterion_categories/*') || request()->is('admin/criterions') || request()->is('admin/criterions/*') || request()->is('admin/criterion_items') || request()->is('admin/criterion_items/*') ? 'show' : '' }}" id="criterions">
                            <ul class="nav nav-sm flex-column">
                                @if(auth()->user()->role == 'admin')
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is('admin/criterion_main_categories') || request()->is('admin/criterion_main_categories/*') ? 'active' : '' }}" href="{{ route('criterion_main_categories.index') }}">
                                            Bo'limlar
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is('admin/criterion_categories') || request()->is('admin/criterion_categories/*') ? 'active' : '' }}" href="{{ route('criterion_categories.index') }}">
                                            Ichki bo‘limlar
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is('admin/criterions') || request()->is('admin/criterions/*') ? 'active' : '' }}" href="{{ route('criterions.index') }}">
                                            Mezonlar
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is('admin/criterion_items') || request()->is('admin/criterion_items/*') ? 'active' : '' }}" href="{{ route('criterion_items.index') }}">
                                            Mezonlar bandlari
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                </ul>

                <!-- Push content down -->
                <div class="mt-auto"></div>


                <!-- User (md) -->
                <div class="navbar-user d-none d-md-flex" id="sidebarUser">

                    <!-- Dropup -->
                    <div class="dropup">

                        <!-- Toggle -->
                        <a href="#" id="sidebarIconCopy" class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="avatar avatar-sm avatar-online">
                                <img src="/assets/img/avatars/profiles/default_user.png" class="avatar-img rounded-circle" alt="...">
                            </div>
                        </a>

                        <!-- Menu -->
                        <div class="dropdown-menu" aria-labelledby="sidebarIconCopy">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item">Chiqish</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>

                    </div>

                </div>

            </div> <!-- / .navbar-collapse -->

        </div>
    </nav>
    @endif
    <!-- MAIN CONTENT -->
    <div class="main-content">


        @yield('content')


    </div><!-- / .main-content -->

    <!-- JAVASCRIPT -->
    <!-- Map JS -->
    <script src='/assets/js/mapbox-gl.js'></script>

    <!-- Vendor JS -->
    <script src="/assets/js/vendor.bundle.js"></script>

    <!-- Theme JS -->
    <script src="/assets/js/theme.bundle.js"></script>

    <script src="/assets/js/axios.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="/assets/js/notyf.min.js"></script>

    @yield('scripts')

    @if (session()->has('success') && session('success') == false)
    <script type="text/javascript">
        const notyf = new Notyf({
            position: {
                x: 'center',
                y: 'top',
            },
            types: [{
                type: 'error',
                background: '#b82c46',
                icon: {
                    className: 'fe fe-x',
                    tagName: 'span',
                    color: '#fff'
                },
                dismissible: false
            }]
        });
        notyf.open({
            type: 'error',
            message: <?= json_encode(session('message')) ?>
        });
    </script>
    @endif

    @if (session()->has('success') && session('success') == true)
    <script type="text/javascript">
        const notyf = new Notyf({
            position: {
                x: 'center',
                y: 'top',
            },
            types: [{
                type: 'success',
                background: '#00ae65',
                icon: {
                    className: 'fe fe-check-circle',
                    tagName: 'span',
                    color: '#fff'
                },
                dismissible: false
            }]
        });
        notyf.open({
            type: 'success',
            message: <?= json_encode(session('message')) ?>
        });
    </script>
    @endif

    <script>
        var preloader = document.getElementById('preloader');

        preloader.classList.add('d-none');
    </script>

</body>

</html>
