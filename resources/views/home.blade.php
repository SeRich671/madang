@extends('layouts.app')

@section('content')

@if(Auth::check() && !auth()->user()?->email_verified_at)
    @include('parts.verification-required')
@endif

@if(Auth::check() && !auth()->user()->branch_id && auth()->user()->email_verified_at)
    @include('parts.branch-required')
@endif

<div class="container">
    <div class="row">
        @if($categories->count())
            <div class="col-lg-3">
                @include('parts.department.category-tree', ['categories' => $categories, 'department' => $department])
            </div>
        @endif
        <div class="@if($categories->count()) col-lg-9 @else col-lg-12 @endif">
            @include('parts.department.category-breadcrumbs', ['category' => $category ?? null])
            @if(!isset($category))
                @include('parts.department.index', ['recommended' => $recommended, 'new' => $new, 'discounted' => $discounted])
            @endif
            @if(isset($products) && $products->count())
                @include('parts.department.products', ['products' => $products, 'category' => $category])
            @endisset
        </div>
    </div>
</div>
@endsection
