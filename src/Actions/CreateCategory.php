<?php

namespace StarfolkSoftware\Pigeonhole\Actions;

use Illuminate\Support\Facades\Validator;
use StarfolkSoftware\Pigeonhole\Contracts\CreatesCategories;
use StarfolkSoftware\Pigeonhole\Events\CategoryCreated;
use StarfolkSoftware\Pigeonhole\Events\CreatingCategory;
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
        event(new CreatingCategory(user: $user, data: $data));

        Validator::make($data, [
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
        ])->validateWithBag('createCategory');

        $fields = collect($data)->only([
            'name',
            'type',
        ])->toArray();

        $category = Pigeonhole::$supportsTeams ?
            Pigeonhole::findTeamByIdOrFail($teamId)->categories()->create($fields) :
            Pigeonhole::newCategoryModel()->create($fields);

        event(new CategoryCreated(category: $category));

        return $category;
    }
}
