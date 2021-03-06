<?php

namespace Tests\Feature\Repos;

use Tests\TestCase;
use App\Models\Recipe;
use App\Models\Visitor;
use App\Models\Feedback;
use App\Repos\FeedbackRepo;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FeedbackRepoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \App\Repos\FeedbackRepo
     */
    private $repo;

    /**
     * Setup the test environment
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->repo = new FeedbackRepo;
    }

    /**
     * @test
     */
    public function method_alreadyReportedToday_returns_true_if_given_recipe_was_reported_today(): void
    {
        $visitor_id = create(Visitor::class)->id;
        $recipe_id = create(Recipe::class)->id;

        create(Feedback::class, compact('visitor_id', 'recipe_id'), null, 'report');

        $result = $this->repo->alreadyReportedToday($visitor_id, $recipe_id);
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function method_alreadyReportedToday_returns_false_if_given_recipe_wasnt_reported_today(): void
    {
        $visitor_id = create(Visitor::class)->id;
        $recipe_id = create(Recipe::class)->id;

        create(Feedback::class, compact('visitor_id'));

        $result = $this->repo->alreadyReportedToday($visitor_id, $recipe_id);
        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function method_alreadyContactedToday_returns_true_if_visitor_send_message_today(): void
    {
        $visitor_id = create(Visitor::class)->id;
        create(Feedback::class, compact('visitor_id'));
        $this->assertTrue($this->repo->alreadyContactedToday($visitor_id));
    }

    /**
     * @test
     */
    public function method_alreadyContactedToday_returns_false_if_visitor_didnt_send_message_today(): void
    {
        $visitor_id = create(Visitor::class)->id;
        $this->assertFalse($this->repo->alreadyContactedToday($visitor_id));
    }

    /**
     * @test
     */
    public function method_paginateWithLanguage_returns_paginated_feeds_with_given_language(): void
    {
        $test = create(Feedback::class, ['lang' => 'ru'], 1);
        $this->assertCount(1, $this->repo->paginateWithLanguage('ru'));
    }

    /**
     * @test
     */
    public function method_paginateWithLanguage_returns_0_if_given_language_doesnt_have_feeds(): void
    {
        create(Feedback::class, ['lang' => 'ru'], 1);
        $this->assertCount(0, $this->repo->paginateWithLanguage('en'));
    }

    /**
     * @test
     */
    public function method_find_returns_feedback_with_given_id(): void
    {
        $feed = create(Feedback::class);
        $this->assertEquals($feed->toBase(), $this->repo->find($feed->id)->toBase());
    }
}
