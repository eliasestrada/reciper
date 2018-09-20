<?php

namespace App\Http\ViewComposers\Footer;

use App\Models\Document;
use Illuminate\View\View;

class DocumentsComposer
{
    /**
     * Bind data to the view
     * @param  View  $view
     * @return void
     */
    public function compose(View $view): void
    {
        $documents_footer = cache()->rememberForever('documents_footer', function () {
            return Document::select('id', 'title_' . lang())
                ->isReady(1)
                ->limit(10)
                ->get();
        });

        $view->with(compact('documents_footer'));
    }
}
