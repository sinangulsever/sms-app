<?php


namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SmsDetail
 *
 * @property int $id
 * @property int $sms_id
 * @property string|null $message
 * @property string|null $number
 * @property string $status
 * @property Carbon|null $send_date
 * @property string|null $response_send
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Sms $sms
 *
 * @package App\Models
 */
class SmsDetail extends Model
{
	use SoftDeletes;
	protected $table = 'sms_details';

	protected $casts = [
		'sms_id' => 'int',
        'status' => 'int',
		'send_date' => 'datetime'
	];

	protected $fillable = [
		'sms_id',
		'message',
		'number',
		'status',
		'send_date',
		'response_send'
	];

	public function sms(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
		return $this->belongsTo(Sms::class);
	}
}
