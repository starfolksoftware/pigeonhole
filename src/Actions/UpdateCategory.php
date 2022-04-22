<?php

namespace StarfolkSoftware\Pigeonhole\Actions;

use Illuminate\Support\Facades\Validator;
use StarfolkSoftware\Pigeonhole\Category;
use StarfolkSoftware\Pigeonhole\Contracts\UpdatesCategories;
use StarfolkSoftware\Pigeonhole\Pigeonhole;

class UpdateCategory implements UpdatesCategories
{
    /**
     * Update a category.
     *
     * @param  mixed  $user
     * @param  \StarfolkSoftware\Pigeonhole\Category  $category
     * @param  array  $data
     * @return \StarfolkSoftware\Pigeonhole\Category
     */
    public function __invoke($user, Category $category, array $data)
    {
        if (is_callable(Pigeonhole::$validateCategoryCreation)) {
            call_user_func(
                Pigeonhole::$validateCategoryUpdate,
                $user,
                $category,
                $data
            );
        }

        Validator::make($data, [
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
        ])->validateWithBag('updateCategory');

        $category->update(collect($data)->only([
            'name',
            'type',
        ])->toArray());

        return $category->refresh();
    }
}
