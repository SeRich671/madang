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
                            <td>{{ $order->billing_first_name }} {{ $order->billing_last_name }}</td>
                            <td>{{ $order->billing_company_name }}</td>
                            <td>{{ $order->billing_city }}</td>
                            <td>{{ $order->billing_address }}</td>
                            <td>{{ $order->billing_zipcode }}</td>
                            <td>{{ $order->billing_nip }}</td>
                            <td>{{ $order->billing_phone }}</td>
                            <td><a class="link-primary" href="{{ route('admin.user.edit', $order->user) }}">{{ $order->billing_email }}</a></td>
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
                    @if($order->description)
                    <tfoot>
                        <tr>
                            <th>Uwagi do zamówienia:</th>
                            <td colspan="8">{{ $order->description }}</td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
            <div class="col-lg-12 mt-4 text-primary">
                <h5>Zamówione produkty </h5>
                <hr>
            </div>
            <div class="col-lg-12 table-responsive">
                <table id="sortableTable" class="table">
                    <thead>
                        <tr>
                            <th>Zdjęcie</th>
                            <th onclick="sortTable(1)">ID</th>
                            <th onclick="sortTable(2)">Kod</th>
                            <th onclick="sortTable(3)">Nazwa</th>
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
                                <td>{{ $line->product->id }}</td>
                                <td>{{ $line->product->code }}</td>
                                <td>{{ $line->product->name }}</td>
                                <td>{{ $line->product->count_in_package }}</td>
                                <td><input type="text" name="quantity[{{ $line->id }}]" class="form-control" value="{{ $line->quantity }}"></td>
                                <td>{{ $line->product->count_in_package * $line->quantity }}</td>
                                <td>{!! $line->product->discount_price ? '<s>' . $line->product->price . '</s> <span class="text-danger">' . $line->product->discount_price . '</span>' : $line->product->price !!} zł</td>
                                <td>{{ number_format((float)($line->quantity * ($line->product->discount_price ?: $line->product->price)), 2, '.', '') }} zł</td>
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
                    </tbody>
                </table>
            </div>
            <table class="table">
                <tbody>
                <tr>
                    <td class="bg-white border-0 text-center col-lg-10" colspan="8"></td>
                    <td>{{ $order->total }} zł</td>
                    <td colspan="2">Wartość koszyka</td>
                </tr>
                <tr>
                    <td class="bg-white border-0 text-center" colspan="8"></td>
                    <td>{{ $order->delivery_cost }} zł</td>
                    <td colspan="2">Koszt dostawy</td>
                </tr>
                <tr>
                    <td class="bg-white border-0 text-center" colspan="8"></td>
                    <td>{{ $order->payment_cost }} zł</td>
                    <td colspan="2">Koszt płatności</td>
                </tr>
                <tr>
                    <td class="bg-white border-0 text-center" colspan="8"></td>
                    <td>{{ $order->total + $order->delivery_cost + $order->payment_cost }} zł</td>
                    <td colspan="2">Do zapłaty</td>
                </tr>
                </tbody>
            </table>

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

@push('scripts')
    <script type="application/javascript">
        function sortTable(columnIndex) {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("sortableTable");
            switching = true;
            // Make a loop that will continue until no switching has been done:
            while (switching) {
                // Start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                // Loop through all table rows (except the first, which contains table headers):
                for (i = 1; i < (rows.length - 1); i++) {
                    // Start by saying there should not be switching:
                    shouldSwitch = false;
                    // Get the two elements you want to compare, one from current row and one from the next:
                    x = rows[i].getElementsByTagName("TD")[columnIndex];
                    y = rows[i + 1].getElementsByTagName("TD")[columnIndex];
                    // Check if the two rows should switch place:
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        // If so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
                if (shouldSwitch) {
                    // If a switch has been marked, make the switch and mark that a switch has been done:
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }
        }
    </script>
@endpush
