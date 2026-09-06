<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Banner
 * 
 * @property int $id
 * @property string|null $title
 * @property string $image
 * @property string|null $link
 * @property Carbon|null $start_at
 * @property Carbon|null $end_at
 * @property int $sort_order
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Banner extends Model
{
	protected $table = 'banners';

	protected $casts = [
		'start_at' => 'datetime',
		'end_at' => 'datetime',
		'sort_order' => 'int'
	];

	protected $fillable = [
		'title',
		'image',
		'link',
		'start_at',
		'end_at',
		'sort_order',
		'status'
	];
}
