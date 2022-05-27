<?php

use StarfolkSoftware\Pigeonhole\Tests\Mocks\Category as MocksCategory;
use StarfolkSoftware\Pigeonhole\Contracts\DeletesCategories;
use StarfolkSoftware\Pigeonhole\Pigeonhole;
use StarfolkSoftware\Pigeonhole\Tests\Mocks\TestUser;

beforeAll(function () {
    Pigeonhole::supportsTeams(false);
    Pigeonhole::useCategoryModel(MocksCategory::class);
});

it('can delete a category', function () {
    $deletesCategories = app(DeletesCategories::class);

    $user = TestUser::first();

    $category = Pigeonhole::newCategoryModel()->factory()->create();

    $deletesCategories($user, $category);

    expect(Pigeonhole::newCategoryModel()->count())->toEqual(0);
});
