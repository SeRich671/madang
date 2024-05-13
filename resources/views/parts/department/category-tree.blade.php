<div class="border-bottom border-primary bg-white p-3">
    <h3 class="text-primary">{{ $department->name }}</h3>
</div>
<div class="list-group">
    @foreach($categories as $category)
        <a href="{{ route('department.category.index', ['subdomain' => $department->subdomain, 'category' => $category]) }}" class="list-group-item list-group-item-light list-group-item-action text-primary">{{ $category->name }}</a>
    @endforeach
</div>
