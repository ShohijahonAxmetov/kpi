<div class="header mt-md-5">
    <div class="header-body">
        <div class="row align-items-center">
            <div class="col">
                <!-- Pretitle -->
                <!-- <h6 class="header-pretitle"> Overview </h6> -->
                <!-- Title -->
                <h1 class="header-title"> {{$title}} </h1>
            </div>
        </div>
        <!-- / .row -->
        <div class="row align-items-center">
            <div class="col">
                <!-- Nav -->
                <ul class="nav nav-tabs nav-overflow header-tabs">
                    <li class="nav-item">
                        <a href="{{route('students.home')}}" class="nav-link {{$active == 'index' ? 'active' : ''}}"> @lang('main.profile.title') </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('tests.index')}}" class="nav-link {{$active == 'tests' ? 'active' : ''}}">  @lang('main.test.title') </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('ielts.index')}}" class="nav-link {{$active == 'ielts' ? 'active' : ''}}"> @lang('main.foreign_lang_certificates.title') </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('certificates.index')}}" class="nav-link {{$active == 'certificates' ? 'active' : ''}}"> @lang('main.certificates.title') </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('articles.index')}}" class="nav-link {{$active == 'articles' ? 'active' : ''}}"> @lang('main.articles.title') </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('projects.index')}}" class="nav-link {{$active == 'projects' ? 'active' : ''}}"> @lang('main.projects.title') </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('scholarships.index')}}" class="nav-link {{$active == 'scholarships' ? 'active' : ''}}">  @lang('main.scholarships.title') </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>