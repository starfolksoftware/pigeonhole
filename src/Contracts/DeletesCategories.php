<?php

namespace StarfolkSoftware\Pigeonhole\Contracts;

use StarfolkSoftware\Pigeonhole\Category;

interface DeletesCategories
{
    /**
     * Delete an existing tax.
     *
     * @param  mixed  $user
     * @param  \StarfolkSoftware\Pigeonhole\Category  $tax
     * @return void
     */
    public function __invoke($user, Category $tax);
}
