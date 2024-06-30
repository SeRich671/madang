@extends('layouts.admin', ['menuName' => 'Zamówienia'])

@section('content')
    <form method="GET" action="{{ url()->current() }}">
        <div class="row">
            <div class="col-lg-4">
                <label for="id">ID zamówienia</label>
                <input type="text" class="form-control" name="id" id="id" value="{{ request()->input('id') }}">
            </div>
            <div class="col-lg-4">
                <label for="code">ID zamówienia klienta</label>
                <input type="text" class="form-control" name="code" id="code" value="{{ request()->input('code') }}">
            </div>
            <div class="col-lg-4">
                <label for="query">Imię, nazwisko, adres e-mail</label>
                <input type="text" class="form-control" name="query" id="query" value="{{ request()->input('query') }}">
            </div>
            <div class="col-lg-4">
                <label for="status">Status</label>
                <select class="form-control" name="status">
                    <option value="">Wszystkie</option>
                    @foreach($statuses as $key => $status)
                        <option value="{{ $key }}" @selected($key == request()->input('status'))>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-4">
                <label for="date_from">Data od</label>
                <input type="date" class="form-control" name="date_from" id="date_from" value="{{ request()->input('date_from') }}">
            </div>
            <div class="col-lg-4">
                <label for="date_to">Data do</label>
                <input type="date" class="form-control" name="date_to" id="date_to" value="{{ request()->input('date_to') }}">
            </div>
            <div class="col-lg-12 text-center mt-2">
                <button class="btn btn-primary text-white">Wyszukaj</button>
            </div>
        </div>
    </form>
    <div class="row mt-4">
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
                                {{ substr($order->code,0,8) }}-{{ $order->id }}({{ $order->branch->id }})
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
            {{ $orders->withQueryString()->links() }}
        </div>
    </div>
@endsection
