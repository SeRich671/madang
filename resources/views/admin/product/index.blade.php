@extends('layouts.admin', ['menuName' => 'Produkty'])

@section('content')
    <div class="row">
        <div class="col-lg-12 table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Nazwa</th>
                    <th>Cena podstawowa</th>
                    <th>Stan</th>
                    <th>Dostępny</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($products->items() as $product)
                    <tr>
                        <td>
                            {{ $product->name }}
                        </td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->in_stock }}</td>
                        <td>{{ $product->is_available ? 'Tak' : 'Nie' }}</td>
                        <td class="text-end">
                            <form method="POST" action="{{ route('admin.product.destroy', $product) }}">
                                @csrf
                                @method('DELETE')
                                <a class="btn btn-primary text-white" href="{{ route('admin.product.edit', $product) }}"><i class="bi bi-pen"></i></a>
                                <button type="submit" class="ms-1 btn btn-danger text-white" @disabled($product->orderLines()->count())>
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
            {{ $products->links() }}
        </div>
        <div class="col-lg-12 text-end">
            <a href="{{ route('admin.product.create') }}" class="btn btn-primary text-white">Dodaj nowy</a>
        </div>
    </div>
@endsection
