<?php

namespace App\Helpers\Traits;

use Illuminate\Support\Facades\Schema;

trait CommonHelper
{
	public function checkIfTableExists($table)
	{
		if (! Schema::hasTable($table)) {
			logger()->emergency(trans('logs.no_table', ['table' => $table]));
			return true;
		}
		return false;
	}
}