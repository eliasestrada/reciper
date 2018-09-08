<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Feedback;

class ContactController extends Controller
{
    /**
     * Store in feedback table in database
     * @param ContactRequest $request
     */
    public function store(ContactRequest $request)
    {
        Feedback::create($request->only('email', 'message'));

        cache()->forget('all_feedback');

        return redirect('/contact')->withSuccess(
            trans('admin.thanks_for_feedback')
        );
    }
}
