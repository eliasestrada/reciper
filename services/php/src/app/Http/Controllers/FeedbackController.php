<?php

namespace App\Http\Controllers;

use App\Repos\FeedbackRepo;
use App\Http\Requests\FeedbackRequest;
use App\Http\Responses\Controllers\Admin\Feedback\StoreResponse;

class FeedbackController extends Controller
{
    /**
     * @var \App\Repos\FeedbackRepo
     */
    private $repo;

    /**
     * @param \App\Repos\FeedbackRepo $repo
     * @return void
     */
    public function __construct(FeedbackRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Store a newly created report or feedback in database
     *
     * @param \App\Http\Requests\FeedbackRequest $request
     * @return \App\Http\Responses\Controllers\Admin\Feedback\StoreResponse
     */
    public function store(FeedbackRequest $request): StoreResponse
    {
        return new StoreResponse($this->repo);
    }
}
