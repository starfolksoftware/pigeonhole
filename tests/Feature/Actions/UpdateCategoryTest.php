<?php

use StarfolkSoftware\Pigeonhole\Category;
use StarfolkSoftware\Pigeonhole\Contracts\UpdatesCategories;
use StarfolkSoftware\Pigeonhole\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Pigeonhole\Pigeonhole::supportsTeams(false);
});

it('can update a category', function () {
    $updatesCategories = app(UpdatesCategories::class);

    $user = TestUser::first();

    $category = Category::factory()->create();

    $category = $updatesCategories(
        $user,
        $category,
        [
            'name' => 'Category',
        ]
    );

    expect($category->refresh())
        ->name->toBe('Category');
});
