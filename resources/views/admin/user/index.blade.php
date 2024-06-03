@extends('layouts.admin', ['menuName' => 'Użytkownicy'])

@section('content')
    <div class="row">
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
                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->branch?->name ?: '-' }}</td>
                        <td>{{ \App\Enums\User\StatusEnum::getDescription($user->status) }}</td>
                        <td>{{ $user->uncertain ? 'Tak' : 'Nie' }}</td>
                        <td>{{ $user->last_login ? Carbon::parse($user->last_login) : '-' }}</td>
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
            {{ $users->links() }}
        </div>
        <div class="col-lg-12 text-end">
            <a href="{{ route('admin.user.create') }}" class="btn btn-primary text-white">Dodaj nowy</a>
        </div>
    </div>
@endsection
