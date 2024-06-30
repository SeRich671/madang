<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use App\Models\Category;
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('department.index', function (BreadcrumbTrail $trail, $department) {
    if(request()->input('want_back') === '1') {
        $trail->push('< Powrót', base64_decode(request()->input('prev_url')));
    }
    $trail->push($department->name, route('department.index', ['subdomain' => $department->subdomain]));
});

Breadcrumbs::for('category', function (BreadcrumbTrail $trail, $department, $category) {
    $trail->parent('department.index', $department);

    $recur = $category->category;

    while($recur) {
        $trail->push($recur->name, route('department.category.index', ['subdomain' => $department->subdomain, 'category' => $recur]));
        $recur = $recur->category;
    }

    $trail->push($category->name, route('department.category.index', ['subdomain' => $department->subdomain, 'category' => $category]));
});

Breadcrumbs::for('product.show', function (BreadcrumbTrail $trail, $department, Category $category, $product) {
    if($category->exists) {
        $trail->parent('category', $department, $category,);
    }else{
        $trail->push('Powrót', url()->previous());
    }



    $trail->push($product->name, route('product.show', ['subdomain' => $department->subdomain, 'category' => $category ?? null, 'product' => $product]));
});


