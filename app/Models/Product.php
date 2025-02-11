<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    const PER_PAGE = 12;

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
        $defaultBranch = $this->branches()->wherePivot('is_default', 1)->first();

        if($userBranch) {
            return $userBranch;
        }elseif($defaultBranch) {
            return $defaultBranch;
        }

        return $this->branches()->first();
    }

    public function scopeFilters($query, $filters) {
        return $query->whereHas('categories')->when(isset($filters['sort_type']) && $filters['sort_type'], function ($query2) use ($filters) {
            return $query2->orderBy($filters['sort_type'], $filters['sort_order']);
        }, function ($query2) {
            return $query2->orderBy('name', 'asc');
        })->when(isset($filters['price']['from']) && $filters['price']['from'], function ($query2) use ($filters) {
            return $query2->where('price', '>=', $filters['price']['from']);
        })->when(isset($filters['price']['to']) && $filters['price']['to'], function ($query2) use ($filters) {
            return $query2->where('price', '<=', $filters['price']['to']);
        })->when(isset($filters['count_in_package']['from']) && $filters['count_in_package']['from'], function ($query2) use ($filters) {
            return $query2->where('count_in_package', '>=', $filters['count_in_package']['from']);
        })->when(isset($filters['count_in_package']['to']) && $filters['count_in_package']['to'], function ($query2) use ($filters) {
            return $query2->where('price', '<=', $filters['count_in_package']['to']);
        })->when(!isset($filters['show_unavailable']) || $filters['show_unavailable'] == 0, function ($query2) use ($filters) {
            return $query2->where(function ($query3) {
                return $query3->where('is_available', 1)
                    ->orWhere('last_available', '>', now()->subDays(7));
            })->where('in_stock', '>', 0);
        })->when(isset($filters['sticker']) && $filters['sticker'] != 0, function ($query2) {
            return $query2->whereHas('stickers');
        })->when(!empty($filters['dynamic_attribute']), function ($query2) use ($filters) {
            foreach ($filters['dynamic_attribute'] as $key => $dynamicAttribute) {
                $query2->whereHas('attributes', function ($query3) use ($key, $dynamicAttribute) {
                    $query3->where('attributes.id', $key)
                        ->whereIn('value', $dynamicAttribute);
                });
            }
        });
    }

    public function scopeIsAvailable($query) {
        return $query->where(function ($query2) {
            return $query2->where('is_available', 1)
                ->orWhere('last_available', '>', now()->subDays(7));
        })->where('in_stock', '>', 0);
    }

    public function scopeSearch($query, $search)
    {
        // Function to remove Polish diacritics from a string
        $normalizeChars = function ($string) {
            $replace = [
                'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n',
                'ó' => 'o', 'ś' => 's', 'ź' => 'z', 'ż' => 'z',
                'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'E', 'Ł' => 'L', 'Ń' => 'N',
                'Ó' => 'O', 'Ś' => 'S', 'Ź' => 'Z', 'Ż' => 'Z'
            ];
            return strtr($string, $replace);
        };

        // Function to trim word endings (vowels) if the word is longer than 4 characters
        $trimEndings = function ($word) {
            $vowels = ['a', 'e', 'i', 'o', 'u', 'y', 'ą', 'ę', 'ó'];
            while (strlen($word) > 4 && in_array(substr($word, -1), $vowels)) {
                $word = substr($word, 0, -1);
            }
            return $word;
        };

        // Split the search string into words (ignoring words shorter than 3 characters)
        $searchTerms = array_filter(explode(' ', $search), function ($word) {
            return strlen($word) >= 3;
        });
        // Apply trimming (you can also uncomment normalization here if you want to modify the search terms)
        // $searchTerms = array_map($normalizeChars, $searchTerms);
        $searchTerms = array_map($trimEndings, $searchTerms);

        // For each term, search both the raw and normalized versions of the columns.
        // We'll use nested REPLACE() calls to normalize the stored values on the fly.
        return $query->where(function ($query) use ($searchTerms, $normalizeChars, $trimEndings) {
            foreach ($searchTerms as $term) {
                // Prepare a normalized version of the term for matching (remove diacritics)
                $normalizedTerm = $normalizeChars($term);

                $query->where(function ($q) use ($term, $normalizedTerm) {
                    // Match the original values
                    $q->where('name', 'LIKE', '%' . $term . '%')
                        ->orWhere('code', 'LIKE', '%' . $term . '%')
                        // Or match normalized values (using nested REPLACE calls)
                        ->orWhereRaw(
                            "REPLACE(
                        REPLACE(
                            REPLACE(
                                REPLACE(
                                    REPLACE(name, 'ą', 'a'),
                                'ć', 'c'),
                            'ę', 'e'),
                        'ł', 'l'),
                    'ń', 'n') LIKE ?",
                            ['%' . $normalizedTerm . '%']
                        )
                        ->orWhereRaw(
                            "REPLACE(
                        REPLACE(
                            REPLACE(
                                REPLACE(
                                    REPLACE(code, 'ą', 'a'),
                                'ć', 'c'),
                            'ę', 'e'),
                        'ł', 'l'),
                    'ń', 'n') LIKE ?",
                            ['%' . $normalizedTerm . '%']
                        );
                });
            }
        });
    }


    public function orderLines(): HasMany
    {
        return $this->hasMany(OrderLine::class);
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'product_attribute', 'product_id', 'attribute_id')
            ->withPivot(['value']);
    }

    public function stickers(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_sticker', 'sticker_id', 'product_id');
    }

    public function product(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_sticker', 'product_id', 'sticker_id');
    }
}
