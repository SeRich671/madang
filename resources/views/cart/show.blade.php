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
                                <div class="col-lg-12">
                                    <table class="table table-striped table-responsive text-center">
                                        <thead>
                                        <tr>
                                            <th>Nazwa produktu</th>
                                            <th>Cena / szt.</th>
                                            <th>Ilość opakowań</th>
                                            <th>Szt. w opakowaniu</th>
                                            <th>Razem szt.</th>
                                            <th>Wartość</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($cartItemGroup as $cartItem)
                                            <tr class="align-middle">
                                                <td class="col-lg-3">{{ $cartItem->product->name }}</td>
                                                <td class="col-lg-1">{!! $cartItem->product->discount_price ? '<s>' . $cartItem->product->price . '</s> <span class="text-danger">' . $cartItem->product->discount_price . '</span>' : $cartItem->product->price !!} zł</td>
                                                <td class="col-lg-2"><input min="1" type="number" value="{{ $cartItem->quantity }}" class="form-control" name="quantity[{{$cartItem->id}}]"></td>
                                                <td class="col-lg-2">{{ $cartItem->product->count_in_package }}</td>
                                                <td class="col-lg-1">{{ $cartItem->product->count_in_package * $cartItem->quantity }}</td>
                                                <td class="col-lg-2">{{ number_format((float)(($cartItem->product->discount_price ?: $cartItem->product->price) * $cartItem->quantity), 2, '.', '') }} zł</td>
                                                <td class="col-lg-1 text-end">
                                                    <a class="btn btn-sm btn-danger text-white" href="{{ route('cart.delete', $cartItem) }}"><i class="bi bi-x"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                            <div class="col-lg-12 mt-4 text-end">
                                <a href="{{ route('order.create') }}" class="btn btn-primary text-white">Realizuj zamówienie</a>
                            </div>
                        </form>
                        <form method="post" action="{{ route('cart.empty') }}">
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
