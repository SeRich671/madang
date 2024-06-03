@extends('layouts.app')

@section('content')
    @if(Auth::check() && !auth()->user()->branch_id)
        @include('parts.branch-required')
    @endif

    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @include('parts.department.category-tree', ['categories' => $categories, 'department' => $department])
            </div>
            <div class="col-lg-9">
                <div class="mb-4 bg-white p-4">
                    {{ Breadcrumbs::render('product.show', $department, $category, $product) }}
                </div>
                <div class="p-4 bg-white">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-4 text-center">
                            <img src="{{ asset('storage/' . $product->img_path) }}" class="mw-100" onclick="showProductImage(this.src)" data-bs-toggle="modal" data-bs-target="#productImageModal">
                        </div>
                        <div class="col-lg-8">
                            <div class="text-primary border-primary border-bottom">
                                <h3>{{ $product->name }}</h3>
                            </div>
                            <div class="mt-4">
                                {{ $product->description }}
                            </div>
                            <div class="mt-1">
                                @foreach($product->attributes as $attribute)
                                        <strong>{{ $attribute->name }}: </strong> {{ $attribute->pivot->value }}<br>
                                @endforeach
                            </div>
                            @if(Auth::check() && auth()->user()->branch_id)
                                <hr>
                                <h4>Cena: {{ $product->discount_price ?: $product->price }} zł</h4>
                                <hr>
                                <div class="mt-4">
                                    <form method="POST" action="{{ route('cart.add', $product) }}">
                                        <div class="input-group">
                                            <input name="quantity" type="number" class="form-control" placeholder="Ilość" required>
                                            @csrf
                                            <button type="submit" class="btn btn-primary"><i class="bi bi-cart-check"></i></button>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <hr>
                                <div class="mt-4 text-end">
                                    <a class="btn btn-outline-primary" href="{{ route('login') }}"><i class="bi bi-lock-fill"></i></a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
