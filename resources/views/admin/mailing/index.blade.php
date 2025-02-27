@extends('layouts.admin', ['menuName' => 'Mailing'])

@section('content')
    <div class="row">
        <div class="col-lg-12 text-end">
            @if(session('error'))

            @endif
            <form id="mailingForm" action="{{ route('admin.sendMailing') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success text-white">
                    Wyślij Mailing
                </button>
            </form>
        </div>
        <div class="col-lg-12 table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Użytkownicy</th>
                    <th>Status</th>
                    <th>Produkty</th>
                    <th>Data</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($mailings->items() as $mailing)
                    <tr>
                        <td>
                            {{ $mailing->emails }}
                        </td>
                        <td>
                            {{ $mailing->status }}
                        </td>
                        <td>{{ $mailing->products }}</td>
                        <td>{{ $mailing->created_at }}</td>
                        <td>
                            @if($mailing->status === \App\Enums\MailingStatus::CREATED)
                                <form method="POST" action="{{ route('admin.mailing.destroy') }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ms-1 btn btn-danger text-white">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-lg-12">
            {{ $mailings->withQueryString()->links() }}
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module">
        $(document).ready(function () {
            $('#mailingForm').submit(function (e) {
                if (!confirm('Czy na pewno chcesz wysłać mailing do użytkowników?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endpush
