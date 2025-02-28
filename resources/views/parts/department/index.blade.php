@if(session('success') || $new->count() || $recommended->count() || $lastDeliveries->count() || $discounted->count())
<div class="bg-white p-3">

    @if(session('success'))
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    @if($recommended->count())
        <div class="row">
            <div class="col-lg-12 text-primary d-flex justify-content-between">
                <h3 class="d-inline">Polecane produkty</h3>
                <a href="{{ route('department.recommended', $department->subdomain) }}" class="link-primary">Zobacz wszystkie</a>
            </div>
            <div class="col-lg-12 text-primary">
                <hr>
            </div>
        </div>
        <div class="row mt-3">
            @foreach($recommended as $product)
                <div class="col-lg-4 mb-2 ">
                    @include('parts.department.product.card', ['product' => $product, 'category' => $product->categories()->where('department_id', $department->id)->first()])
                </div>
            @endforeach
        </div>
    @endif

    @if($new->count())
        <div class="row mt-4">
            <div class="col-lg-12 text-primary d-flex justify-content-between">
                <h3 class="d-inline">Nowe produkty</h3>
                <a href="{{ route('department.new', $department->subdomain) }}" class="link-primary">Zobacz wszystkie</a>
            </div>
            <div class="col-lg-12 text-primary">
                <hr>
            </div>
        </div>
        <div class="row mt-3 mb-4">
            @foreach($new as $product)
                <div class="col-lg-4 mb-2 ">
                    @include('parts.department.product.card', ['product' => $product, 'category' => $product->categories()->where('department_id', $department->id)->first()])
                </div>
            @endforeach
        </div>
    @endif

    @if($discounted->count())
        <div class="row mt-4">
            <div class="col-lg-12 text-primary d-flex justify-content-between">
                <h3 class="d-inline">Przecena</h3>
                <a href="{{ route('department.discounted', $department->subdomain) }}" class="link-primary">Zobacz wszystkie</a>
            </div>
            <div class="col-lg-12 text-primary">
                <hr>
            </div>
        </div>
        <div class="row mt-3 mb-4">
            @foreach($discounted as $product)
                <div class="col-lg-4 mb-2 ">
                    @include('parts.department.product.card', ['product' => $product, 'category' => $product->categories()->where('department_id', $department->id)->first()])
                </div>
            @endforeach
        </div>
    @endif

    @if($lastDeliveries->count())
        <div class="row mt-4">
            <div class="col-lg-12 text-primary d-flex justify-content-between">
                <h3 class="d-inline">Ostatnie dostawy</h3>
                <a href="{{ route('department.last-deliveries', $department->subdomain) }}" class="link-primary">Zobacz wszystkie</a>
            </div>
            <div class="col-lg-12 text-primary">
                <hr>
            </div>
        </div>
        <div class="row mt-3 mb-4">
            @foreach($lastDeliveries as $product)
                <div class="col-lg-4 mb-2 ">
                    @include('parts.department.product.card', ['product' => $product, 'category' => $product->categories()->where('department_id', $department->id)->first()])
                </div>
            @endforeach
        </div>
    @endif
</div>
@endif
