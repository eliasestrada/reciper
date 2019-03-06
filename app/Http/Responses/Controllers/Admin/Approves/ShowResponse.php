<?php

namespace App\Http\Responses\Controllers\Admin\Approves;

use Illuminate\Contracts\Support\Responsable;
use App\Helpers\Controllers\Admin\ApproveHelpers;
use App\Repos\RecipeRepo;

class ShowResponse implements Responsable
{
    use ApproveHelpers;

    protected $recipe;

    /**
     * @param string $slug
     * @param \App\Repos\RecipeRepo $recipe_repo
     * @return void
     */
    public function __construct(string $slug, RecipeRepo $recipe_repo)
    {
        $this->recipe = $recipe_repo->find($slug);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function toResponse($request)
    {
        $error_message = $this->returnErrorIfApprovedOrNotReady($this->recipe);

        if (!is_null($error_message)) {
            return redirect("/admin/approves")->withError($error_message);
        }

        return view('admin.approves.show', [
            'recipe' => $this->recipe,
            'approver_id' => $this->setAdminAsApprover(),
            'cookie' => getCookie('r_font_size') ?? '1.0',
        ]);
    }

    /**
     * Set admin as approver if there is no approver yet
     *
     * @return int
     */
    protected function setAdminAsApprover(): int
    {
        if (!optional($this->recipe->approver)->id) {
            $this->recipe->update([_('approver_id', true) => user()->id]);
            return user()->id;
        } else {
            return $this->recipe->approver->id;
        }
    }
}
