@extends('layouts.admin', ['menuName' => 'Cechy produktów'])

@section('content')
    <div class="row">
        <div class="col-lg-12 table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Nazwa</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($attributes->items() as $attribute)
                    <tr>
                        <td>
                            {{ $attribute->name }}
                        </td>
                        <td class="text-end">
                            <form method="POST" action="{{ route('admin.attribute.destroy', $attribute) }}">
                                @csrf
                                @method('DELETE')
                                <a class="btn btn-primary text-white" href="{{ route('admin.attribute.edit', $attribute) }}?page={{ request()->get('page') }}"><i class="bi bi-pen"></i></a>
                                <button type="submit" class="ms-1 btn btn-danger text-white" @disabled($attribute->products()->count())>
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
            {{ $attributes->withQueryString()->links() }}
        </div>
        <div class="col-lg-12 text-end">
            <a href="{{ route('admin.attribute.create') }}" class="btn btn-primary text-white">Dodaj nowy</a>
        </div>
    </div>
@endsection
