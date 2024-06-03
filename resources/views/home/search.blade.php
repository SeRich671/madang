@extends('layouts.app')

@section('content')

    @if(Auth::check() && !auth()->user()->branch_id)
        @include('parts.branch-required')
    @endif

    <div class="container">
        <div class="row">
            @if($categories->count() && $department)
                <div class="col-lg-3">
                    @include('parts.department.category-tree', ['categories' => $categories, 'department' => $department])
                </div>

                <div class="col-lg-9">
                    @include('parts.department.category-breadcrumbs', ['category' => $category ?? null])
                    @if(isset($products) && $products->count())
                        @include('parts.department.products', ['products' => $products, 'category' => 'Wyniki wyszukiwania'])
                    @endif
                </div>
            @else
                <div class="col-lg-12">
                    @if(isset($products) && $products->count())
                        @include('parts.department.products', ['products' => $products, 'category' => 'Wyniki wyszukiwania'])
                    @else
                        <div class="bg-white p-3 text-center">
                            Brak wyników wyszukiwania. <br>
                            @if(current_subdomain())
                                Wyszukałeś wyniki dla działu: {{ \App\Models\Department::where('subdomain', current_subdomain())->first()->name }}, <br>
                                Spróbuj wyszukać produkt w innych działach
                            @endif
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection
