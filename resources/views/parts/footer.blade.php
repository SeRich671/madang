
    @if(current_subdomain())
        @php
            $footerDepartment = \App\Models\Department::where('subdomain', current_subdomain())->first();
        @endphp

        @if($footerDepartment)
            <footer class="pt-3 bg-white">
                @if(auth()->check())
                    {!! $footerDepartment->footer_auth !!}
                @else
                    {!! $footerDepartment->footer_guest !!}
                @endif
                <div class="bg-dark">
                    <div class="container p-3">
                        <span class="text-white">Korzystanie z naszego serwisu oznacza akceptację </span><span class="text-primary"> regulaminu</span>
                    </div>
                </div>
            </footer>
        @endif
    @else
        <footer class="pt-3 bg-white">
            <div class="p-3 bg-white">
                <div class="row">

                    @php
                        $branches = \App\Models\Branch::all();
                    @endphp
                    @foreach($branches as $branch)
                        <div class="col-lg-2 mt-2">
                            <div class="text-uppercase font-weight-bold">{{ $branch->name }}</div>
                            <div>ADRES: {{ $branch->street }}, {{ $branch->city }}, {{ $branch->zipcode }}</div>
                            <div>TEL: {{ $branch->phone }}</div>
                            <div>EMAIL: {{ str_replace(',', ', ', $branch->email) }}</div>
                        </div>
                    @endforeach

                    <div class="offset-lg-4 col-lg-4 mt-4 text-center">
                        <div class="text-uppercase font-weight-bold">malpin.pl</div>
                        <div><a class="link-primary" href="#">Regulamin</a></div>
                        <div><a class="link-primary" href="#">O nas</a></div>
                        <div><a class="link-primary" href="#">Polityka plików cookies</a></div>
                    </div>
                </div>
            </div>
        </footer>
    @endif

