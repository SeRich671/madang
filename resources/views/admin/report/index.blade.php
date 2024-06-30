@extends('layouts.admin', ['menuName' => 'Historia raportów'])

@section('content')
    <div class="row">
        <div class="col-lg-12 table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Wygenereowane przez</th>
                    <th>Data i czas</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($reports->items() as $report)
                    <tr>
                        <td>
                            {{ $report->user->first_name }} {{ $report->user->last_name }}
                        </td>
                        <td>
                            {{ $report->created_at->format('H:i d.m.Y') }}
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.product.export.download', $report) }}" class="btn btn-primary text-white">
                                Pobierz
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-lg-12">
            {{ $reports->withQueryString()->links() }}
        </div>
    </div>
@endsection
