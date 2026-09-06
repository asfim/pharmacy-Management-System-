<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Page
 * 
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string|null $content
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Page extends Model
{
	protected $table = 'pages';

	protected $fillable = [
		'slug',
		'title',
		'content',
		'status'
	];
}
