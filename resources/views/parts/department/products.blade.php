<div class="bg-white p-3">
    <div class="row">
        <div class="col-lg-12 text-primary">
            <h3>{{ is_string($category) ? $category : $category->name }}</h3>
            <hr>
        </div>
    </div>

    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    Sortowanie i filtry
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="sort_type">Rodzaj sortowania</label>
                            <select class="form-control" name="sort_type" id="sort_type">
                                <option value="name" selected>Po nazwie</option>
                                <option value="price">Po cenie</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="sort_type">Kierunek sortowania</label>
                            <select class="form-control" name="sort_type" id="sort_type">
                                <option value="asc" selected>Rosnąco</option>
                                <option value="desc">Malejąco</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="sort_type">Produktów na stronie</label>
                            <select class="form-control" name="per_page" id="sort_type">
                                <option value="12" selected>12</option>
                                <option value="24">24</option>
                                <option value="60">60</option>
                                <option value="all">Wszystkie</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-4">
                            <label for="price_from">Cena</label><br>
                            <div class="input-group">
                                <input name="price[from]" type="number" class="form-control" placeholder="Od">
                                <input name="price[to]" type="number" class="form-control" placeholder="Do">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label for="price_from">Opakowanie</label><br>
                            <div class="input-group">
                                <input name="count_in_package[from]" type="number" class="form-control" placeholder="Od">
                                <input name="count_in_package[to]" type="number" class="form-control" placeholder="Do">
                            </div>
                        </div>
                        <div class="col-lg-2 text-center justify-content-center">
                            <label for="show_unavailable">Pokaż niedostępne</label><br>
                            <input type="hidden" name="show_unavailable" value="0">
                            <input id="show_unavailable" name="show_unavailable" class="form-check d-inline" type="checkbox">
                        </div>
                        <div class="col-lg-2 text-center justify-content-center">
                            <label for="sticker">Miejsce na naklejkę</label><br>
                            <input type="hidden" name="sticker" value="0">
                            <input id="sticker" class="form-check d-inline" type="checkbox" value="1">
                        </div>
                        <div class="col-lg-12 mt-2">
                            <label for="material">Material</label><br>
                            <select class="form-control" name="material" id="material" multiple>
                                @foreach($materials as $material)
                                    <option value="{{ $material }}" selected>{{ $material }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-12">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        @foreach($products->items() as $product)
            <div class="col-lg-4 mb-2 ">
                @include('parts.department.product.card', ['product' => $product, 'category' => $category])
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-lg-12">
            {!! $products->withQueryString()->links() !!}
        </div>
    </div>
</div>

@push('scripts')
    <script type="module">
        $(document).ready(function () {
            $('#material').select2();
        });
    </script>
@endpush
