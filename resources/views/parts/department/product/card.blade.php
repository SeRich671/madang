<div class="card h-100 rounded-0 exportable" id="product_{{ $product->id }}" data-export-id="{{ $product->id }}">
    <div class="card-header rounded-0 {{ in_array($product->id, cart_ids()) ? 'bg-primary text-white' : '' }}">
        <h5 class="card-title">{{ $product->name }}</h5>
    </div>
    <img src="{{ asset('storage/' . $product->img_path) }}" style="background-color:white;height: 200px; width: auto; object-fit: contain; background-repeat: no-repeat;" alt="..." onclick="showProductImage(this.src)" data-bs-toggle="modal" data-bs-target="#productImageModal">
    <div class="card-body bg-white">
        @if($product->count_in_package)
            <div>
                {{ $product->count_in_package }} szt./komplet
            </div>
        @endif
        @if($product->size_carton)
            <div>
                {{ $product->size_carton }} szt./karton
            </div>
        @endif
    </div>
    <div class="card-footer">
        @if(Auth::check() && auth()->user()->branch_id && $product->is_available)
            <form method="POST" action="{{ route('cart.add', $product) }}">
                @if(request()->route()->getName() === 'search.index')
                    <div class="pb-2">
                        <strong>Kategorie: </strong>
                        @foreach($product->categories->unique('department.name')->values() as $key => $category)
                            <a class="link link-primary" href="{{ route('product.show', ['product' => $product, 'category' => $category, 'subdomain' => $category->department->subdomain]) . '?want_back=1&prev_url=' . base64_encode(request()->fullUrl()) }}">
                                <strong>"{{ $category->department->name }}"</strong>
                            </a>@if($key != $product->categories->unique('department.name')->count() - 1), @endif

                        @endforeach

                    </div>
                @endif
                <div class="pb-2">
                    <strong>Cena: {!! $product->discount_price ? '<s>' . $product->price . '</s> <span class="text-danger">' . $product->discount_price . '</span>'  : $product->price !!} zł</strong>
                </div>
                <div class="input-group">
                    <input name="quantity" min="1" type="number" class="form-control" placeholder="Ilość" value="1" required>
                    <input type="hidden" name="to_div" value="{{ '#product_' . $product->id }}"/>
                    @csrf
                    <button type="submit" class="btn btn-primary text-white"><i class="bi bi-cart-check"></i></button>
                    <a class="btn btn-outline-primary" href="{{ route('product.show', ['product' => $product, 'category' => is_string($category) ? null :$category, 'subdomain' => current_subdomain() ?: $product->categories()->first()->department->subdomain]) }}"><i class="bi bi-arrow-right"></i></a>
                </div>
            </form>
        @elseif(Auth::check() && !$product->is_available)
            Produkt obecnie niedostępny
        @else
            <div class="btn-group text-center" role="group">
                <a class="btn btn-outline-primary" href="{{ route('login') }}"><i class="bi bi-lock-fill"></i></a>
                <a class="btn btn-outline-primary" href="{{ route('product.show', ['product' => $product, 'category' => is_string($category) ? null :$category, 'subdomain' => current_subdomain() ?: $product->categories()->first()->department->subdomain]) }}"><i class="bi bi-arrow-right"></i></a>
            </div>
        @endif
    </div>
</div>
