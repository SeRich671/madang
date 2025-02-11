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
<table>
    <thead>
    <tr>
        @if((int)request()->input('has_image'))
        <th>Obraz</th>
        @endif
        <th>Informacje</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($products as $key => $product)
        <tr @if(isset($exportCount) && $exportCount != 'all' && $key > 0 && $key % $exportCount == 0) style="page-break-before: always;" @endif>
            @if((int)request()->input('has_image'))
            <td><img src="{{ public_path('storage/' . $product->img_path) }}" style="max-height: 200px; max-width: 200px" alt="Product Image"></td>
            @endif
            <td>
                {{ $product->name }}<br>
                Cena: {!! $product->discount_price ? '<s>' . $product->price . '</s> <span class="text-danger">' . $product->discount_price . '</span>'  : $product->price !!} zł<br>
                @foreach($product->attributes as $attribute)
                    <strong>{{ $attribute->name }}: </strong> {{ $attribute->pivot->value }}<br>
                @endforeach
                {{ $product->description }}<br>
                @foreach($product->categories->unique('id') as $category)
                    <a href="{{ route('product.show', ['product' => $product, 'subdomain' => $category->department->subdomain, 'category' => $category]) }}">
                        {{ route('product.show', ['product' => $product, 'subdomain' => $category->department->subdomain, 'category' => $category]) }}
                    </a>
                    @break(true)
                @endforeach
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
