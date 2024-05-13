@extends('layouts.admin', ['menuName' => 'Zamówienie ' . $order->code_short . '-' . $order->id . ' (' . $order->created_at->format('d.m.Y H:i') . ')'])

@section('content')
    <div class="row">
        <form method="POST" action="{{ route('admin.order.update', $order) }}">
            @csrf
            @method('PUT')
            <div class="col-lg-12 text-primary">
                <h5>Dane klienta</h5>
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
                            <td>{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                            <td>{{ $order->user->company_name }}</td>
                            <td>{{ $order->user->company_city }}</td>
                            <td>{{ $order->user->company_address }}</td>
                            <td>{{ $order->user->company_zipcode }}</td>
                            <td>{{ $order->user->nip }}</td>
                            <td>{{ $order->user->phone }}</td>
                            <td>{{ $order->user->email }}</td>
                        </tr>
                        <tr>
                            <th>Adres dostawy</th>
                            <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                            <td>{{ $order->company_name }}</td>
                            <td>{{ $order->city }}</td>
                            <td>{{ $order->address }}</td>
                            <td>{{ $order->zipcode }}</td>
                            <td>-</td>
                            <td>{{ $order->phone }}</td>
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
                            <th>Niedostępny</th>
                            <th>Usuń</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->lines as $line)
                            <tr class="{{ $line->deleted ? 'table-danger' : ($line->unavailable ? 'table-warning' : 'table-white') }}">
                                <td class="text-center"><img src="{{ asset('storage/' . $line->product->img_path) }}" style="max-height:100px;max-width:100px"></td>
                                <td>{{ $line->product->name }}</td>
                                <td>{{ $line->product->count_in_package }}</td>
                                <td><input type="text" name="quantity[{{ $line->id }}]" class="form-control" value="{{ $line->quantity }}"></td>
                                <td>{{ $line->product->count_in_package * $line->quantity }}</td>
                                <td>{{ $line->product->price_discount ?: $line->product->price }} zł</td>
                                <td>{{ $line->price }} zł</td>
                                <td>
                                    <input type="hidden" name="unavailable[{{ $line->id }}]" value="0">
                                    <input type="checkbox" name="unavailable[{{ $line->id }}]" value="1" @checked($line->unavailable)>
                                </td>
                                <td>
                                    <input type="hidden" name="deleted[{{ $line->id }}]" value="0">
                                    <input type="checkbox" name="deleted[{{ $line->id }}]" value="1"  @checked($line->deleted)>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="6"></td>
                            <td>{{ $order->total }} zł</td>
                            <td colspan="2">Wartość koszyka</td>
                        </tr>
                        <tr>
                            <td colspan="6"></td>
                            <td>{{ $order->delivery_cost }} zł</td>
                            <td colspan="2">Koszt dostawy</td>
                        </tr>
                        <tr>
                            <td colspan="6"></td>
                            <td>{{ $order->payment_cost }} zł</td>
                            <td colspan="2">Koszt płatności</td>
                        </tr>
                        <tr>
                            <td colspan="6"></td>
                            <td>{{ $order->total + $order->delivery_cost + $order->payment_cost }} zł</td>
                            <td colspan="2">Do zapłaty</td>
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
                                <select class="form-control" name="delivery">
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
                                <select class="form-control" name="payment">
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
                                <select class="form-control" name="status">
                                    @foreach(\App\Enums\Order\StatusEnum::asSelectArray() as $key => $description)
                                        <option value="{{ $key }}" @if($order->status == $key) selected @endif>{{ $description }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-lg-4 align-middle">
                                <strong>Komentarz administratora</strong>
                            </td>
                            <td class="col-lg-8">
                                <textarea name="admin_comment" class="form-control" rows="5">{{ $order->admin_comment }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-lg-4 align-middle">
                                <strong>Komentarz dla klienta</strong>
                            </td>
                            <td class="col-lg-8">
                                <textarea name="client_comment" class="form-control" rows="5">{{ $order->client_comment }}</textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-lg-12 text-end mt-4">
                    <button type="submit" class="btn btn-primary text-white">Zapisz zmiany w zamówieniu</button>
                </div>
            </div>

            <div class="col-lg-12 mt-4 text-primary">
                <h5>Historia statusów</h5>
                <hr>
            </div>
            <div class="col-lg-12 table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Komentarz administratora</th>
                            <th>Komentarz dla klienta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->statusLogs()->orderByDesc('id')->get() as $statusLog)
                            <tr>
                                <td>{{ $statusLog->created_at->format('d.m.Y H:i') }}</td>
                                <td>{{ \App\Enums\Order\StatusEnum::getDescription($statusLog->old_status) }} -> {{ \App\Enums\Order\StatusEnum::getDescription($statusLog->new_status) }}</td>
                                <td>{{ $statusLog->admin_comment }}</td>
                                <td>{{ $statusLog->client_comment }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-lg-12 mt-4 text-primary">
                <h5>Historia klienta</h5>
                <hr>
            </div>
            <div class="col-lg-12 table-responsive">
                <table class="table table-striped table-responsive">
                    <thead>
                    <tr>
                        <th>ID zamówienia</th>
                        <th>Data</th>
                        <th>Oddział</th>
                        <th>Klient</th>
                        <th>Wartość</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($order->client_other_orders as $historyOrder)
                            <tr>
                                <td><a class="text-primary" href="{{ route('admin.order.edit', $historyOrder) }}">{{ substr($historyOrder->code,0,8) }}-{{ $historyOrder->id }}</a></td>
                                <td>{{ $historyOrder->created_at->format('d.m.Y H:i') }}</td>
                                <td>{{ $historyOrder->branch->name }}</td>
                                <td>{{ $historyOrder->user->first_name }} {{ $order->user->last_name }}</td>
                                <td>{{ $historyOrder->total }} zł</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
@endsection
