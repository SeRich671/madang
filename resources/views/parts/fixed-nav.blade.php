<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
        <a class="navbar-brand" href="{{ config('app.url') }}">Madang</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form class="d-flex mx-auto">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                @php
                    $departments = \App\Models\Department::all();
                @endphp
                <select class="form-control me-2">
                    <option value="0">Wszystkie działy</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('cart.show') }}">
                        <i class="bi bi-cart-fill"></i> @if(cart_count()) <span class="badge bg-primary text-white">{{ cart_count() }}</span> @endif
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-fill"></i>
                    </a>
                    <ul class="dropdown-menu px-2" style="min-width: 300px" aria-labelledby="navbarDropdown">
                        @if(Auth::check())
                            @if(auth()->user()->role == \App\Enums\User\RoleEnum::ADMIN)
                                <li><a class="dropdown-item" href="{{ route('admin.index') }}">Panel administratora</a></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Edycja danych</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.order.index') }}">Moje zamówienia</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.address.index') }}">Książka adresowa</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Wyloguj się</button>
                                </form>

                            </li>
                        @else
                            <li class="text-center">
                                <i class="bi bi-bag-dash" style="font-size:38px"></i><br>
                                <strong style="font-size:1.2em">Witaj w madang.pl!</strong><br><br>
                                Zaloguj się bądź zarejestruj
                                aby dokonać zamówienia na swoje produkty
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li class="text-center">
                                <a class="btn btn-primary w-100 text-white" href="{{ route('login') }}">
                                    Zaloguj się
                                </a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">Zarejestruj konto</a></li>
                        @endif
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
{{--<div class="row"></div>--}}
