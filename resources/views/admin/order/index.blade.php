@extends('layouts.admin', ['menuName' => 'Zamówienia'])

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th>ID zamówienia</th>
                        <th>Data</th>
                        <th>Oddział</th>
                        <th>Klient</th>
                        <th>Wartość</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders->items() as $order)
                        <tr>
                            <td>
                                {{ substr($order->code,0,8) }}-{{ $order->id }}
                                <span class="badge bg-{{ $order->status_color }} text-black">{{ \App\Enums\Order\StatusEnum::getDescription($order->status) }}</span>
                            </td>
                            <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                            <td>{{ $order->branch->name }}</td>
                            <td>{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                            <td>{{ $order->total }} zł</td>
                            <td class="text-end"><a class="btn btn-primary text-white" href="{{ route('admin.order.edit', $order) }}"><i class="bi bi-pen"></i></a></td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <div class="col-lg-12">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
