<?php

namespace Tests\Feature\Requests;

use Tests\TestCase;
use App\Models\HelpCategory;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HelpRequestTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var array
     */
    private $data = [];

    /**
     * Setup the test environment
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->data = [
            'title' => string_random(30),
            'text' => string_random(70),
            'category' => 1,
        ];
    }

    /**
     * @return void
     */
    public function tearDown(): void
    {
        $this->actingAs(create_user('admin'))
            ->post(action('Master\HelpController@store'), $this->data)
            ->assertRedirect('/');

        parent::tearDown();
    }

    /**
     * @test
     */
    public function title_is_required(): void
    {
        $this->data['title'] = '';
    }

    /**
     * @test
     */
    public function title_must_be_not_short(): void
    {
        $this->data['title'] = string_random(config('valid.help.title.min') - 1);
    }

    /**
     * @test
     */
    public function title_must_be_not_long(): void
    {
        $this->data['title'] = string_random(config('valid.help.title.max') + 1);
    }

    /**
     * @test
     */
    public function text_is_required(): void
    {
        $this->data['text'] = '';
    }

    /**
     * @test
     */
    public function text_must_be_not_short(): void
    {
        $this->data['text'] = string_random(config('valid.help.text.min') - 1);
    }

    /**
     * @test
     */
    public function text_must_be_not_long(): void
    {
        $this->data['text'] = string_random(config('valid.help.text.max') + 1);
    }

    /**
     * @test
     */
    public function category_is_required(): void
    {
        $this->data['category'] = '';
    }

    /**
     * @test
     */
    public function category_must_be_numeric(): void
    {
        $this->data['category'] = 'text';
    }

    /**
     * @test
     */
    public function category_must_be_beetwen_numbers(): void
    {
        $this->data['category'] = HelpCategory::count() + 1;
    }
}
