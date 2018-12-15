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
            return Help::select('id', 'title_' . LANG() . ' as title', 'help_category_id')
                ->orderBy('title')
                ->get()
                ->toArray();
        });
    }

    /**
     * @param \App\Models\Help $help
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public static function update(Help $help, HelpRequest $request): void
    {
        try {
            $help->update([
                'title_' . LANG() => $request->title,
                'text_' . LANG() => $request->text,
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
                'title_' . LANG() => $request->title,
                'text_' . LANG() => $request->text,
                'help_category_id' => $request->category,
            ]);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
        }
    }
}
