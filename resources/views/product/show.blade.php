@extends('layouts.app')

@section('content')
    @if(Auth::check() && !auth()->user()->branch_id)
        @include('parts.branch-required')
    @endif

    <div class="container">
        <div class="row">
            @if($categories->count())
                <div class="col-lg-3">
                    @include('parts.department.category-tree', ['categories' => $categories, 'department' => $department])
                </div>
            @endif
            <div class="@if($categories->count())col-lg-9 @else col-lg-12 @endif">
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
                            <div class="mt-4">
                                {{ $product->description }}
                            </div>
                            <div class="mt-1">
                                @foreach($product->attributes as $attribute)
                                        <strong>{{ $attribute->name }}: </strong> {{ $attribute->pivot->value }}<br>
                                @endforeach
                            </div>

                            @if($product->stickers->isNotEmpty())
                            <div class="mt-1">
                                <strong>Dostępne naklejki:</strong><br>
                                @foreach($product->stickers as $sticker)
                                    <strong><a href="{{ route('product.show', ['product' => $sticker, 'subdomain' => $department->subdomain]) }}">{{ $sticker->name }}</a></strong> <br>
                                @endforeach
                            </div>
                            @endif

                            @if($product->later_delivery)
                                <div class="mt-1">
                                    <strong class="text-danger">Opóźnienie w dostawie</strong>
                                </div>
                            @endif
                            @if(Auth::check() && auth()->user()->branch_id && $product->is_available)
                                <hr>
                                <h4>Cena: {!! $product->discount_price ? '<s>' . $product->price . '</s> <span class="text-danger">' . $product->discount_price . '</span>'  : $product->price !!} zł</h4>
                                <hr>
                                <div class="mt-4">
                                    <form method="POST" action="{{ route('cart.add', $product) }}">
                                        <div class="input-group">
                                            <input name="quantity" min="1" type="number" class="form-control" placeholder="Ilość" required>
                                            @csrf
                                            <button type="submit" class="btn btn-primary"><i class="bi bi-cart-check"></i></button>
                                        </div>
                                    </form>
                                </div>
                            @elseif(Auth::check() && !$product->is_available)
                                Produkt obecnie niedostępny
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
        @if($otherProducts->count())
        <div class="row">
            <div class="col-lg-12 mt-5 bg-white p-4">
                <div class="text-primary border-primary border-bottom">
                    <h3>Inni kupili również</h3>
                </div>
                <div class="row">
                    @foreach($otherProducts as $product)
                        <div class="col-lg-4 mt-2">
                            @include('parts.department.product.card', $product)
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
