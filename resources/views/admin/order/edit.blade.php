@extends('layouts.admin', ['menuName' => 'Zamówienie ' . $order->code_short . '-' . $order->id . ' (' . $order->created_at->format('d.m.Y H:i') . ')'])

@section('content')
    <div class="row">
        <div class="col-lg-12 text-end">
            <a class="btn btn-primary text-white" href="{{ route('admin.order.download', $order) }}">
                PDF
            </a>
        </div>
    </div>
    <div class="row">
        <form method="POST" action="{{ route('admin.order.update', $order) }}">
            @csrf
            @method('PUT')
            <div class="col-lg-12 text-primary">
                <h5>Dane klienta</h5>
                <hr>
            </div>

            <div class="row">
                <div class="col-lg-12 text-center">
                    Klient: <a class="link-primary" href="{{ route('admin.user.edit', $order->user) }}">
                        {{ $order->user->first_name }} {{ $order->user->last_name }}
                    </a>
                </div>
                <div class="col-lg-6">
                    <div class="bg-white p-3 h-100">
                        <div class="row mt-4 mb-3">
                            <label for="address_first_name" class="col-lg-4 col-form-label text-lg-end">Imię</label>

                            <div class="col-lg-4">
                                <input id="address_first_name" type="text" class="form-control @error('address_first_name') is-invalid @enderror" name="address_first_name" value="{{ $order->address_first_name }}" required autocomplete="address_first_name">

                                @error('address_first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="address_last_name" class="col-lg-4 col-form-label text-lg-end">Nazwisko</label>

                            <div class="col-lg-4">
                                <input id="address_last_name" type="text" class="form-control @error('address_last_name') is-invalid @enderror" name="address_last_name" value="{{ $order->address_last_name }}" required autocomplete="address_last_name">

                                @error('address_last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="address_company_name" class="col-lg-4 col-form-label text-lg-end">Firma <small>(opcjonalne)</small></label>

                            <div class="col-lg-4">
                                <input id="address_company_name" type="text" class="form-control @error('address_company_name') is-invalid @enderror" name="address_company_name" value="{{ $order->address_company_name }}" required autocomplete="address_company_name">

                                @error('address_company_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="address_address" class="col-lg-4 col-form-label text-lg-end">Adres</label>

                            <div class="col-lg-4">
                                <input id="address_address" type="text" class="form-control @error('address_address') is-invalid @enderror" name="address_address" value="{{ $order->address_address }}" required autocomplete="address_address">

                                @error('address_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="address_city" class="col-lg-4 col-form-label text-lg-end">Miasto</label>

                            <div class="col-lg-4">
                                <input id="address_city" type="text" class="form-control @error('address_city') is-invalid @enderror" name="address_city" value="{{ $order->address_city }}" required autocomplete="address_city">

                                @error('address_city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="address_zipcode" class="col-lg-4 col-form-label text-lg-end">Kod pocztowy</label>

                            <div class="col-lg-4">
                                <input id="address_zipcode" type="text" class="form-control @error('address_zipcode') is-invalid @enderror" name="address_zipcode" value="{{ $order->address_zipcode }}" required autocomplete="address_zipcode">

                                @error('address_zipcode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="address_phone" class="col-lg-4 col-form-label text-lg-end">Telefon</label>

                            <div class="col-lg-4">
                                <input id="address_phone" type="text" class="form-control @error('address_phone') is-invalid @enderror" name="address_phone" value="{{ $order->address_phone }}" required autocomplete="address_phone">

                                @error('address_phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="bg-white p-3">
                        <div class="row mt-4 mb-3">
                            <label for="billing_first_name" class="col-lg-4 col-form-label text-lg-end">Imię</label>

                            <div class="col-lg-4">
                                <input id="billing_first_name" type="text" class="form-control @error('billing_first_name') is-invalid @enderror" name="billing_first_name" value="{{ $order->billing_first_name }}" required autocomplete="billing_first_name">

                                @error('billing_first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="billing_last_name" class="col-lg-4 col-form-label text-lg-end">Nazwisko</label>

                            <div class="col-lg-4">
                                <input id="billing_last_name" type="text" class="form-control @error('billing_last_name') is-invalid @enderror" name="billing_last_name" value="{{ $order->billing_last_name }}" required autocomplete="billing_last_name">

                                @error('billing_last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="billing_company_name" class="col-lg-4 col-form-label text-lg-end">Firma <small>(opcjonalne)</small></label>

                            <div class="col-lg-4">
                                <input id="billing_company_name" type="text" class="form-control @error('billing_company_name') is-invalid @enderror" name="billing_company_name" value="{{ $order->billing_company_name }}" required autocomplete="billing_company_name">

                                @error('billing_company_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="billing_address" class="col-lg-4 col-form-label text-lg-end">Adres</label>

                            <div class="col-lg-4">
                                <input id="billing_address" type="text" class="form-control @error('billing_address') is-invalid @enderror" name="billing_address" value="{{ $order->billing_address }}" required autocomplete="billing_address">

                                @error('billing_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="billing_city" class="col-lg-4 col-form-label text-lg-end">Miasto</label>

                            <div class="col-lg-4">
                                <input id="billing_city" type="text" class="form-control @error('billing_city') is-invalid @enderror" name="billing_city" value="{{ $order->billing_city }}" required autocomplete="billing_city">

                                @error('billing_city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="billing_zipcode" class="col-lg-4 col-form-label text-lg-end">Kod pocztowy</label>

                            <div class="col-lg-4">
                                <input id="billing_zipcode" type="text" class="form-control @error('billing_zipcode') is-invalid @enderror" name="billing_zipcode" value="{{ $order->billing_zipcode }}" required autocomplete="billing_zipcode">

                                @error('billing_zipcode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="billing_phone" class="col-lg-4 col-form-label text-lg-end">Telefon</label>

                            <div class="col-lg-4">
                                <input id="billing_phone" type="text" class="form-control @error('billing_phone') is-invalid @enderror" name="billing_phone" value="{{ $order->billing_phone }}" required autocomplete="billing_phone">

                                @error('billing_phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="billing_email" class="col-lg-4 col-form-label text-lg-end">Email</label>

                            <div class="col-lg-4">
                                <input id="billing_email" type="email" class="form-control @error('billing_email') is-invalid @enderror" name="billing_email" value="{{ $order->billing_email }}" required autocomplete="billing_email">

                                @error('billing_email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="billing_nip" class="col-lg-4 col-form-label text-lg-end">NIP</label>

                            <div class="col-lg-4">
                                <input id="billing_nip" type="text" class="form-control @error('billing_nip') is-invalid @enderror" name="billing_nip" value="{{ $order->billing_nip }}" required autocomplete="billing_nip">

                                @error('billing_nip')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                {{ $order->description }}
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
                            <th style="cursor:pointer" class="text-primary" onclick="sortTable(1)">ID</th>
                            <th style="cursor:pointer" class="text-primary" onclick="sortTable(2)">Kod</th>
                            <th style="cursor:pointer" class="text-primary" onclick="sortTable(3)">Nazwa</th>
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
                                <td>{{ number_format((float)($line->quantity * $line->product->count_in_package * ($line->product->discount_price ?: $line->product->price)), 2, '.', '') }} zł</td>
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
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("sortableTable");
            switching = true;
            // Set the sorting direction to ascending initially:
            dir = "asc";
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
                    // Check if the two rows should switch place, based on the direction, asc or desc:
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            // If so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            // If so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    // If a switch has been marked, make the switch and mark that a switch has been done:
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    // Each time a switch is done, increase this count:
                    switchcount++;
                } else {
                    // If no switching has been done AND the direction is "asc",
                    // set the direction to "desc" and run the while loop again.
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }
    </script>
@endpush
