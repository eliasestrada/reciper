<?php

namespace Tests\Feature\Requests;

use App\Models\HelpCategory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class HelpRequestTest extends TestCase
{
    use DatabaseTransactions;

    private $data = [];

    /**
     * @author Cho
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->data = [
            'title' => str_random('30'),
            'text' => str_random('70'),
            'category' => 1,
        ];
    }

    /**
     * @author Cho
     */
    public function tearDown(): void
    {
        $this->actingAs(create_user('admin'))
            ->post(action('Master\HelpController@store'), $this->data)
            ->assertRedirect('/');

        parent::tearDown();
    }

    /**
     * @author Cho
     * @test
     */
    public function title_is_required(): void
    {
        $this->data['title'] = '';
    }

    /**
     * @author Cho
     * @test
     */
    public function title_must_be_not_short(): void
    {
        $this->data['title'] = str_random(config('valid.help.title.min') - 1);
    }

    /**
     * @author Cho
     * @test
     */
    public function title_must_be_not_long(): void
    {
        $this->data['title'] = str_random(config('valid.help.title.max') + 1);
    }

    /**
     * @author Cho
     * @test
     */
    public function text_is_required(): void
    {
        $this->data['text'] = '';
    }

    /**
     * @author Cho
     * @test
     */
    public function text_must_be_not_short(): void
    {
        $this->data['text'] = str_random(config('valid.help.text.min') - 1);
    }

    /**
     * @author Cho
     * @test
     */
    public function text_must_be_not_long(): void
    {
        $this->data['text'] = str_random(config('valid.help.text.max') + 1);
    }

    /**
     * @author Cho
     * @test
     */
    public function category_is_required(): void
    {
        $this->data['category'] = '';
    }

    /**
     * @author Cho
     * @test
     */
    public function category_must_be_numeric(): void
    {
        $this->data['category'] = 'text';
    }

    /**
     * @author Cho
     * @test
     */
    public function category_must_be_beetwen_numbers(): void
    {
        $this->data['category'] = HelpCategory::count() + 1;
    }
}
