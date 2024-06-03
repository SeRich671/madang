@extends('layouts.admin', ['menuName' => 'Edycja produktu ' . $product->name])

@section('content')
    <form method="POST" action="{{ route('admin.product.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
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
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $product->name }}" required autocomplete="name">
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
                <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ $product->code }}" required autocomplete="code">
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
                        <option value="{{ $category->id }}" @selected(in_array($category->id, $product->categories->pluck('id')->toArray()))>
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
                        <option value="{{ $branch->id }}" @selected(in_array($branch->id, $product->branches->pluck('id')->toArray()))>
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
                <select id="branch_id" class="form-control" name="branch_id" required>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" @selected($branch->id == $product->branches->where('pivot.is_default', 1)->first()?->id)>
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
                <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ $product->price }}" required autocomplete="price">
                @error('price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mt-4 mb-3">
            <label for="size_carton" class="col-lg-4 col-form-label text-lg-end">Sztuk w kartonie</label>
            <div class="col-lg-4">
                <input id="size_carton" type="text" class="form-control @error('size_carton') is-invalid @enderror" name="size_carton" value="{{ $product->size_carton }}" required autocomplete="size_carton">
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
                <input id="count_in_package" type="text" class="form-control @error('count_in_package') is-invalid @enderror" name="count_in_package" value="{{ $product->count_in_package }}" required autocomplete="count_in_package">
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
                <input id="in_stock" type="text" class="form-control @error('in_stock') is-invalid @enderror" name="in_stock" value="{{ $product->in_stock }}" required autocomplete="in_stock">
                @error('in_stock')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 text-center">
                <img src="{{ asset('storage/' . $product->img_path) }}" style="max-width: 300px" alt="">
            </div>
        </div>

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
                <textarea class="form-control" id="description" name="description" rows="10">{{ $product->description }}</textarea>
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
                    <input type="checkbox" value="1" name="is_available" id="is_available" class="form-check-input" @checked($product->is_available)>

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
                    <input type="checkbox" value="1" name="is_recommended" id="is_recommended" class="form-check-input" @checked($product->is_recommended)>

                    <label for="is_recommended" class="form-check-label">
                        Wybrane na główną
                    </label>
                </div>
            </div>
        </div>

        <div id="dynamic-attributes-container" class="col-lg-12">
            @foreach($product->attributes as $key => $productAttribute)
                <div class="row mt-2">
                    <div class="col-lg-3 offset-lg-4">
                        <select id="attribute" class="form-control" name="attributes[{{ $key }}][attribute_id]" required>
                            @foreach($attributes as $attribute)
                                <option value="{{ $attribute->id }}" @selected($attribute->id == $productAttribute->id)>
                                    {{ $attribute->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <input id="value" type="text" class="form-control @error('value') is-invalid @enderror" name="attributes[{{ $key }}][value]" value="{{ $productAttribute->pivot->value }}" required autocomplete="value">
                    </div>
                    <div class="col-lg-1">
                        <button type="button" class="btn btn-danger text-white" onclick="this.parentNode.parentNode.remove();">Usuń</button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="col-lg-12 mt-2 text-center">
            <button type="button" class="btn btn-primary text-white" onclick="addAttribute()">Dodaj atrybut</button>
        </div>

        <div class="col-lg-12 mt-4 text-end">
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
