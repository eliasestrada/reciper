<?php

namespace App\Http\Responses\Controllers\Admin\Feedback;

use App\Models\Feedback;
use App\Models\User;
use App\Repos\FeedbackRepo;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\View\View;

class IndexResponse implements Responsable
{
    /**
     * @var \App\Repos\FeedbackRepo
     */
    protected $repo;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->repo = new FeedbackRepo;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function toResponse($request): View
    {
        cache()->forget('feedback_notif');

        User::whereId(user()->id)->update([
            'contact_check' => now(),
        ]);

        return $this->responseView();
    }

    /**
     * @return \Illuminate\View\View
     */
    protected function responseView(): View
    {
        return view('admin.feedback.index', [
            'feedback' => [
                [
                    'lang' => 'ru',
                    'feeds' => $this->repo->paginateWithLanguage('ru'),
                ],
                [
                    'lang' => 'en',
                    'feeds' => $this->repo->paginateWithLanguage('en'),
                ],
            ],
        ]);
    }
}
