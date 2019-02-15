<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\HelpRequest;
use App\Http\Responses\Controllers\Master\HelpDestroyResponse;
use App\Http\Responses\Controllers\Master\HelpStoreResponse;
use App\Http\Responses\Controllers\Master\HelpUpdateResponse;
use App\Models\Help;
use App\Models\HelpCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
     * @return \App\Http\Responses\Controllers\Master\HelpStoreResponse
     */
    public function store(HelpRequest $request): HelpStoreResponse
    {
        return new HelpStoreResponse;
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
     * @return \App\Http\Responses\Controllers\Master\HelpUpdateResponse
     */
    public function update(HelpRequest $request, Help $help): HelpUpdateResponse
    {
        return new HelpUpdateResponse($help);
    }

    /**
     * Delete particular help material
     *
     * @param \App\Models\Help $help
     * @return \App\Http\Responses\Controllers\Master\HelpDestroyResponse
     */
    public function destroy(Help $help): HelpDestroyResponse
    {
        return new HelpDestroyResponse($help);
    }
}
