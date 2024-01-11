<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Customer
 *
 * @property int $id
 * @property string $identity
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string|null $tax_no
 * @property string|null $tax_office
 * @property string|null $address
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Customer extends Model
{
    use HasFactory;
	use SoftDeletes;
	protected $table = 'customers';

	protected $fillable = [
		'identity',
		'name',
		'email',
		'phone',
		'tax_no',
		'tax_office',
		'address'
	];

	public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
		return $this->hasMany(User::class);
	}
}
