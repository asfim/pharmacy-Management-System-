<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Blog
 * 
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string|null $content
 * @property string|null $image
 * @property int|null $author_id
 * @property Carbon|null $published_at
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User|null $user
 *
 * @package App\Models
 */
class Blog extends Model
{
	protected $table = 'blogs';

	protected $casts = [
		'author_id' => 'int',
		'published_at' => 'datetime'
	];

	protected $fillable = [
		'slug',
		'title',
		'content',
		'image',
		'author_id',
		'published_at',
		'status'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'author_id');
	}
}
