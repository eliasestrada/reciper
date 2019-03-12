<?php

namespace App\Http\Controllers\Master;

use App\Models\Help;
use Illuminate\View\View;
use App\Models\HelpCategory;
use Illuminate\Http\Request;
use App\Http\Requests\HelpRequest;
use App\Http\Controllers\Controller;
use App\Http\Responses\Controllers\Master\Help\StoreResponse;
use App\Http\Responses\Controllers\Master\Help\UpdateResponse;
use App\Http\Responses\Controllers\Master\Help\DestroyResponse;

class HelpController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show create page
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('master.help.create', ['categories' => HelpCategory::get()]);
    }

    /**
     * Store data in database and clean cache
     *
     * @param \App\Http\Requests\HelpRequest $request
     * @return \App\Http\Responses\Controllers\Master\Help\StoreResponse
     */
    public function store(HelpRequest $request): StoreResponse
    {
        return new StoreResponse;
    }

    /**
     * Show edit page
     *
     * @param \App\Models\Help
     * @return \Illuminate\View\View
     */
    public function edit(Help $help): View
    {
        return view('master.help.edit', [
            'help' => $help,
            'categories' => HelpCategory::get(),
        ]);
    }

    /**
     * Update existing help material
     *
     * @param \App\Http\Requests\HelpRequest $request
     * @param \App\Models\Help $help
     * @return \App\Http\Responses\Controllers\Master\Help\UpdateResponse
     */
    public function update(HelpRequest $request, Help $help): UpdateResponse
    {
        return new UpdateResponse($help);
    }

    /**
     * Delete particular help material
     *
     * @param \App\Models\Help $help
     * @return \App\Http\Responses\Controllers\Master\Help\DestroyResponse
     */
    public function destroy(Help $help): DestroyResponse
    {
        return new DestroyResponse($help);
    }
}
