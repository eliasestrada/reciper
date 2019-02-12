<?php

namespace App\Repos;

use App\Http\Requests\HelpRequest;
use App\Models\Help;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class HelpRepo
{
    /**
     * @return array
     */
    public static function getCache(): array
    {
        return cache()->remember('help_list', 10, function () {
            return Help::orderBy(_('title'))->get()->toArray();
        });
    }

    /**
     * @param \App\Models\Help $help
     * @param \App\Http\Requests\HelpRequest $request
     * @return void
     */
    public static function update(Help $help, HelpRequest $request): void
    {
        try {
            $help->update([
                _('title') => $request->title,
                _('text') => $request->text,
                'help_category_id' => $request->category,
            ]);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public static function create(Request $request): void
    {
        try {
            Help::create([
                _('title') => $request->title,
                _('text') => $request->text,
                'help_category_id' => $request->category,
            ]);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
        }
    }
}
