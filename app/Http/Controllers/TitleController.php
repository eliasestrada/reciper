<?php

namespace App\Http\Controllers;

use App\Http\Requests\Settings\TitleRequest;
use App\Models\Title;
use Illuminate\Http\Request;

class TitleController extends Controller
{
    /**
     * @param Request $request
     */
    public function footer(Request $request)
    {
        $data = $this->validate($request,
            ['text' => 'max:190'],
            ['text.max' => trans('settings.footer_text_max')]
        );

        Title::whereName('footer')->update([
            'text_' . lang() => $request->text,
        ]);

        cache()->forget('title_footer');

        return back()->withSuccess(trans('settings.saved'));
    }

    /**
     * @param TitleRequest $request
     */
    public function intro(TitleRequest $request)
    {
        Title::whereName('intro')->update([
            'title_' . lang() => $request->title,
            'text_' . lang() => $request->text,
        ]);

        cache()->forget('title_intro');

        return back()->withSuccess(trans('settings.saved'));
    }
}
