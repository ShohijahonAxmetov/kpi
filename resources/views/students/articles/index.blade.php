@extends('layouts.students')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-10">
            <!-- Header -->
            @include('students.components.header', [
            	'active' => 'articles',
                'title' => __('main.articles.title')
            ])
            <!-- Form -->
            <form active="{{route('articles.store')}}" method="post" enctype="multipart/form-data">
            	@csrf
                <div class="row">
                    <div class="col-12 col-md-6">
                        <!-- First name -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> @lang('main.articles.name') </label>
                            <!-- Input -->
                            <input name="title" value="{{old('title')}}" required type="text" class="form-control" placeholder="@lang('main.articles.name')">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- Last name -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> @lang('main.articles.date') </label>
                            <!-- Input -->
                            <input name="date" value="{{old('date')}}" required type="date" class="form-control">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- First name -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> @lang('main.articles.newspaper_name') </label>
                            <!-- Input -->
                            <input name="journal_title" value="{{old('journal_title')}}" required type="text" class="form-control" placeholder="@lang('main.articles.newspaper_name')">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- Last name -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> @lang('main.articles.authors_count') </label>
                            <!-- Input -->
                            <input name="members_count" value="{{old('members_count')}}" type="text" class="form-control" placeholder="@lang('main.articles.authors_count')">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- Last name -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> @lang('main.articles.type') </label>
                            <!-- Input -->
                            <select name="type" class="form-select" required>
                                <option value="1">Respublika tezis</option>
                                <option value="2">Xalqaro tezis</option>
                                <option value="3">Mahalliy gazeta tezis</option>
                                <option value="4">Ilmiy respublika maqola</option>
                                <option value="5">Ilmiy xalqaro maqola</option>
                                <option value="6">Ilmiy xalqaro OAK maqola</option>
                                <option value="7">Ilmiy respublika OAK maqola</option>
                                <option value="8">Ilmiy xalqaro scopus maqola</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- First name -->
                        <div class="form-group">
                            <!-- Label -->
                            <label class="form-label"> @lang('main.articles.file') </label>
                            <!-- Input -->
                            <input name="file" required type="file" class="form-control" placeholder="Файл">
                        </div>
                    </div>
                </div>
                <!-- / .row -->
                <!-- Button -->
                <button class="btn btn-primary"> @lang('main.save') </button>
                <!-- / .row -->
            </form>
            <br>
            <h3 class="mt-5">@lang('main.articles.title')</h3>
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">@lang('main.articles.name')</th>
                    <th scope="col">@lang('main.articles.date')</th>
                    <th scope="col">@lang('main.articles.newspaper_name')</th>
                    <th scope="col">@lang('main.articles.authors_count')</th>
                    <th scope="col">@lang('main.articles.type')</th>
                    <th scope="col">@lang('main.articles.file')</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $article)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$article->title}}</td>
                        <td>{{$article->date}}</td>
                        <td>{{$article->journal_title}}</td>
                        <td>{{$article->members_count}}</td>
                        <td>{{$article->type_string}}</td>
                        <td><a href="{{asset($article->file_path)}}">@lang('main.upload')</a></td>
                        <td>
                            <form action="{{route('articles.destroy', ['article' => $article])}}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger">x</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- / .row -->
</div>

@endsection
