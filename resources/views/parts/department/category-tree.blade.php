<div class="border-bottom border-primary bg-white p-3">
    <h3 class="text-primary">{{ $department->name }}</h3>
</div>
<div class="list-group">
    @foreach($categories as $category)
        @if($category->all_product_count)
            <a href="{{ route('department.category.index', ['subdomain' => $department->subdomain, 'category' => $category]) }}" class="list-group-item list-group-item-light list-group-item-action text-primary">
                {{ $category->name }}
{{--                <span class="badge bg-primary text-white">--}}
{{--                    {{ $category->all_product_count }}--}}
{{--                </span>--}}
            </a>
        @endif
    @endforeach
</div>
