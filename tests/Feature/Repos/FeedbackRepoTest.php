<?php

namespace Tests\Feature\Repos;

use App\Models\Feedback;
use App\Models\Recipe;
use App\Models\Visitor;
use App\Repos\FeedbackRepo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FeedbackRepoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function alreadyReportedToday_method_returns_true_if_given_recipe_was_reported_today(): void
    {
        $visitor_id = create(Visitor::class)->id;
        $recipe_id = create(Recipe::class)->id;

        create(Feedback::class, compact('visitor_id', 'recipe_id'), null, 'report');

        $result = FeedbackRepo::alreadyReportedToday($visitor_id, $recipe_id);
        $this->assertTrue($result);
    }

    /**
     * @author Cho
     * @test
     */
    public function alreadyReportedToday_method_returns_false_if_given_recipe_wasnt_reported_today(): void
    {
        $visitor_id = create(Visitor::class)->id;
        $recipe_id = create(Recipe::class)->id;

        create(Feedback::class, compact('visitor_id'));

        $result = FeedbackRepo::alreadyReportedToday($visitor_id, $recipe_id);
        $this->assertFalse($result);
    }

    /**
     * @author Cho
     * @test
     */
    public function alreadyContactedToday_method_returns_true_if_visitor_send_message_today(): void
    {
        $visitor_id = create(Visitor::class)->id;
        create(Feedback::class, compact('visitor_id'));
        $this->assertTrue(FeedbackRepo::alreadyContactedToday($visitor_id));
    }

    /**
     * @author Cho
     * @test
     */
    public function alreadyContactedToday_method_returns_false_if_visitor_didnt_send_message_today(): void
    {
        $visitor_id = create(Visitor::class)->id;
        $this->assertFalse(FeedbackRepo::alreadyContactedToday($visitor_id));
    }
}
