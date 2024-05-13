<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_branch', 'branch_id', 'product_id')
            ->withPivot(['is_default']);
    }
}
