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
        //returns all leaf categories related to current model
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
//        dd($leafNodes);
        return Category::whereIn('id', collect($leafNodes)->pluck('id')->toArray())
            ->with('categories')
            ->whereDoesntHave('categories');
    }
}
