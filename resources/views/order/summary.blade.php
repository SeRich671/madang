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
                                    <td class="col-lg-3">
                                        {{ $cartItem->product->name }}
                                        @if($cartItem->product->later_delivery)
                                            <div class="mt-1">
                                                <strong class="text-danger">Opóźnienie w dostawie</strong>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="col-lg-3">{{ $cartItem->branch->name }}</td>
                                    <td class="col-lg-1">{!! $cartItem->product->discount_price ? '<s>' . $cartItem->product->price . '</s> <span class="text-danger">' . $cartItem->product->discount_price . '</span>'  : $cartItem->product->price !!} zł</td>
                                    <td class="col-lg-2">{{ $cartItem->quantity }}</td>
                                    <td class="col-lg-2">{{ $cartItem->product->count_in_package }}</td>
                                    <td class="col-lg-1">{{ $cartItem->product->count_in_package * $cartItem->quantity }}</td>
                                    <td class="col-lg-2">{{ number_format((float)(($cartItem->product->discount_price ?: $cartItem->product->price) * $cartItem->quantity * $cartItem->product->count_in_package), 2, '.', '') }} zł</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach

                <div class="col-lg-6 mt-4">
                    <div class="border-bottom border-primary bg-white p-3">
                        <h5 class="text-primary">Adres dostawy</h5>
                    </div>
                    <div class="bg-white p-3">
                        <table class="table table-striped table-responsive">
                            <tbody>
                            <tr>
                                <th>Imię</th>
                                <td>{{ $anyOrder->address_first_name }}</td>
                            </tr>
                            <tr>
                                <th>Nazwisko</th>
                                <td>{{ $anyOrder->address_last_name }}</td>
                            </tr>
                            <tr>
                                <th>Firma</th>
                                <td>{{ $anyOrder->address_company_name }}</td>
                            </tr>
                            <tr>
                                <th>Adres</th>
                                <td>{{ $anyOrder->address_address }}</td>
                            </tr>
                            <tr>
                                <th>Miasto</th>
                                <td>{{ $anyOrder->address_city }}</td>
                            </tr>
                            <tr>
                                <th>Kod pocztowy</th>
                                <td>{{ $anyOrder->address_zipcode }}</td>
                            </tr>
                            <tr>
                                <th>Telefon</th>
                                <td>{{ $anyOrder->address_phone }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-6 mt-4">
                    <div class="border-bottom border-primary bg-white p-3">
                        <h5 class="text-primary">Dane do faktury</h5>
                    </div>
                    <div class="bg-white p-3">
                        <table class="table table-striped table-responsive">
                            <tbody>
                            <tr>
                                <th>Imię</th>
                                <td>{{ $anyOrder->billing_first_name }}</td>
                            </tr>
                            <tr>
                                <th>Nazwisko</th>
                                <td>{{ $anyOrder->billing_last_name }}</td>
                            </tr>
                            <tr>
                                <th>Firma</th>
                                <td>{{ $anyOrder->billing_company_name }}</td>
                            </tr>
                            <tr>
                                <th>Adres</th>
                                <td>{{ $anyOrder->billing_address }}</td>
                            </tr>
                            <tr>
                                <th>Miasto</th>
                                <td>{{ $anyOrder->billing_city }}</td>
                            </tr>
                            <tr>
                                <th>Kod pocztowy</th>
                                <td>{{ $anyOrder->billing_zipcode }}</td>
                            </tr>
                            <tr>
                                <th>Telefon</th>
                                <td>{{ $anyOrder->billing_phone }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $anyOrder->billing_email }}</td>
                            </tr>
                            <tr>
                                <th>Nip</th>
                                <td>{{ $anyOrder->billing_nip }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-6 mt-4">
                    <div class="border-bottom border-primary bg-white">
                        <h5 class="text-primary">Uwagi do zamówienia</h5>
                    </div>
                    <div class="bg-white p-3">
                        {{ $anyOrder->description }}
                    </div>
                </div>

                <div class="col-lg-6 mt-4">
                    <div class="border-bottom border-primary bg-white">
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
                                            {{ $order->delivery_cost }} zł
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Płatność - {{ \App\Enums\Order\PaymentEnum::getDescription($order->payment) }}</td>
                                        <td class="text-end">
                                            {{ $order->payment_cost }} zł
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
