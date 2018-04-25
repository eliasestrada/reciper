<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemsResource;

class ApiItemsController extends Controller
{
    public function show() {
		$item = Item::whereIp(request()->ip())->first();
		return $item ? new ItemsResource($item) : '';
	}
}
