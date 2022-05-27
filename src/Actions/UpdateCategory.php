<?php

namespace StarfolkSoftware\Pigeonhole\Actions;

use Illuminate\Support\Facades\Validator;
use StarfolkSoftware\Pigeonhole\Category;
use StarfolkSoftware\Pigeonhole\Contracts\UpdatesCategories;
use StarfolkSoftware\Pigeonhole\Events\CategoryUpdated;
use StarfolkSoftware\Pigeonhole\Events\UpdatingCategory;

class UpdateCategory implements UpdatesCategories
{
    /**
     * Update a category.
     *
     * @param  mixed  $user
     * @param  mixed  $category
     * @param  array  $data
     * @return mixed
     */
    public function __invoke($user, $category, array $data)
    {
        event(new UpdatingCategory(user: $user, category: $category, data: $data));

        Validator::make($data, [
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
        ])->validateWithBag('updateCategory');

        $category->update(collect($data)->only([
            'name',
            'type',
        ])->toArray());

        $category->refresh();

        event(new CategoryUpdated(category: $category));

        return $category;
    }
}
