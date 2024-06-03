@extends('layouts.app')

@section('content')
    <div class="container bg-white p-3">
        <div class="row">
            <div class="col-lg-12 mb-2">
                <h3><a class="link-primary" href="{{ route('profile.order.index') }}"><i class="bi bi-caret-left-fill"></i> Powrót</a></h3>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-primary">
                <h5>Faktura / Adres</h5>
                <hr>
            </div>
            <div class="col-lg-12 table-responsive">
                <table class="table bg-white">
                    <thead>
                    <tr>
                        <td></td>
                        <th>Imię i nazwisko</th>
                        <th>Nazwa firmy</th>
                        <th>Miasto</th>
                        <th>Adres</th>
                        <th>Kod pocztowy</th>
                        <th>NIP</th>
                        <th>Telefon</th>
                        <th>Adres e-mail</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>Adres do faktury</th>
                        <td>{{ $order->billing_first_name }} {{ $order->billing_last_name }}</td>
                        <td>{{ $order->billing_company_name }}</td>
                        <td>{{ $order->billing_city }}</td>
                        <td>{{ $order->billing_address }}</td>
                        <td>{{ $order->billing_zipcode }}</td>
                        <td>{{ $order->billing_nip }}</td>
                        <td>{{ $order->billing_phone }}</td>
                        <td>{{ $order->billing_email }}</td>
                    </tr>
                    <tr>
                        <th>Adres dostawy</th>
                        <td>{{ $order->address_first_name }} {{ $order->address_last_name }}</td>
                        <td>{{ $order->address_company_name }}</td>
                        <td>{{ $order->address_city }}</td>
                        <td>{{ $order->address_address }}</td>
                        <td>{{ $order->address_zipcode }}</td>
                        <td>-</td>
                        <td>{{ $order->address_phone }}</td>
                        <td>-</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-12 mt-4 text-primary">
                <h5>Zamówione produkty </h5>
                <hr>
            </div>
            <div class="col-lg-12 table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Zdjęcie</th>
                        <th>Nazwa</th>
                        <th>Sztuk w opakowaniu</th>
                        <th>Ilość opakowań</th>
                        <th>Razem sztuk</th>
                        <th>Cena jednostki</th>
                        <th>Suma</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->lines as $line)
                        <tr class="{{ $line->deleted ? 'table-danger' : ($line->unavailable ? 'table-warning' : 'table-white') }}">
                            <td class="text-center"><img src="{{ asset('storage/' . $line->product->img_path) }}" style="max-height:100px;max-width:100px"></td>
                            <td>{{ $line->product->name }}</td>
                            <td>{{ $line->product->count_in_package }}</td>
                            <td>{{ $line->quantity }}</td>
                            <td>{{ $line->product->count_in_package * $line->quantity }}</td>
                            <td>{{ $line->product->price_discount ?: $line->product->price }} zł</td>
                            <td>{{ $line->quantity * $line->price }} zł</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="bg-white border-0 text-end" colspan="6">Wartość koszyka</td>
                        <td>{{ $order->total }} zł</td>
                    </tr>
                    <tr>
                        <td class="bg-white border-0 text-end" colspan="6">Koszt dostawy</td>
                        <td>{{ $order->delivery_cost }} zł</td>
                    </tr>
                    <tr>
                        <td class="bg-white border-0 text-end" colspan="6">Koszt płatności</td>
                        <td>{{ $order->payment_cost }} zł</td>
                    </tr>
                    <tr>
                        <td class="bg-white border-0 text-end" colspan="6">Do zapłaty</td>
                        <td>{{ $order->total + $order->delivery_cost + $order->payment_cost }} zł</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-lg-12 mt-4 text-primary">
                <h5>Status zamówienia</h5>
                <hr>
            </div>
            <div class="col-lg-12 table-responsive">
                <table class="table table-borderless">
                    <tbody>
                    <tr>
                        <td class="col-lg-4 align-middle">
                            <strong>Sposób dostawy</strong>
                        </td>
                        <td class="col-lg-8">
                            <select class="form-control" name="delivery" disabled>
                                @foreach(\App\Enums\Order\DeliveryEnum::asSelectArray() as $value => $description)
                                    <option value="{{ $value }}" @if($order->delivery == $value) selected @endif>{{ $description }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-lg-4 align-middle">
                            <strong>Metoda płatności</strong>
                        </td>
                        <td class="col-lg-8">
                            <select class="form-control" name="payment" disabled>
                                @foreach(\App\Enums\Order\PaymentEnum::asSelectArray() as $value => $description)
                                    <option value="{{ $value }}" @if($order->payment == $value) selected @endif>{{ $description }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-lg-4 align-middle">
                            <strong>Status</strong>
                        </td>
                        <td class="col-lg-8">
                            <select class="form-control" name="status" disabled>
                                @foreach(\App\Enums\Order\StatusEnum::asSelectArray() as $key => $description)
                                    <option value="{{ $key }}" @if($order->status == $key) selected @endif>{{ $description }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-lg-4 align-middle">
                            <strong>Komentarz dla klienta</strong>
                        </td>
                        <td class="col-lg-8">
                            <textarea name="client_comment" class="form-control" rows="5" disabled>{{ $order->client_comment }}</textarea>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
