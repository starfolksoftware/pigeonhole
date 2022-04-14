<?php

namespace StarfolkSoftware\Pigeonhole\Actions;

use StarfolkSoftware\Pigeonhole\Category;
use StarfolkSoftware\Pigeonhole\Contracts\DeletesCategories;
use StarfolkSoftware\Pigeonhole\Pigeonhole;

class DeleteCategory implements DeletesCategories
{
    /**
     * Delete a category.
     *
     * @param  mixed  $user
     * @param  \StarfolkSoftware\Pigeonhole\Category  $category
     * @return void
     */
    public function __invoke($user, Category $category)
    {
        if (is_callable(Pigeonhole::$validateCategoryDeletion)) {
            call_user_func(
                Pigeonhole::$validateCategoryUpdate,
                $user,
                $category
            );
        }

        $category->delete();
    }
}
