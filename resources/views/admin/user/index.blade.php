@extends('layouts.admin', ['menuName' => 'Użytkownicy'])

@section('content')
    <form method="GET" action="{{ url()->current() }}">
        <div class="row">
            <div class="col-lg-8">
                <label for="query">Imię, nazwisko, adres e-mail, login</label>
                <input type="text" class="form-control" name="query" value="{{ request()->input('query') }}">
            </div>
            <div class="col-lg-4">
                <label for="branch_id">Oddziały</label>
                <select name="branch_id[]" id="branch_id" class="form-control" multiple>
                    @foreach($branches as $key => $branch)
                        <option value="{{ $key }}" @selected(in_array($key, request()->input('branch_id', [])))>{{ $branch }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-12 text-center">
                <button type="submit" class="btn btn-primary text-white">Wyszukaj</button>
            </div>
        </div>
    </form>
    <div class="row mt-4">
        <div class="col-lg-12 table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Login</th>
                    <th>Rola</th>
                    <th>Imię i nazwisko</th>
                    <th>Email</th>
                    <th>Oddział</th>
                    <th>Status</th>
                    <th>Niepewny</th>
                    <th>Ostatnie logowanie</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($users->items() as $user)
                    <tr>
                        <td>
                            {{ $user->login }}
                        </td>
                        <td>{{ \App\Enums\User\RoleEnum::getDescription($user->role) }}</td>
                        <td>
                            {{ $user->first_name }} {{ $user->last_name }}<br>
                            Firma: {{ $user->company_name }}
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->branch?->name ?: '-' }}</td>
                        <td>
                            {{ \App\Enums\User\StatusEnum::getDescription($user->status) }} <br>
                            Zgody marketingowe: {{ $user->marketing ? 'Tak' : 'Nie' }}
                        </td>
                        <td>{{ $user->uncertain ? 'Tak' : 'Nie' }}</td>
                        <td>{{ $user->last_login ? Carbon\Carbon::parse($user->last_login)->format('H:i d.m.Y') : '-' }}</td>
                        <td class="text-end">
                            <form method="POST" action="{{ route('admin.user.destroy', $user) }}">
                                @csrf
                                @method('DELETE')
                                <a class="btn btn-primary text-white" href="{{ route('admin.user.edit', $user) }}"><i class="bi bi-pen"></i></a>
                                <button type="submit" class="ms-1 btn btn-danger text-white" @disabled($user->orders()->count())>
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-lg-12">
            {{ $users->withQueryString()->links() }}
        </div>
        <div class="col-lg-12 text-end">
            <a href="{{ route('admin.user.create') }}" class="btn btn-primary text-white">Dodaj nowy</a>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module">
        $(document).ready(function () {
            $('#branch_id').select2();
        });
    </script>
@endpush
