@extends('layouts.admin', ['menuName' => 'Edycja użytkownika ' . $user->first_name . ' ' . $user->last_name])

@section('content')
    <form method="POST" action="{{ route('admin.user.update', $user) }}?page={{ request()->get('page') }}">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col-lg-12">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="row mt-4 mb-3">
            <label for="login" class="col-lg-4 col-form-label text-lg-end">Login</label>
            <div class="col-lg-4">
                <input id="login" type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ $user->login }}"  @disabled(true) autocomplete="login">
                @error('login')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="row mt-4 mb-3">
            <label for="email" class="col-lg-4 col-form-label text-lg-end">Email</label>
            <div class="col-lg-4">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="row mt-4 mb-3">
            <label for="first_name" class="col-lg-4 col-form-label text-lg-end">Imię</label>
            <div class="col-lg-4">
                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" value="{{ $user->first_name }}" name="first_name" required autocomplete="first_name">
                @error('first_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="row mt-4 mb-3">
            <label for="last_name" class="col-lg-4 col-form-label text-lg-end">Nazwisko</label>
            <div class="col-lg-4">
                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" value="{{ $user->last_name }}" name="last_name" required autocomplete="last_name">
                @error('last_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="row mt-4 mb-3">
            <div class="col-lg-12">
                <hr>
            </div>
        </div>
        <div class="row mt-4 mb-3">
            <label for="status" class="col-lg-4 col-form-label text-lg-end">Status</label>
            <div class="col-lg-4">
                <select class="form-control" name="status" required>
                    @foreach($statuses as $key => $status)
                        <option value="{{ $key }}" @selected($key == $user->status)>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="row mt-4 mb-3">
            <label for="role" class="col-lg-4 col-form-label text-lg-end">Role</label>
            <div class="col-lg-4">
                <select class="form-control" name="role" required>
                    @foreach($roles as $key => $role)
                        <option value="{{ $key }}" @selected($key == $user->role)>
                            {{ $role }}
                        </option>
                    @endforeach
                </select>
                @error('role')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mt-4 mb-3">
            <label for="branch_id" class="col-lg-4 col-form-label text-lg-end">Oddział</label>
            <div class="col-lg-4">
                <select class="form-control" name="branch_id" required>
                    @foreach($branches as $key => $branch)
                        <option value="{{ $key }}" @selected($key == $user->branch_id)>
                            {{ $branch }}
                        </option>
                    @endforeach
                </select>
                @error('branch_id')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-6 offset-lg-4">
                <div class="form-check">
                    <input type="hidden" name="uncertain" value="0">
                    <input type="checkbox" value="1" name="uncertain" id="uncertain" class="form-check-input" @checked($user->uncertain)>

                    <label for="uncertain" class="form-check-label">
                        <small>(opcjonalne)</small> Niepewny
                    </label>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-6 offset-lg-4">
                <div class="form-check">
                    <input type="hidden" name="marketing" value="0">
                    <input type="checkbox" value="1" name="marketing" id="marketing" class="form-check-input" @checked($user->marketing)>

                    <label for="marketing" class="form-check-label">
                        <small>(opcjonalne)</small> Zgody marketingowe
                    </label>
                </div>
            </div>
        </div>

        <div class="row mt-4 mb-3">
            <div class="col-lg-12">
                <hr>
            </div>
        </div>

        <div class="row mt-4 mb-3">
            <label for="password" class="col-lg-4 col-form-label text-lg-end">Nowe hasło<small>(opcjonalne)</small></label>
            <div class="col-lg-4">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mt-4 mb-3">
            <label for="password_confirmation" class="col-lg-4 col-form-label text-lg-end">Potwierdź hasło<small>(opcjonalne)</small></label>
            <div class="col-lg-4">
                <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" autocomplete="password_confirmation">
                @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-lg-12 mt-4 text-end">
            <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">
                Powrót
            </a>
            <button class="btn btn-primary text-white">
                Zapisz
            </button>
        </div>
    </form>

    <div class="col-lg-12 mt-4 text-primary">
        <h5>Książka adresowa</h5>
        <hr>
    </div>

    <div class="row mt-4 mb-3">
        @foreach($user->addresses as $address)
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="card-title">
                            {{ $address->company_name?: $address->first_name . ' ' . $address->last_name }}
                        </div>
                    </div>
                    <div class="card-body">
                        {{ $address->street }}, {{ $address->city }}, {{ $address->zip_code }}
                    </div>
                    <div class="card-footer text-end">
                        <form method="POST" action="{{ route('admin.user.address.destroy', ['user' => $user, 'address' => $address]) }}">
                            <a href="{{ route('admin.user.address.edit', ['user' => $user, 'address' => $address]) }}" class="btn btn-outline-primary">Edytuj</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger text-white">Usuń</button>
                        </form>

                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-lg-4 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center justify-content-center">
                    <a href="{{ route('admin.user.address.create', $user) }}" class="btn btn-primary text-white">Dodaj nowy</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 mt-4 text-primary">
        <h5>Dane do faktury</h5>
        <hr>
    </div>

    <div class="row mt-4 mb-3">
        @foreach($user->billings as $billing)
            <div class="col-lg-4 mb-3">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="card-title">
                            {{ $billing->company_name?: $billing->first_name . ' ' . $billing->last_name }}
                        </div>
                    </div>
                    <div class="card-body">
                        {{ $billing->address }}, {{ $billing->city }}, {{ $billing->zipcode }} <br>
                        {{ $billing->nip }} <br>
                        {{ $billing->email }}, {{ $billing->phone }}
                    </div>
                    <div class="card-footer text-end">
                        <form method="POST" action="{{ route('admin.user.billing.destroy', ['user' => $user, 'billing' => $billing]) }}">
                            <a href="{{ route('admin.user.billing.edit', ['user' => $user, 'billing' => $billing]) }}" class="btn btn-outline-primary">Edytuj</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger text-white">Usuń</button>
                        </form>

                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-lg-4 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center justify-content-center">
                    <a href="{{ route('admin.user.billing.create', $user) }}" class="btn btn-primary text-white">Dodaj nowe</a>
                </div>
            </div>
        </div>
    </div>

    @if($orders->count())
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
                    @foreach($orders as $order)
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
        </div>
    @endif
@endsection

{{--@push('scripts')--}}
{{--    <script type="module">--}}
{{--        $(document).ready(function () {--}}
{{--            $('#department_id').select2();--}}
{{--            $('#category_id').select2();--}}
{{--        });--}}
{{--    </script>--}}
{{--@endpush--}}
