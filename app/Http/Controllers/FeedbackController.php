<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use App\Http\Responses\Controllers\Admin\Feedback\StoreResponse;

class FeedbackController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Store a newly created report or feedback in database
     *
     * @param \App\Http\Requests\FeedbackRequest $request
     * @return \App\Http\Responses\Controllers\Admin\Feedback\StoreResponse
     */
    public function store(FeedbackRequest $request): StoreResponse
    {
        return new StoreResponse;
    }
}
