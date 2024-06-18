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
                <div class="col-lg-12 mt-4 table-responsive">
                    <table class="table  table-striped">
                        <thead>
                        <tr>
                            <th>Kod zamówienia</th>
                            <th>ID zamówienia</th>
                            <th>Oddział</th>
                            <th>Dostawa</th>
                            <th>Płatność</th>
                            <th>Data zamówienia</th>
                            <th colspan="2">Akcje</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(collect($orders->items())->groupBy('code') as $orderGroup)
                            @php $first = true; @endphp
                            @foreach($orderGroup as $order)
                                <tr>
                                    <!-- Group header with rowspan -->
                                    @if($first)
                                        <td style="vertical-align: middle;" class="text-center" rowspan="{{ count($orderGroup) }}">{{ substr($order->code, 0, 8) }}</td>
                                    @endif
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->branch->name }}</td>
                                    <td>{{ \App\Enums\Order\DeliveryEnum::getDescription($order->delivery) }}</td>
                                    <td>{{ \App\Enums\Order\PaymentEnum::getDescription($order->payment) }}</td>
                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                    <td class="text-end"><a class="btn btn-primary text-white" href="{{ route('profile.order.show', $order) }}">Podgląd</a></td>
                                    @if($first)
                                        <td style="vertical-align: middle;" class="text-center" rowspan="{{ count($orderGroup) }}">
                                            <form method="POST" class="recreate" action="{{ route('profile.order.recreate', $order) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-primary text-white">
                                                    Złóż ponownie
                                                </button>
                                            </form>
                                        </td>
                                        @php $first = false; @endphp
                                    @endif
                                </tr>
                            @endforeach
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

@push('scripts')
    <script type="module">
        $(document).ready(function () {
            $('.recreate').submit(function (e) {
                e.preventDefault();
                @if(cart_count() > 0)
                if(confirm("Twój koszyk nie jest pusty. Czy na pewno chcesz wyczyścić koszyk i dodać produkty z tego zamówienia?")) {
                    e.currentTarget.submit();
                }
                @endif
            })
        });
    </script>
@endpush
