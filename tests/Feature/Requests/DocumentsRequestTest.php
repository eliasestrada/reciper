<?php

namespace Tests\Feature\Requests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DocumentsRuqusetTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function title_required(): void
    {
        $this->makeRequestAsMaster([
            'title' => '',
            'text' => $text = str_random(300),
        ]);

        $this->assertDatabaseMissing('documents', [
            _('text') => $text,
        ]);
    }

    /**
     * @author Cho
     * @test
     */
    public function text_required(): void
    {
        $this->makeRequestAsMaster([
            'title' => $title = str_random(21),
            'text' => '',
        ]);

        $this->assertDatabaseMissing('documents', [
            _('title') => $title,
        ]);
    }

    /**
     * @author Cho
     * @test
     */
    public function title_must_be_not_short(): void
    {
        $this->makeRequestAsMaster([
            'title' => str_random(config('valid.docs.title.min') - 1),
            'text' => $text = str_random(130),
        ]);

        $this->assertDatabaseMissing('documents', [
            _('text') => $text,
        ]);
    }

    /**
     * @author Cho
     * @test
     */
    public function title_must_be_not_long(): void
    {
        $this->makeRequestAsMaster([
            'title' => str_random(config('valid.docs.title.max') + 1),
            'text' => $text = str_random(130),
        ]);

        $this->assertDatabaseMissing('documents', [
            _('text') => $text,
        ]);
    }

    /**
     * @author Cho
     * @test
     */
    public function text_must_be_not_short(): void
    {
        $this->makeRequestAsMaster([
            'title' => $title = str_random(30),
            'text' => str_random(config('valid.docs.text.min') - 1),
        ]);

        $this->assertDatabaseMissing('documents', [
            _('title') => $title,
        ]);
    }

    /**
     * @author Cho
     * @test
     */
    public function text_must_be_not_long(): void
    {
        $this->makeRequestAsMaster([
            'title' => $title = str_random(32),
            'text' => str_random(config('valid.docs.text.max') + 1),
        ]);

        $this->assertDatabaseMissing('documents', [
            _('title') => $title,
        ]);
    }

    /**
     * Function helper to clear the code
     *
     * @param array $data
     * @return void
     */
    public function makeRequestAsMaster(array $data): void
    {
        $this->actingAs(create_user('master'))
            ->post(action('DocumentController@store'), $data);
    }
}
