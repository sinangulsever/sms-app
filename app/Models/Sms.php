<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Sms
 *
 * @property int $id
 * @property int $customer_id
 * @property Carbon|null $send_date
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Customer $customer
 * @property Collection|SmsDetail[] $sms_details
 *
 * @package App\Models
 */


class Sms extends BaseModel
{
    use SoftDeletes;

    static array $status = [
        'Pending' => 0,
        'Success' => 1,
        'Failed' => 2
    ];

    protected $table = 'sms';

    protected $casts = [
        'customer_id' => 'int',
        'status' => 'int',
        'send_date' => 'datetime'
    ];

    protected $fillable = [
        'customer_id',
        'send_date',
        'status'
    ];

    public $appends = [
        'pending_count',
        'success_count',
        'fail_count',
        'total_count'
    ];

    public function getPendingCountAttribute(): int
    {
        return $this->sms_details()->where('status', 0)->count();
    }

    public function getSuccessCountAttribute(): int
    {
        return $this->sms_details()->where('status', 1)->count();
    }

    public function getFailCountAttribute(): int
    {
        return $this->sms_details()->where('status', 2)->count();
    }

    public function getTotalCountAttribute(): int
    {
        return $this->sms_details()->count();
    }

    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function sms_details(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SmsDetail::class);
    }
}
