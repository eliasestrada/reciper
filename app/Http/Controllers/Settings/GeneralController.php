<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\GeneralRequest;
use App\Http\Requests\Settings\SettingsGeneralRequest;
use App\Models\User;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function edit()
    {
        return view('settings.general.edit');
    }

    /**
     * @param SettingsGeneralRequest $request
     */
    public function update(GeneralRequest $request)
    {
        user()->update([
            'name' => $request->name,
            'about_me' => $request->about_me,
        ]);

        return back()->withSuccess(trans('settings.saved'));
    }
}
