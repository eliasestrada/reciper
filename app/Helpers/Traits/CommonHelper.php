<?php

namespace App\Helpers\Traits;

use Schema;

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