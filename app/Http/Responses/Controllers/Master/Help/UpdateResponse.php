<?php

namespace App\Http\Responses\Controllers\Master\Help;

use App\Models\Help;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Responsable;

class UpdateResponse implements Responsable
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
            $this->updateHelp($request);
            $this->clearCache();

            return redirect("/master/help/{$this->help->id}/edit")
                ->withSuccess(trans('help.help_updated'));
        } catch (QueryException $e) {
            return report_error($e);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function updateHelp($request): void
    {
        $this->help->update([
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
