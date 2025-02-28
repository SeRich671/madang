@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="border-bottom border-primary bg-white p-3">
            <h3 class="text-primary">Koszyk</h3>
        </div>
        <div class="bg-white">
            <div class="row p-3">
                <div class="col-lg-12">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
                    @if($cartItemGroups->count())
                        <form method="POST" action="{{ route('cart.recalculate') }}">
                            @csrf
                            <div class="col-lg-12 my-1 text-center">
                                <button type="submit" class="btn btn-primary text-white">Przelicz koszyk</button>
                            </div>
                            @foreach($cartItemGroups as $department => $cartItemGroup)
                                <div class="col-lg-12">
                                    <h5 class="text-primary">{{ $department }}</h5>
                                    <hr>
                                </div>
                                <div class="col-lg-12 table-responsive">
                                    <table class="table table-striped table-responsive text-center">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Nazwa produktu</th>
                                            <th>Cena / szt.</th>
                                            <th>Ilość opakowań</th>
                                            <th>Szt. w opakowaniu</th>
                                            <th>Szt. w kartonie</th>
                                            <th>Razem szt.</th>
                                            <th>Wartość</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($cartItemGroup as $cartItem)
                                            <tr class="align-middle">
                                                <td>
                                                    <img src="{{ asset('storage/' . $cartItem->product->img_path) }}" style="background-color:white; max-width:100px; object-fit:contain; background-repeat:no-repeat;" alt="..." onclick="showProductImage(this.src)" data-bs-toggle="modal" data-bs-target="#productImageModal">
                                                </td>
                                                <td class="col-lg-3">
                                                    {{ $cartItem->product->name }}
                                                    @if($cartItem->product->later_delivery)
                                                        <div class="mt-1">
                                                            <strong class="text-danger">Opóźnienie w dostawie</strong>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="col-lg-1">
                                                    {!! $cartItem->product->discount_price
                                                        ? '<s>' . $cartItem->product->price . '</s> <span class="text-danger">' . $cartItem->product->discount_price . '</span>'
                                                        : $cartItem->product->price
                                                    !!}&nbsp;zł
                                                </td>

                                                <td class="col-lg-2"><input min="1" type="number" value="{{ $cartItem->quantity }}" class="form-control" name="quantity[{{$cartItem->id}}]"></td>
                                                <td class="col-lg-2">{{ $cartItem->product->count_in_package }}</td>
                                                <td class="col-lg-2">{{ $cartItem->product->size_carton }}</td>
                                                <td class="col-lg-1">{{ $cartItem->product->count_in_package * $cartItem->quantity }}</td>
                                                <td class="col-lg-2">{{ number_format((float)(($cartItem->product->discount_price ?: $cartItem->product->price) * $cartItem->quantity * $cartItem->product->count_in_package), 2, '.', '') }}&nbsp;zł</td>
                                                <td class="col-lg-1 text-end">
                                                    <a class="btn btn-sm btn-danger text-white" href="{{ route('cart.delete', $cartItem) }}"><i class="bi bi-x"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                            <div class="col-lg-12 mt-4 text-center">
                                <a href="{{ route('order.create') }}" class="btn btn-primary text-white">Realizuj zamówienie</a>
                            </div>
                        </form>
                        <form method="post" action="{{ route('cart.empty') }}" onsubmit="return confirm('Czy na pewno chcesz opróżnić koszyk?');">
                            @csrf
                            <div class="col-lg-12 my-1 text-center">
                                <button type="submit" class="btn btn-danger text-white">Opróżnij koszyk</button>
                            </div>
                        </form>
                @else
                        <div class="text-center">
                            Koszyk jest pusty
                        </div>
                    @endif
            </div>
        </div>
    </div>
@endsection
