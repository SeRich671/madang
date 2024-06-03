<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_category', 'category_id', 'product_id');
    }

    public function allLeafNodes()
    {
        $leafNodes = DB::select(
            "WITH RECURSIVE cte AS (
                SELECT id, category_id
                FROM categories
                WHERE category_id = $this->id
                UNION ALL
                SELECT c.id, c.category_id
                FROM categories c
                INNER JOIN cte ON cte.id = c.category_id
            )
            SELECT id
            FROM categories
            WHERE id IN (SELECT id FROM cte)");

        return Category::whereIn('id', collect($leafNodes)->pluck('id')->toArray())
            ->with('categories')
            ->whereDoesntHave('categories');
    }


    public function getAllProductCountAttribute(): int
    {
        $allLeafNodes = $this->allLeafNodes()->pluck('id');

        $leafProducts = Product::isAvailable()
            ->whereHas('categories', function ($query) use ($allLeafNodes) {
                return $query->whereIn('categories.id', $allLeafNodes);
            })
            ->distinct()
            ->get();

        $products = $this->products()
            ->where(function ($query) {
                return $query->where('is_available', 1)
                    ->orWhere('last_available', '>', now()->subDays(7));
            })
            ->get();

        return $leafProducts->merge($products)
            ->unique('id')
            ->count();
    }

    public function getFullParentNameAttribute(): string
    {
        $recur = $this;
        $out = '';

        while($recur) {
            $out = ' / ' . $recur->name . $out;
            $recur = $recur->category;
        }

        return $this->department->name . $out;
    }
}
