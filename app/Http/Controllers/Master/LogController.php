<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Arcanedev\LogViewer\Http\Controllers\LogViewerController;

class LogController extends LogViewerController
{
    /**
     * Delete a log. This method just overwrites delete method from
     * LogViewer package
     *
     * @param \Illuminate\Http\RedirectRequest $request
     */
    public function destroy(Request $request): RedirectResponse
    {
        $this->logViewer->delete(request('date'));

        return redirect('log-viewer/logs')->withSuccess(
            trans('logs.deleted')
        );
    }
}
