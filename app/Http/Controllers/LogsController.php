<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Arcanedev\LogViewer\Http\Controllers\LogViewerController;

class LogsController extends LogViewerController
{
    /**
     * Delete a log. This method just overwrites delete method from
	 * LogViewer package
     * @param  \Illuminate\Http\Request $request
     */
    public function delete(Request $request)
    {
		$this->logViewer->delete(request('date'));
        return redirect('log-viewer/logs')->withSuccess(trans('logs.deleted'));
    }
}
