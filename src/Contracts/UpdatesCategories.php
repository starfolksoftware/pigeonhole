<?php

namespace StarfolkSoftware\Pigeonhole\Contracts;

use StarfolkSoftware\Pigeonhole\Category;

interface UpdatesCategories
{
    /**
     * Update an existing tax.
     *
     * @param  mixed  $user
     * @param  \StarfolkSoftware\Pigeonhole\Category  $tax
     * @param  array  $data
     * @return \StarfolkSoftware\Pigeonhole\Category
     */
    public function __invoke($user, Category $tax, array $data);
}
