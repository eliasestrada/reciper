<?php

namespace Tests\Feature\Requests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DocumentsRuqusetTest extends TestCase
{
    use DatabaseTransactions;

    private $request;

    /**
     * @author Cho
     */
    public function setUp()
    {
        parent::setUp();
        $this->actingAs($master = create_user('master'))->get('/master/documents');
        $this->request = $this->actingAs($master)->followingRedirects();
    }

    /**
     * @author Cho
     * @test
     */
    public function title_required(): void
    {
        $this->request->post(action('Master\DocumentsController@store'), [
            'title' => '',
            'text' => str_random(300),
        ])->assertSeeText(trans('documents.title_required'));
    }

    /**
     * @author Cho
     * @test
     */
    public function text_required(): void
    {
        $this->request->post(action('Master\DocumentsController@store'), [
            'title' => str_random(21),
            'text' => '',
        ])->assertSeeText(trans('documents.text_required'));
    }

    /**
     * @author Cho
     * @test
     */
    public function title_must_be_not_short(): void
    {
        $this->request->post(action('Master\DocumentsController@store'), [
            'title' => str_random(config('valid.docs.title.min') - 1),
            'text' => str_random(130),
        ])->assertSeeText(preg_replace('/:min/', config('valid.docs.title.min'), trans('documents.title_min')));
    }

    /**
     * @author Cho
     * @test
     */
    public function title_must_be_not_long(): void
    {
        $this->request->post(action('Master\DocumentsController@store'), [
            'title' => str_random(config('valid.docs.title.max') + 1),
            'text' => str_random(130),
        ])->assertSeeText(preg_replace('/:max/', config('valid.docs.title.max'), trans('documents.title_max')));
    }

    /**
     * @author Cho
     * @test
     */
    public function text_must_be_not_short(): void
    {
        $this->request->post(action('Master\DocumentsController@store'), [
            'title' => str_random(30),
            'text' => str_random(config('valid.docs.text.min') - 1),
        ])->assertSeeText(preg_replace('/:min/', config('valid.docs.text.min'), trans('documents.text_min')));
    }

    /**
     * @author Cho
     * @test
     */
    public function text_must_be_not_long(): void
    {
        $this->request->post(action('Master\DocumentsController@store'), [
            'title' => str_random(32),
            'text' => str_random(config('valid.docs.text.max') + 1),
        ])->assertSeeText(preg_replace('/:max/', config('valid.docs.text.max'), trans('documents.text_max')));
    }
}
