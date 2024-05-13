<div class="mb-4 bg-white p-4">
    @if(isset($category))
        {{ Breadcrumbs::render('category', $department, $category) }}
    @else
        {{ Breadcrumbs::render('department.index', $department) }}
    @endif
</div>

