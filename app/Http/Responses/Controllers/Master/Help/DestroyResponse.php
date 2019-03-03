<?php

namespace App\Http\Responses\Controllers\Master\Help;

use App\Models\Help;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Responsable;

class DestroyResponse implements Responsable
{
    protected $help;

    /**
     * @param \App\Models\Help $help
     * @return void
     */
    public function __construct(Help $help)
    {
        $this->help = $help;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function toResponse($request): ?RedirectResponse
    {
        try {
            $this->help->delete();
            $this->clearCache();

            return redirect('/help')->withSuccess(trans('help.help_deleted'));
        } catch (QueryException $e) {
            return report_error($e);
        }
    }

    /**
     * @return void
     */
    protected function clearCache(): void
    {
        cache()->forget('help_list');
        cache()->forget('help_categories');
        cache()->forget('trash_notif');
    }
}
