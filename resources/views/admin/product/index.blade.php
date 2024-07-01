@extends('layouts.admin', ['menuName' => 'Produkty'])

@section('content')
    <form method="GET" action="{{ url()->current() }}">
        <div class="row">
            <div class="col-lg-12 text-end">
                <button type="button" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#productExportUser">
                    Zestawienie
                </button>
            </div>
            <div class="col-lg-12">
                <label for="query">Nazwa</label>
                <input type="text" class="form-control" name="query" id="query" value="{{ request()->input('query') }}">
            </div>
            <div class="col-lg-4">
                <label for="category_id">Kategorie</label>
                <select class="form-control" id="category_id" name="category_id[]" multiple>
                    @foreach($categories as $key => $category)
                        <option value="{{ $key }}" @selected(in_array($key, request()->input('category_id',[])))>{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2">
                <label for="img_path">Zdjecia</label>
                <select class="form-control" id="img_path" name="img_path">
                    <option value="">Wszystkie</option>
                    <option value="1" @selected(request()->input('img_path') === '1')>Ze zdjęciami</option>
                    <option value="0" @selected(request()->input('img_path') === '0')>Brak zdjęć</option>
                </select>
            </div>
            <div class="col-lg-2">
                <label for="is_recommended">Wybrane</label>
                <select class="form-control" id="is_recommended" name="is_recommended">
                    <option value="">Wszystkie</option>
                    <option value="1" @selected(request()->input('is_recommended') === '1')>Pokaż wybrane na Home</option>
                    <option value="0" @selected(request()->input('is_recommended') === '0')>Niewybrane</option>
                </select>
            </div>
            <div class="col-lg-2">
                <label for="is_available">Widoczny</label>
                <select class="form-control" name="is_available">
                    <option value="">Wszystkie</option>
                    <option value="1" @selected(request()->input('is_available') === '1')>Widoczne</option>
                    <option value="0" @selected(request()->input('is_available') === '0')>Niewidoczne</option>
                </select>
            </div>
            <div class="col-lg-2">
                <label for="in_stock">Stan ilościowy</label>
                <select class="form-control" name="in_stock">
                    <option value="">Wszystkie</option>
                    <option value="1" @selected(request()->input('in_stock') === '1')>Większe od zera</option>
                    <option value="0" @selected(request()->input('in_stock') === '0')>Zero lub mniej</option>
                </select>
            </div>
            <div class="col-lg-12 text-center mt-2">
                <button class="btn btn-primary text-white">Wyszukaj</button>
            </div>
        </div>
    </form>
    <div class="row mt-4">
        <div class="col-lg-12 table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Nazwa</th>
                    <th>Kod</th>
                    <th>Cena podstawowa</th>
                    <th>Dostępny</th>
                    <th>Stan Ilościowy</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($products->items() as $product)
                    <tr class="exportable" data-export-id="{{ $product->id }}">
                        <td>
                            {{ $product->name }}
                        </td>
                        <td>
                            {{ $product->code }}
                        </td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->is_available ? 'Tak' : 'Nie' }}</td>
                        <td>{{ $product->in_stock }}</td>
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
            {{ $products->withQueryString()->links() }}
        </div>
        <div class="col-lg-12 text-end">
            <a href="{{ route('admin.product.create') }}" class="btn btn-primary text-white">Dodaj nowy</a>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module">
        $(document).ready(function () {
            $('#category_id').select2();
        });
    </script>
@endpush
