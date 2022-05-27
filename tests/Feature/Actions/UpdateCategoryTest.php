<?php

use StarfolkSoftware\Pigeonhole\Tests\Mocks\Category as MocksCategory;
use StarfolkSoftware\Pigeonhole\Category;
use StarfolkSoftware\Pigeonhole\Contracts\UpdatesCategories;
use StarfolkSoftware\Pigeonhole\Pigeonhole;
use StarfolkSoftware\Pigeonhole\Tests\Mocks\TestUser;

beforeAll(function () {
    Pigeonhole::supportsTeams(false);
    Pigeonhole::useCategoryModel(MocksCategory::class);
});

it('can update a category', function () {
    $updatesCategories = app(UpdatesCategories::class);

    $user = TestUser::first();

    $category = Pigeonhole::newCategoryModel()->factory()->create();

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
