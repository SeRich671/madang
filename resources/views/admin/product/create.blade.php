@extends('layouts.admin', ['menuName' => 'Tworzenie produktu'])

@section('content')
    <form method="POST" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <div class="col-lg-12">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row mt-4 mb-3">
            <label for="name" class="col-lg-4 col-form-label text-lg-end">Nazwa</label>
            <div class="col-lg-4">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mt-4 mb-3">
            <label for="code" class="col-lg-4 col-form-label text-lg-end">Kod</label>
            <div class="col-lg-4">
                <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" required autocomplete="code">
                @error('code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mt-4 mb-3">
            <label for="categories" class="col-lg-4 col-form-label text-lg-end">Kategorie</label>
            <div class="col-lg-4">
                <select id="categories" class="form-control" name="categories[]" multiple required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->full_parent_name }}
                        </option>
                    @endforeach
                </select>
                @error('categories')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mt-4 mb-3">
            <label for="categories" class="col-lg-4 col-form-label text-lg-end">Oddziały</label>
            <div class="col-lg-4">
                <select id="branches" class="form-control" name="branches[]" multiple required>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">
                            {{ $branch->name }}
                        </option>
                    @endforeach
                </select>
                @error('branches')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mt-4 mb-3">
            <label for="categories" class="col-lg-4 col-form-label text-lg-end">Domyślny oddział</label>
            <div class="col-lg-4">
                <select id="branch_id" class="form-control" name="branch_id">
                    <option value="">Brak</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">
                            {{ $branch->name }}
                        </option>
                    @endforeach
                </select>
                @error('branch_id')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mt-4 mb-3">
            <label for="price" class="col-lg-4 col-form-label text-lg-end">Cena</label>
            <div class="col-lg-4">
                <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" required autocomplete="price">
                @error('price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mt-4 mb-3">
            <label for="discount_price" class="col-lg-4 col-form-label text-lg-end">Przecena</label>
            <div class="col-lg-4">
                <input id="discount_price" type="text" class="form-control @error('discount_price') is-invalid @enderror" name="discount_price" value="{{ old('discount_price') }}" autocomplete="discount_price">
                @error('discount_price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mt-4 mb-3">
            <label for="size_carton" class="col-lg-4 col-form-label text-lg-end">Sztuk w kartonie</label>
            <div class="col-lg-4">
                <input id="size_carton" type="text" class="form-control @error('size_carton') is-invalid @enderror" name="size_carton" value="{{ old('size_carton') }}" required autocomplete="size_carton">
                @error('size_carton')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mt-4 mb-3">
            <label for="count_in_package" class="col-lg-4 col-form-label text-lg-end">Sztuk w komplecie</label>
            <div class="col-lg-4">
                <input id="count_in_package" type="text" class="form-control @error('count_in_package') is-invalid @enderror" name="count_in_package" value="{{ old('count_in_package') }}" required autocomplete="count_in_package">
                @error('count_in_package')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mt-4 mb-3">
            <label for="in_stock" class="col-lg-4 col-form-label text-lg-end">Stan ilościowy</label>
            <div class="col-lg-4">
                <input id="in_stock" type="text" class="form-control @error('in_stock') is-invalid @enderror" name="in_stock" value="{{ old('in_stock') }}" required autocomplete="in_stock">
                @error('in_stock')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

{{--        <div class="row">--}}
{{--            <div class="col-lg-12 text-center">--}}
{{--                <img src="{{ asset('storage/' . $product->img_path) }}" style="max-width: 300px" alt="">--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="row mt-4 mb-3">
            <label for="image" class="col-lg-4 col-form-label text-lg-end">Obraz</label>
            <div class="col-lg-4">
                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" autocomplete="image">
                @error('image')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mt-4 mb-3">
            <label for="description" class="col-lg-4 col-form-label text-lg-end">Opis</label>
            <div class="col-lg-4">
                <textarea class="form-control" id="description" name="description" rows="10"></textarea>
                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-6 offset-lg-4">
                <div class="form-check">
                    <input type="hidden" name="is_available" value="0">
                    <input type="checkbox" value="1" name="is_available" id="is_available" class="form-check-input" @checked(old('is_available'))>

                    <label for="is_available" class="form-check-label">
                        Produkt widoczny
                    </label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-6 offset-lg-4">
                <div class="form-check">
                    <input type="hidden" name="is_recommended" value="0">
                    <input type="checkbox" value="1" name="is_recommended" id="is_recommended" class="form-check-input" @checked(old('is_recommended'))>

                    <label for="is_recommended" class="form-check-label">
                        Wybrane na główną
                    </label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-6 offset-lg-4">
                <div class="form-check">
                    <input type="hidden" name="bought_by_others" value="0">
                    <input type="checkbox" value="1" name="bought_by_others" id="bought_by_others" class="form-check-input" @checked(old('bought_by_others'))>

                    <label for="bought_by_others" class="form-check-label">
                        Wyświetlać w sekcji "Inni kupili również"
                    </label>
                </div>
            </div>
        </div>

        <div class="row mt-4 mb-3">
            <label for="stickers" class="col-lg-4 col-form-label text-lg-end">Naklejki</label>
            <div class="col-lg-4">
                <select id="stickers" class="form-control" name="stickers[]" multiple>
                    @foreach($stickers as $key => $sticker)
                        <option value="{{ $key }}">
                            {{ $sticker }}
                        </option>
                    @endforeach
                </select>
                @error('stickers')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-6 offset-lg-4">
                <div class="form-check">
                    <input type="hidden" name="later_delivery" value="0">
                    <input type="checkbox" value="1" name="later_delivery" id="later_delivery" class="form-check-input" @checked(old('later_delivery'))>

                    <label for="later_delivery" class="form-check-label">
                        Opóźnienie w dostawie
                    </label>
                </div>
            </div>
        </div>

        <div id="dynamic-attributes-container" class="col-lg-12">

        </div>

        <div class="col-lg-12 mt-2 text-center">
            <button type="button" class="btn btn-primary text-white" onclick="addAttribute()">Dodaj atrybut</button>
        </div>

        <div class="col-lg-12 mt-4 text-end">
            <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">
                Powrót
            </a>
            <button class="btn btn-primary text-white">
                Zapisz
            </button>
        </div>
    </form>
@endsection

@push('scripts')
    <script type="module">
        $(document).ready(function () {
            $('#categories').select2();
            $('#branches').select2();
            $('#branch_id').select2();
            $('#stickers').select2();
        });
    </script>

    <script type="application/javascript">
        function addAttribute() {
            const container = document.getElementById('dynamic-attributes-container');
            const index = container.children.length;

            const attributeRow = document.createElement('div');

            attributeRow.innerHTML = `
                <div class="row mt-2">
                    <div class="col-lg-3 offset-lg-4">
                        <select id="attribute" class="form-control" name="attributes[${index}][attribute_id]" required>
                            @foreach($attributes as $attribute)
            <option value="{{ $attribute->id }}">
                                                    {{ $attribute->name }}
            </option>
@endforeach
            </select>
        </div>
        <div class="col-lg-3">
            <input id="value" type="text" class="form-control @error('value') is-invalid @enderror" name="attributes[${index}][value]" value="{{ old('value') }}" required autocomplete="value">
                    </div>
                    <div class="col-lg-1">
                        <button type="button" class="btn btn-danger text-white" onclick="this.parentNode.parentNode.remove();">Usuń</button>
                    </div>
                </div>
                `;
            container.appendChild(attributeRow);
        }
    </script>
@endpush
