<?php

namespace App\Http\Responses\Controllers\Master\Help;

use App\Models\Help;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Responsable;

class StoreResponse implements Responsable
{
    /**
     * @throws \Illuminate\Database\QueryException
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function toResponse($request): ?RedirectResponse
    {
        try {
            $this->createHelpMaterial($request);
            $this->clearCache();

            return redirect('/help')->withSuccess(
                trans('help.help_message_is_created')
            );
        } catch (QueryException $e) {
            return report_error($e);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function createHelpMaterial($request): void
    {
        Help::create([
            _('title') => $request->title,
            _('text') => $request->text,
            'help_category_id' => $request->category,
        ]);
    }

    /**
     * @return void
     */
    protected function clearCache(): void
    {
        cache()->forget('help_list');
        cache()->forget('help_categories');
    }
}
