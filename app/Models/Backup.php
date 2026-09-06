<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Backup
 * 
 * @property int $id
 * @property string $file_reference
 * @property int $size
 * @property string|null $checksum
 * @property int|null $created_by
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Backup extends Model
{
	protected $table = 'backups';

	protected $casts = [
		'size' => 'int',
		'created_by' => 'int'
	];

	protected $fillable = [
		'file_reference',
		'size',
		'checksum',
		'created_by',
		'status'
	];
}
