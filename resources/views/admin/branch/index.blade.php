@extends('layouts.admin', ['menuName' => 'Oddziały'])

@section('content')
    <div class="row">
        <div class="col-lg-12 table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Nazwa</th>
                    <th>Email</th>
                    <th>Telefon</th>
                    <th>Adres</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($branches->items() as $branch)
                    <tr>
                        <td>
                            {{ $branch->name }}
                        </td>
                        <td>{{ $branch->email }}</td>
                        <td>{{ $branch->phone }}</td>
                        <td>{{ $branch->street }}, {{ $branch->city }}, {{ $branch->zip_code }}</td>
                        <td class="text-end">
                            <form method="POST" action="{{ route('admin.branch.destroy', $branch) }}">
                                @csrf
                                @method('DELETE')
                                <a class="btn btn-primary text-white" href="{{ route('admin.branch.edit', $branch) }}?page={{ request()->get('page') }}"><i class="bi bi-pen"></i></a>
                                <button type="submit" class="ms-1 btn btn-danger text-white" @disabled($branch->products()->count())>
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-lg-12">
            {{ $branches->withQueryString()->links() }}
        </div>
        <div class="col-lg-12 text-end">
            <a href="{{ route('admin.branch.create') }}" class="btn btn-primary text-white">Dodaj nowy</a>
        </div>
    </div>
@endsection
