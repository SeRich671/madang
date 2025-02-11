<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
    <style>
        * {
            font-size: 8px;
        }
        body { font-family: 'DejaVu Sans', sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
    </style>
</head>
<body>

{{-- --- Sort the order lines based on the request parameters --- --}}
@php
    // Start with the original collection
    $lines = $order->lines;

    // Check if a sort parameter is present
    if (request()->has('sort')) {
        $sortColumn = request()->input('sort');
        $sortOrder  = request()->input('order', 'asc');

        switch ($sortColumn) {
            case '1': // Sort by product ID
                $lines = $lines->sortBy(function($line) {
                    return $line->product->id;
                }, SORT_REGULAR, $sortOrder === 'desc');
                break;

            case '2': // Sort by product Code
                $lines = $lines->sortBy(function($line) {
                    return $line->product->code;
                }, SORT_REGULAR, $sortOrder === 'desc');
                break;

            case '3': // Sort by product Name
                $lines = $lines->sortBy(function($line) {
                    return $line->product->name;
                }, SORT_REGULAR, $sortOrder === 'desc');
                break;

            // Add more cases if needed
            default:
                // Optionally, apply a default sorting if needed
                break;
        }
    }
@endphp

{{-- ---------------------- Customer Addresses ---------------------- --}}
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
    @if($order->description)
        <tfoot>
        <tr>
            <th>Uwagi do zamówienia:</th>
            <td colspan="8">{{ $order->description }}</td>
        </tr>
        </tfoot>
    @endif
</table>

<br>

{{-- ---------------------- Order Lines Table ---------------------- --}}
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
    </tr>
    </thead>
    <tbody>
    {{-- Use the sorted $lines collection --}}
    @foreach($lines as $line)
        <tr class="{{ $line->deleted ? 'table-danger' : ($line->unavailable ? 'table-warning' : 'table-white') }}">
            <td class="text-center">
                <img src="{{ public_path('storage/' . $line->product->img_path) }}" style="max-height:100px;max-width:100px">
            </td>
            <td>{{ $line->product->id }}</td>
            <td>{{ $line->product->code }}</td>
            <td>{{ $line->product->name }}</td>
            <td>{{ $line->product->count_in_package }}</td>
            <td>{{ $line->quantity }}</td>
            <td>{{ $line->product->count_in_package * $line->quantity }}</td>
            <td>
                {!! $line->product->discount_price
                    ? '<s>' . $line->product->price . '</s> <span class="text-danger">' . $line->product->discount_price . '</span>'
                    : $line->product->price
                !!} zł
            </td>
            <td>{{ number_format((float)($line->quantity * $line->product->count_in_package * ($line->product->discount_price ?: $line->product->price)), 2, '.', '') }} zł</td>
        </tr>
    @endforeach
    </tbody>
</table>

<br>

{{-- ---------------------- Totals Table ---------------------- --}}
<table class="table">
    <tbody>
    <tr>
        <td colspan="2">Wartość koszyka</td>
        <td>{{ $order->total }} zł</td>
    </tr>
    <tr>
        <td colspan="2">Koszt dostawy</td>
        <td>{{ $order->delivery_cost }} zł</td>
    </tr>
    <tr>
        <td colspan="2">Koszt płatności</td>
        <td>{{ $order->payment_cost }} zł</td>
    </tr>
    <tr>
        <td colspan="2">Do zapłaty</td>
        <td>{{ $order->total + $order->delivery_cost + $order->payment_cost }} zł</td>
    </tr>
    </tbody>
</table>

<br>

{{-- ---------------------- Order Details Table ---------------------- --}}
<table class="table table-borderless">
    <tbody>
    <tr>
        <td class="col-lg-4 align-middle">
            <strong>Sposób dostawy</strong>
        </td>
        <td class="col-lg-8">
            {{ \App\Enums\Order\DeliveryEnum::getDescription($order->delivery) }}
        </td>
    </tr>
    <tr>
        <td class="col-lg-4 align-middle">
            <strong>Metoda płatności</strong>
        </td>
        <td class="col-lg-8">
            {{ \App\Enums\Order\PaymentEnum::getDescription($order->payment) }}
        </td>
    </tr>
    <tr>
        <td class="col-lg-4 align-middle">
            <strong>Status</strong>
        </td>
        <td class="col-lg-8">
            {{ \App\Enums\Order\StatusEnum::getDescription($order->status) }}
        </td>
    </tr>
    <tr>
        <td class="col-lg-4 align-middle">
            <strong>Komentarz administratora</strong>
        </td>
        <td class="col-lg-8">
            {{ $order->admin_comment }}
        </td>
    </tr>
    <tr>
        <td class="col-lg-4 align-middle">
            <strong>Komentarz dla klienta</strong>
        </td>
        <td class="col-lg-8">
            {{ $order->client_comment }}
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>
