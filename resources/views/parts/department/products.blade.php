<div class="bg-white">
    <div class="row p-3">
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
    <div class="row p-3">
        <div class="col-lg-12">
            {!! $products->links() !!}
        </div>
    </div>
</div>
