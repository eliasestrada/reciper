<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManageUsersRequest;
use App\Models\Ban;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ManageUserController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('master');
    }

    /**
     * Display a listing of users
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
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
     * Display the specified resource with user
     *
     * @param int $user
     * @return \Illuminate\View\View
     */
    public function show(int $user): View
    {
        return view('master.manage-users.show', [
            'user' => User::find($user),
        ]);
    }

    /**
     * Ban user
     *
     * @param \App\Http\Requests\ManageUsersRequest $request
     * @param int $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ManageUsersRequest $request, int $user): RedirectResponse
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
     *
     * @param int $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $user_id): RedirectResponse
    {
        User::find($user_id)->ban()->delete();
        return back()->withSuccess(trans('manage-users.user_unbanned'));
    }
}
