<?php

namespace Tests\Feature\Validation;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DocumentsValidTest extends TestCase
{
    use DatabaseTransactions;

    private $request;
    private $title_max;
    private $title_min;
    private $text_max;
    private $text_min;

    public function setUp()
    {
        parent::setUp();
        $this->request = $this->actingAs(create_user('master'))->followingRedirects();
        $this->title_max = config('validation.docs_title_max');
        $this->title_min = config('validation.docs_title_min');
        $this->text_max = config('validation.docs_text_max');
        $this->text_min = config('validation.docs_text_min');
    }

    /** @test */
    public function title_required(): void
    {
        $this->request->post(action('Master\DocumentsController@store'), [
            'title' => '',
            'text' => str_random(300),
        ])->assertSeeText(trans('documents.title_required'));
    }

    /** @test */
    public function text_required(): void
    {
        $this->request->post(action('Master\DocumentsController@store'), [
            'title' => str_random(21),
            'text' => '',
        ])->assertSeeText(trans('documents.text_required'));
    }

    /** @test */
    public function title_must_be_not_short(): void
    {
        $this->request->post(action('Master\DocumentsController@store'), [
            'title' => str_random($this->title_min - 1),
            'text' => str_random(130),
        ])->assertSeeText(preg_replace('/:min/', $this->title_min, trans('documents.title_min')));
    }

    /** @test */
    public function title_must_be_not_long(): void
    {
        $this->request->post(action('Master\DocumentsController@store'), [
            'title' => str_random($this->title_max + 1),
            'text' => str_random(130),
        ])->assertSeeText(preg_replace('/:max/', $this->title_max, trans('documents.title_max')));
    }

    /** @test */
    public function text_must_be_not_short(): void
    {
        $this->request->post(action('Master\DocumentsController@store'), [
            'title' => str_random(30),
            'text' => str_random($this->text_min - 1),
        ])->assertSeeText(preg_replace('/:min/', $this->text_min, trans('documents.text_min')));
    }

    /** @test */
    public function text_must_be_not_long(): void
    {
        $this->request->post(action('Master\DocumentsController@store'), [
            'title' => str_random(32),
            'text' => str_random($this->text_max + 1),
        ])->assertSeeText(preg_replace('/:max/', $this->text_max, trans('documents.text_max')));
    }
}
