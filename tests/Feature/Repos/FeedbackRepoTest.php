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
     * @var \App\Repos\FeedbackRepo $repo
     */
    private $repo;

    /**
     * @author Cho
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->repo = new FeedbackRepo;
    }

    /**
     * @author Cho
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
     * @author Cho
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
     * @author Cho
     * @test
     */
    public function method_alreadyContactedToday_returns_true_if_visitor_send_message_today(): void
    {
        $visitor_id = create(Visitor::class)->id;
        create(Feedback::class, compact('visitor_id'));
        $this->assertTrue($this->repo->alreadyContactedToday($visitor_id));
    }

    /**
     * @author Cho
     * @test
     */
    public function method_alreadyContactedToday_returns_false_if_visitor_didnt_send_message_today(): void
    {
        $visitor_id = create(Visitor::class)->id;
        $this->assertFalse($this->repo->alreadyContactedToday($visitor_id));
    }

    /**
     * @author Cho
     * @test
     */
    public function method_paginateWithLanguage_returns_paginated_feeds_with_given_language(): void
    {
        create(Feedback::class, ['lang' => 'ru'], 1);
        $this->assertCount(1, $this->repo->paginateWithLanguage('ru'));
    }

    /**
     * @author Cho
     * @test
     */
    public function method_paginateWithLanguage_returns_0_if_given_language_doesnt_have_feeds(): void
    {
        create(Feedback::class, ['lang' => 'ru'], 1);
        $this->assertCount(0, $this->repo->paginateWithLanguage('en'));
    }
}
