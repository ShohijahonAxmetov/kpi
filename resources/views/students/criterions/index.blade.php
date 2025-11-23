@extends('layouts.students')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-10">
            <!-- Header -->
            @include('students.components.header', [
                'active' => $criterion->id ?? null,
                'title' => $criterionCategory->name
            ])
            @php
                $application = \App\Models\Application::where([['student_id', auth()->id()], ['criterion_id', $criterion->id]])->first();
            @endphp
            @if(!$criterion->entered_manually)
                <p>Bu mezon ilmiy kengash tomonidan baholanadi. Sizga berilgan ball: <strong>{{$application->score ?? '-'}}</strong></p>
                <p><i>Izoh: {{$application->answer}}</i></p>
            @else
            <!-- Form -->
            <form method="POST" action="{{route('applications.store')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="criterion_id" value="{{$criterion->id}}">
                <div class="row">

                    @if(count($criterion->criterionItems) > 0)
                    <div class="col-12 col-md-6">
                        <!-- Last name -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> Yuklanayotgan ma'lumot turi </label>
                            <!-- Input -->
                            <select name="criterion_item_id" class="form-select">
                                @foreach($criterion->criterionItems as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- First name -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> Asos (hujjat, fayl) </label>
                            <!-- Input -->
                            <input name="basis" required type="file" class="form-control" placeholder="Файл">
                        </div>
                    </div>
                    @endif

                    <div class="col-12">
                        <!-- First name -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label required"> Izoh </label>
                            <!-- Input -->
                            <textarea required name="comment" rows="4" class="form-control" placeholder="Izoh...">{{old('comment')}}</textarea>
                        </div>
                    </div>

                </div>
                <!-- / .row -->
                <!-- Button -->
                <button class="btn btn-primary" type="submit"> @lang('main.save') </button>
                <!-- / .row -->
            </form>
            <br>
            <h3 class="mt-5">Yuklangan ma'lumotlar</h3>
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    @if(count($criterion->criterionItems) > 0)
                    <th scope="col">Yuklanayotgan ma'lumot turi</th>
                    <th scope="col">Asos (hujjat, fayl)</th>
                    @endif
                    <th scope="col">Mening izohim</th>
                    <th scope="col">Holati</th>
                    <th scope="col">Berilgan ball</th>
                    <th scope="col">Komissiya izohi</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($files ?? [] as $file)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        @if(count($criterion->criterionItems) > 0)
                        <td>{{$file->criterionItem->name}}</td>
                        <td><a href="/upload/files/{{$file->basis}}">@lang('main.upload')</a></td>
                        @endif
                        <td>{{$file->comment}}</td>
                        <td>
                            @if($file->status == 1)
                            Ko'rib chiqilmoqda
                            @elseif($file->status == 10)
                            Tasdiqlangan
                            @endif
                        </td>
                        <td>{{$file->score ?? '-'}}/{{$file->criterionItem->max_score ?? $criterion->max_score}}</td>
                        <td>{{$file->answer ?? '-'}}</td>
                        @if($file->status == 1)
                        <td>
                            <form action="{{route('applications.destroy', ['application' => $file])}}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger">x</button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
    <!-- / .row -->
</div>

@endsection
