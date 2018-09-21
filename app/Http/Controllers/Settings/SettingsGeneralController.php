<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\SettingsGeneralRequest;
use App\Models\User;
use Illuminate\Http\Request;

class SettingsGeneralController extends Controller
{
    public function edit()
    {
        return view('settings.general.edit');
    }

    /**
     * @param SettingsGeneralRequest $request
     */
    public function update(SettingsGeneralRequest $request)
    {
        user()->update([
            'name' => $request->name,
            'about_me' => $request->about_me,
        ]);

        return back()->withSuccess(trans('settings.saved'));
    }
}
