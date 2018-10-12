<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManageUsersRequest;
use App\Models\Ban;
use App\Models\User;
use Illuminate\Http\Request;

class ManageUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::query();

        if ($request->order == 'recipes') {
            $users = $users->withCount('recipes')->orderBy('recipes_count', 'desc');
        }

        if (in_array($request->order, ['streak_days', 'popularity', 'xp'])) {
            $users = $users->orderBy($request->order, 'desc');
        }

        return view('master.manage-users.index', [
            'users' => $users->paginate(50)->onEachSide(1),
            'active' => $request->has('order') ? $request->order : 'id',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        return view('master.manage-users.show', [
            'user' => User::find($user),
        ]);
    }

    /**
     * Ban user
     * @param Request $request
     * @param $user
     * @return void
     */
    public function update(ManageUsersRequest $request, $user)
    {
        $user = User::find($user);

        // Check if user is already banned
        if (Ban::whereUserId($user->id)->exists()) {
            return back()->withError(trans('manage-users.user_already_banned'));
        }

        if ($user->id != 1) {
            Ban::put($user->id, $request->days, $request->message);
            return back()->withSuccess(trans('manage-users.user_banned', ['days' => $request->days]));
        }
        return back();
    }

    /**
     * Unban user
     * @param User $user
     */
    public function destroy($user)
    {
        User::find($user)->ban()->delete();
        return back()->withSuccess(trans('manage-users.user_unbanned'));
    }
}
