@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="border-bottom border-primary bg-white p-3">
            <h3 class="text-primary">Moje zamówienia</h3>
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
                <div class="col-lg-12 mt-4">
                    <table class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Kod zamówienia</th>
                                <th>Oddział</th>
                                <th>Dostawa</th>
                                <th>Płatność</th>
                                <th>Data zamówienia</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders->items() as $order)
                                <tr>
                                    <td>{{ substr($order->code, 0, 8) . '-' . $order->id }}</td>
                                    <td>{{ $order->branch->name }}</td>
                                    <td>{{ \App\Enums\Order\DeliveryEnum::getDescription($order->delivery) }}</td>
                                    <td>{{ \App\Enums\Order\PaymentEnum::getDescription($order->payment) }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td class="text-end"><a class="btn btn-primary text-white" href="{{ route('profile.order.show', $order) }}">Podgląd</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-12">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
