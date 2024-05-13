<div class="bg-white border-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 py-0">
                <a href="{{ config('app.url') }}" class="btn btn-primary text-white rounded-0">
                    <i class="bi bi-house-door"></i> Strona główna
                </a>
                <a href="{{ url('/') }}" class="btn text-primary rounded-0">
                    <i class="bi bi-house-door"></i> Strona główna działu
                </a>
                <div class="dropdown d-inline">
                    <a class="btn dropdown-toggle rounded-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Zmień dział
                    </a>
                    @php
                        $departments = \App\Models\Department::all();
                    @endphp
                    <ul class="dropdown-menu">
                        @foreach($departments as $department)
                            <li>
                                <a class="dropdown-item" href="{{ route('department.index', $department->subdomain) }}">
                                    {{ $department->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <a href="{{ route('contact.index') }}" class="btn rounded-0">
                    Kontakt
                </a>
            </div>
        </div>
    </div>
</div>
