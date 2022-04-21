<?php

namespace StarfolkSoftware\Pigeonhole\Contracts;

use StarfolkSoftware\Pigeonhole\Category;

interface UpdatesCategories
{
    /**
     * Update an existing category.
     *
     * @param  mixed  $user
     * @param  \StarfolkSoftware\Pigeonhole\Category  $category
     * @param  array  $data
     * @return \StarfolkSoftware\Pigeonhole\Category
     */
    public function __invoke($user, Category $category, array $data);
}
