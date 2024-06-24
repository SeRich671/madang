<?php

namespace App\Models;

use App\Enums\Order\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getCodeShortAttribute(): string
    {
        return substr($this->code, 0, 8);
    }

    public function lines(): HasMany
    {
        return $this->hasMany(OrderLine::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(StatusLog::class);
    }

    public function getClientOtherOrdersAttribute()
    {
        return $this->user
            ->orders()
            ->where('finished_by_client', 1)
            ->where('id', '!=', $this->id)
            ->orderByDesc('created_at')
            ->take(50)
            ->get();
    }

    public function getStatusColorAttribute(): string
    {
        if($this->status === StatusEnum::NEW) {
            return 'warning';
        }else if($this->status === StatusEnum::IN_PROGRESS) {
            return 'info';
        }else if($this->status === StatusEnum::DONE) {
            return 'success';
        }else if($this->status === StatusEnum::ABORTED) {
            return 'danger';
        }else{
            return 'success';
        }
    }
}
