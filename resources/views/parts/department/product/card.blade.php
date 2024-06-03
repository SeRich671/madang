<div class="card h-100 rounded-0" id="product_{{ $product->id }}">
    <div class="card-header rounded-0 {{ in_array($product->id, cart_ids()) ? 'bg-primary' : '' }}">
        <h5 class="card-title">{{ $product->name }}</h5>
    </div>
    <img src="{{ asset('storage/' . $product->img_path) }}" style="background-color:white;height: 200px; width: auto; object-fit: contain; background-repeat: no-repeat;" alt="..." onclick="showProductImage(this.src)" data-bs-toggle="modal" data-bs-target="#productImageModal">
    <div class="card-body bg-white">

    </div>
    <div class="card-footer">
        @if(Auth::check() && auth()->user()->branch_id)
            <form method="POST" action="{{ route('cart.add', $product) }}">
                <div class="pb-2">
                    <strong>Cena: {{ $product->discount_price ?: $product->price }} zł</strong>
                </div>
                <div class="input-group">
                    <input name="quantity" type="number" class="form-control" placeholder="Ilość" required>
                    <input type="hidden" name="to_div" value="{{ '#product_' . $product->id }}"/>
                    @csrf
                    <button type="submit" class="btn btn-primary"><i class="bi bi-cart-check"></i></button>
                    <a class="btn btn-outline-primary" href="{{ route('product.show', ['product' => $product, 'category' => is_string($category) ? null :$category, 'subdomain' => current_subdomain() ?: $product->categories()->first()->department->subdomain]) }}"><i class="bi bi-arrow-right"></i></a>
                </div>
            </form>
        @else
            <div class="btn-group text-center" role="group">
                <a class="btn btn-outline-primary" href="{{ route('login') }}"><i class="bi bi-lock-fill"></i></a>
                <a class="btn btn-outline-primary" href="{{ route('product.show', ['product' => $product, 'category' => is_string($category) ? null :$category, 'subdomain' => current_subdomain() ?: $product->categories()->first()->department->subdomain]) }}"><i class="bi bi-arrow-right"></i></a>
            </div>
        @endif
    </div>
</div>
