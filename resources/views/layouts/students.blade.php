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
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.css" />

    <!-- Libs CSS -->
    <link rel="stylesheet" href="/assets/css/libs.bundle.css" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="/assets/css/theme.bundle.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
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
    <title>Dashboard | Students</title>

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
                            <img src="/assets/img/avatars/profiles/avatar-6.jpg" class="avatar-img rounded-circle" alt="...">
                        </div>
                    </a>

                    <!-- Menu -->
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarIcon">
                        <a href="/sign-in.html" class="dropdown-item">Logout</a>
                    </div>

                </div>

            </div>

            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidebarCollapse">

                <!-- Navigation -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('students.home') ? 'active' : '' }}" href="{{ route('students.home') }}">
                            <i class="fe fe-home"></i> @lang('main.profile.title')
                        </a>
                    </li>
                    <hr class="navbar-divider my-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('students/tests') || request()->is('students/tests/*') ? 'active' : '' }}" href="{{ route('tests.index') }}">
                            <i class="fe fe-check-square"></i> @lang('main.test.title')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('students/ielts') || request()->is('students/ielts/*') ? 'active' : '' }}" href="{{ route('ielts.index') }}">
                            <i class="fe fe-square"></i> @lang('main.foreign_lang_certificates.title')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('students/certificates') || request()->is('students/certificates/*') ? 'active' : '' }}" href="{{ route('certificates.index') }}">
                            <i class="fe fe-layers"></i> @lang('main.certificates.title')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('students/articles') || request()->is('students/articles/*') ? 'active' : '' }}" href="{{ route('articles.index') }}">
                            <i class="fe fe-book-open"></i> @lang('main.articles.title')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('students/projects') || request()->is('students/projects/*') ? 'active' : '' }}" href="{{ route('projects.index') }}">
                            <i class="fe fe-briefcase"></i> @lang('main.projects.title')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('students/scholarships') || request()->is('students/scholarships/*') ? 'active' : '' }}" href="{{ route('scholarships.index') }}">
                            <i class="fe fe-dollar-sign"></i> @lang('main.scholarships.title')
                        </a>
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
                            <a href="{{ route('students.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item">@lang('main.logout')</a>
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
    <script src='https://api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.js'></script>

    <!-- Vendor JS -->
    <script src="/assets/js/vendor.bundle.js"></script>

    <!-- Theme JS -->
    <script src="/assets/js/theme.bundle.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js" integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    @yield('scripts')

    @if (session()->has('success') && session('success') == false)
    <script type="text/javascript">
        const notyf = new Notyf({
            position: {
                x: 'right',
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
                x: 'right',
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
