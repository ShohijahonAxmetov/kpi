@extends('layouts.app')

@section('content')

    <h1 class="text-uppercase mb-4">Сертификаты</h1>

    <a href="{{ route('certificates.create') }}" class="btn btn-success mb-3 text-white">Добавить</a>

    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded">
                    <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start">#</th>
                        <th class="border-0">Описание</th>
                        <th class="border-0">Фото</th>
                        <th class="border-0 rounded-end">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($certificates as $certificate)
                        <!-- Item -->
                        <tr>
                            <td><a href="#" class="text-primary fw-bold">{{ ($certificates ->currentpage()-1) * $certificates ->perpage() + $loop->index + 1 }}</a></td>
                            <td>{{ $certificate->desc['ru'] }}</td>
                            <td>
                                <img src="{{ asset($certificate->img) }}" alt="" style="max-width: 250px">
                            </td>
                            <td>
                                <div class="actions d-flex flex-row">
                                    <form class="" action="{{ route('certificates.destroy', ['certificate' => $certificate->id]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="text-danger bg-transparent border-0 p-0 m-0 mb-3 fw-bolder delete-btn"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                    <a href="{{ route('certificates.edit', ['certificate' => $certificate->id]) }}" class="text-info fw-bolder ms-3"><i class="fa-solid fa-pen"></i></a>
                                </div>
                            </td>
                        </tr>
                        <!-- End of Item -->
                    @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {!! $certificates->links() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
