<?php

use StarfolkSoftware\Pigeonhole\Category;
use StarfolkSoftware\Pigeonhole\Contracts\DeletesCategories;
use StarfolkSoftware\Pigeonhole\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Pigeonhole\Pigeonhole::supportsTeams(false);
});

it('can delete a category', function () {
    $deletesCategories = app(DeletesCategories::class);

    $user = TestUser::first();

    $category = Category::factory()->create();

    $deletesCategories($user, $category);

    expect(Category::count())->toEqual(0);
});
