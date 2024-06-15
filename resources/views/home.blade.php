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
        <div class="col-lg-3">
            @include('parts.department.category-tree', ['categories' => $categories, 'department' => $department])
        </div>
        <div class="col-lg-9">
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
