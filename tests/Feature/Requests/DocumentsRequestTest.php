<?php

namespace Tests\Feature\Requests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DocumentsRuqusetTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function title_required(): void
    {
        $this->makeRequestAsMaster([
            'title' => '',
            'text' => $text = string_random(300),
        ]);

        $this->assertDatabaseMissing('documents', [
            _('text') => $text,
        ]);
    }

    /**
     * @test
     */
    public function text_required(): void
    {
        $this->makeRequestAsMaster([
            'title' => $title = string_random(21),
            'text' => '',
        ]);

        $this->assertDatabaseMissing('documents', [
            _('title') => $title,
        ]);
    }

    /**
     * @test
     */
    public function title_must_be_not_short(): void
    {
        $this->makeRequestAsMaster([
            'title' => string_random(config('valid.docs.title.min') - 1),
            'text' => $text = string_random(130),
        ]);

        $this->assertDatabaseMissing('documents', [
            _('text') => $text,
        ]);
    }

    /**
     * @test
     */
    public function title_must_be_not_long(): void
    {
        $this->makeRequestAsMaster([
            'title' => string_random(config('valid.docs.title.max') + 1),
            'text' => $text = string_random(130),
        ]);

        $this->assertDatabaseMissing('documents', [
            _('text') => $text,
        ]);
    }

    /**
     * @test
     */
    public function text_must_be_not_short(): void
    {
        $this->makeRequestAsMaster([
            'title' => $title = string_random(30),
            'text' => string_random(config('valid.docs.text.min') - 1),
        ]);

        $this->assertDatabaseMissing('documents', [
            _('title') => $title,
        ]);
    }

    /**
     * @test
     */
    public function text_must_be_not_long(): void
    {
        $this->makeRequestAsMaster([
            'title' => $title = string_random(32),
            'text' => string_random(config('valid.docs.text.max') + 1),
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
            ->post(action('Master\DocumentController@store'), $data);
    }
}
