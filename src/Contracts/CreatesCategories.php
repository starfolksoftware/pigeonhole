<?php

namespace StarfolkSoftware\Pigeonhole\Contracts;

interface CreatesCategories
{
    /**
     * Create a new category.
     *
     * @param  mixed  $user
     * @param  array  $data
     * @param  mixed  $teamId
     * @return \StarfolkSoftware\Pigeonhole\Category
     */
    public function __invoke($user, array $data, $teamId = null);
}
