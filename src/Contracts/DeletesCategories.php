<?php

namespace StarfolkSoftware\Pigeonhole\Contracts;

use StarfolkSoftware\Pigeonhole\Category;

interface DeletesCategories
{
    /**
     * Delete an existing category.
     *
     * @param  mixed  $user
     * @param  \StarfolkSoftware\Pigeonhole\Category  $category
     * @return void
     */
    public function __invoke($user, Category $category);
}
