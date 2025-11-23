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
        <div class="row align-items-center">
            <div class="col">
                <!-- Nav -->
                <ul class="nav nav-tabs nav-overflow header-tabs">
                    <li class="nav-item">
                        <a href="{{route('students.home')}}" class="nav-link {{$active == 'index' ? 'active' : ''}}"> @lang('main.profile.title') </a>
                    </li>
                    @foreach($criterionCategory->criterions as $criterion)
                    <li class="nav-item">
                        <a href="{{route('students.criterions.show', ['id' => $criterionCategory->id, 'criterion_id' => $criterion->id])}}" class="nav-link {{$active == $criterion->id ? 'active' : ''}}">  {{$criterion->name}} </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>