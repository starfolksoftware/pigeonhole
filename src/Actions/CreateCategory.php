<?php

namespace StarfolkSoftware\Pigeonhole\Actions;

use Illuminate\Support\Facades\Validator;
use StarfolkSoftware\Pigeonhole\Contracts\CreatesCategories;
use StarfolkSoftware\Pigeonhole\Pigeonhole;

class CreateCategory implements CreatesCategories
{
    /**
     * Create a new category.
     *
     * @param  mixed  $user
     * @param  array  $data
     * @param  mixed  $teamId
     * @return \StarfolkSoftware\Pigeonhole\Category
     */
    public function __invoke($user, array $data, $teamId = null)
    {
        if (is_callable(Pigeonhole::$validateCategoryCreation)) {
            call_user_func(
                Pigeonhole::$validateCategoryCreation,
                $user,
                $data
            );
        }

        Validator::make($data, [
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
        ])->validateWithBag('createCategory');

        $fields = collect($data)->only([
            'name',
            'type',
        ])->toArray();

        return Pigeonhole::$supportsTeams ?
            Pigeonhole::findTeamByIdOrFail($teamId)->categories()->create($fields) :
            Pigeonhole::newCategoryModel()->create($fields);
    }
}
