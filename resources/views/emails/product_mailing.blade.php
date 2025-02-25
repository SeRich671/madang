@component('mail::message')
    # Nowe Dostawy

    Oto lista nowych produktów dostępnych w naszym sklepie:

    | Produkt ID | Nazwa | Data Wygaszenia |
    |------------|-------|----------------|
    @foreach($products as $product)
        | {{ $product['product_id'] }} | {{ $product['name'] ?? 'Brak Nazwy' }} | {{ $product['listed_till'] }} |
    @endforeach

    Dziękujemy,<br>
    {{ config('app.name') }}
@endcomponent
