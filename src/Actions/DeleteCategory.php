<?php

namespace StarfolkSoftware\Pigeonhole\Actions;

use StarfolkSoftware\Pigeonhole\Contracts\DeletesCategories;
use StarfolkSoftware\Pigeonhole\Events\CategoryDeleted;
use StarfolkSoftware\Pigeonhole\Events\DeletingCategory;

class DeleteCategory implements DeletesCategories
{
    /**
     * Delete a category.
     *
     * @param  mixed  $user
     * @param  mixed  $category
     * @return void
     */
    public function __invoke($user, $category)
    {
        event(new DeletingCategory(user: $user, category: $category));

        $category->delete();

        event(new CategoryDeleted(category: $category));
    }
}
