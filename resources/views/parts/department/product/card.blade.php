<div class="card h-100 rounded-0">
    <div class="card-header {{ in_array($product->id, cart_ids()) ? 'bg-primary' : '' }}">
        <h5 class="card-title">{{ $product->name }}</h5>
    </div>
    <img src="{{ asset('storage/' . $product->img_path) }}" style="background-color:white;height: 200px; width: auto; object-fit: contain; background-repeat: no-repeat;" alt="...">
    <div class="card-body">

{{--        <a href="{{ route('department.index', $department->subdomain) }}" class="btn btn-primary text-white rounded-0">Przejdź</a>--}}
    </div>
    <div class="card-footer">
        @if(Auth::check())
            <form method="POST" action="{{ route('cart.add', $product) }}">

                <div class="input-group">
                    <input name="quantity" type="number" class="form-control" placeholder="Ilość" required>
                    @csrf
                    <button type="submit" class="btn btn-primary"><i class="bi bi-cart-check"></i></button>
                    <a class="btn btn-outline-primary" href="{{ route('product.show', ['product' => $product, 'category' => $category, 'subdomain' => current_subdomain()]) }}"><i class="bi bi-arrow-right"></i></a>
                </div>
            </form>
        @else
            <div class="btn-group text-center" role="group">
                <a class="btn btn-outline-primary" href="{{ route('login') }}"><i class="bi bi-lock-fill"></i></a>
                <a class="btn btn-outline-primary" href="{{ route('product.show', ['product' => $product, 'category' => $category, 'subdomain' => current_subdomain()]) }}"><i class="bi bi-arrow-right"></i></a>
            </div>
        @endif
    </div>
</div>
