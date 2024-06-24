<div class="bg-white border-top">
    @php
        $department = \App\Models\Department::where('subdomain', current_subdomain())->first();
    @endphp
    <div class="container">
        <div class="row">
            <div class="col-lg-12 py-0">
                <a href="{{ config('app.url') }}" class="btn btn-primary text-white rounded-0">
                    <i class="bi bi-house-door"></i> Strona główna
                </a>
                <a href="{{ url('/') }}" class="btn text-primary rounded-0">
                    <i class="bi bi-house-door"></i> Strona główna działu
                </a>
                @if(!isset($department) || ($department->show_change_department))
                <div class="dropdown d-inline">
                    <a class="btn dropdown-toggle rounded-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Zmień dział
                    </a>
                    @php
                        $departments = \App\Models\Department::where('status', \App\Enums\Department\StatusEnum::ON)->get();
                    @endphp
                    <ul class="dropdown-menu">
                        @foreach($departments as $departmentX)
                            <li>
                                <a class="dropdown-item" href="{{ route('department.index', $departmentX->subdomain) }}">
                                    {{ $departmentX->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if(isset($department))
                @foreach($department->links as $link)
                    <a href="{{ $link->link }}" class="btn rounded-0">
                        {{ $link->name }}
                    </a>
                @endforeach
                @endif
                @if(current_subdomain() && $department->show_contact)
                    <a href="{{ route('contact.show', current_subdomain()) }}" class="btn rounded-0">
                        Kontakt
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
