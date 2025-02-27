<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nowe Dostawy</title>
    <style>
        * {
            font-size: 14px;
        }
        body { font-family: 'DejaVu Sans', sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        .product-container {
            margin-bottom: 20px;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            display: flex;
            align-items: center;
        }
        .product-container img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-right: 15px;
            border-radius: 5px;
        }
        .product-container a {
            text-decoration: none;
            color: #3490dc;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>Nowe Dostawy</h1>

@foreach($products as $product)
    <div class="product-container">
        <img src="{{ url('storage/' . $product->img_path) }}" alt="{{ $product->name }}">

        <div>
            @foreach($product->categories->unique('id') as $category)
                <a href="{{ route('product.show', ['product' => $product, 'subdomain' => $category->department->subdomain, 'category' => $category]) }}">
                    {{ $product->name }}
                </a>
                @break
            @endforeach
        </div>
    </div>
@endforeach

<p>Dziękujemy,<br>
    {{ config('app.name') }}</p>

</body>
</html>
