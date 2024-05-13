@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="border-bottom border-primary bg-white p-3">
            <h3 class="text-primary">Podsumowanie</h3>
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
                                <th>Oddział</th>
                                <th>Cena / szt.</th>
                                <th>Ilość opakowań</th>
                                <th>Szt. w opakowaniu</th>
                                <th>Razem szt.</th>
                                <th>Wartość</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cartItemGroup as $cartItem)
                                <tr class="align-middle">
                                    <td class="col-lg-3">{{ $cartItem->product->name }}</td>
                                    <td class="col-lg-3">{{ $cartItem->branch->name }}</td>
                                    <td class="col-lg-1">{{ $cartItem->product->discount_price ?: $cartItem->product->price }}</td>
                                    <td class="col-lg-2">{{ $cartItem->quantity }}</td>
                                    <td class="col-lg-2">{{ $cartItem->product->count_in_package }}</td>
                                    <td class="col-lg-1">{{ $cartItem->product->count_in_package * $cartItem->quantity }}</td>
                                    <td class="col-lg-2">{{ ($cartItem->product->discount_price ?: $cartItem->product->price) * $cartItem->quantity }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach

                <div class="col-lg-12 mt-4">
                    <h5 class="text-primary">Uwagi do zamówienia</h5>
                    <hr>
                </div>
                <div class="col-lg-12 mb-4">
                    {{ $anyOrder->description }}
                </div>

                <div class="col-lg-6 mt-4">
                    <div class="border-bottom border-primary bg-white p-3">
                        <h5 class="text-primary">Adres dostawy</h5>
                    </div>
                    <div class="bg-white p-3">
                        <table class="table table-striped table-responsive">
                            <tbody>
                                <tr>
                                    <th>Imię</th>
                                    <td>{{ $anyOrder->first_name }}</td>
                                </tr>
                                <tr>
                                    <th>Nazwisko</th>
                                    <td>{{ $anyOrder->last_name }}</td>
                                </tr>
                                <tr>
                                    <th>Firma</th>
                                    <td>{{ $anyOrder->company_name }}</td>
                                </tr>
                                <tr>
                                    <th>Adres</th>
                                    <td>{{ $anyOrder->address }}</td>
                                </tr>
                                <tr>
                                    <th>Miasto</th>
                                    <td>{{ $anyOrder->city }}</td>
                                </tr>
                                <tr>
                                    <th>Kod pocztowy</th>
                                    <td>{{ $anyOrder->zipcode }}</td>
                                </tr>
                                <tr>
                                    <th>Telefon</th>
                                    <td>{{ $anyOrder->phone }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-6 mt-4">
                    <div class="border-bottom border-primary bg-white p-3">
                        <h5 class="text-primary">Koszty</h5>
                    </div>
                    <div class="bg-white p-3">
                        <table class="table table-striped table-responsive">
                            <tbody>
                                <tr>
                                    <td colspan="2" class="col-lg-6 text-start">Suma koszyka</td>
                                    <td class="col-lg-6 text-end">{{ $ordersTotal }} zł</td>
                                </tr>
                                @foreach($orders as $order)
                                    <tr>
                                        <th class="col-lg-5" rowspan="2">
                                            {{ $order->branch->name }}
                                        </th>
                                        <td class="col-lg-5">
                                            Dostawa - {{ \App\Enums\Order\DeliveryEnum::getDescription($order->delivery) }}
                                        </td>
                                        <td class="col-lg-2 text-end">
                                            {{ $order->delivery_cost }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Płatność - {{ \App\Enums\Order\PaymentEnum::getDescription($order->payment) }}</td>
                                        <td class="text-end">
                                            {{ $order->payment_cost }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2" class="col-lg-6 text-start">Do zapłaty</td>
                                    <td class="col-lg-6 text-end">{{ $ordersTotal + $ordersAdditional }} zł</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-12 mt-4 text-end">
                    <form method="POST" action="{{ route('order.confirm', $anyOrder->code) }}">
                        @csrf
                        <button type="submit" class="btn btn-primary text-white">Realizuj zamówienie</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
