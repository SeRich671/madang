<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'product_branch', 'product_id', 'branch_id')
            ->withPivot(['is_default']);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_category', 'product_id', 'category_id');
    }

    public function getOrderBranchAttribute()
    {
        $userBranch = $this->branches()->wherePivot('branch_id', auth()->user()->branch_id)->first();

        if($userBranch) {
            return $userBranch;
        }

        return $this->branches()->wherePivot('is_default', 1)->first();
    }
}
