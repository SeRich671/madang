<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('department.index', function (BreadcrumbTrail $trail, $department) {
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

Breadcrumbs::for('product.show', function (BreadcrumbTrail $trail, $department, $category, $product) {
    $trail->parent('category', $department, $category,);
    $trail->push($product->name, route('product.show', ['subdomain' => $department->subdomain, 'category' => $category, 'product' => $product]));
});


