<?php

namespace App\Http\Controllers\Master;

use Arcanedev\LogViewer\Http\Controllers\LogViewerController;
use Illuminate\Http\Request;

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

        return redirect('log-viewer/logs')->withSuccess(
            trans('logs.deleted')
        );
    }
}
