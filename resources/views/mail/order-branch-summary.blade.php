<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
    </style>
</head>
<body>
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
<table id="sortableTable" class="table">
    <thead>
    <tr>
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
    @foreach($order->lines as $line)
        <tr class="{{ $line->deleted ? 'table-danger' : ($line->unavailable ? 'table-warning' : 'table-white') }}">
            <td>{{ $line->product->id }}</td>
            <td>{{ $line->product->code }}</td>
            <td>{{ $line->product->name }}</td>
            <td>{{ $line->product->count_in_package }}</td>
            <td>{{ $line->quantity }}</td>
            <td>{{ $line->product->count_in_package * $line->quantity }}</td>
            <td>{!! $line->product->discount_price ? '<s>' . $line->product->price . '</s> <span class="text-danger">' . $line->product->discount_price . '</span>' : $line->product->price !!} zł</td>
            <td>{{ number_format((float)($line->quantity * $line->product->count_in_package * ($line->product->discount_price ?: $line->product->price)), 2, '.', '') }} zł</td>
        </tr>
    @endforeach
    </tbody>
</table>
<br>
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
    </tbody>
</table>
</body>
</html>
