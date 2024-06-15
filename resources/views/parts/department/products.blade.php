<div class="bg-white p-3">
    <div class="row">
        <div class="col-lg-12 text-primary">
            <h3>{{ is_string($category) ? $category : $category->name }}</h3>
            <hr>
        </div>
    </div>

    @include('parts.product-filters')

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
