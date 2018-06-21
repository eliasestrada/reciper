<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	protected $guarded = ['id'];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function isImportant() : bool
	{
		return $this->important === 1 ? true : false;
	}

	/**
	 * @param string $title
	 * @param string $message
	 * @param int $iser_id
	 * @param string $data
	 * @param int $important
	 * @param int $for_admin
	 */
	public static function sendMessage($title, $message, $user_id = null, $data, $important = 0, $for_admin = 0) : void
	{
		self::create([
			'title' => $title,
			'message' => $message,
			'user_id' => $user_id,
			'data' => $data,
			'important' => $important,
			'for_admins' => $for_admin
		]);
	}


	public function getIcon() : string
	{
		return $this->isImportant()
			? '<i class="material-icons left red-text">warning</i>'
			: '<i class="material-icons left green-text">notifications_none</i>';
	}
}
