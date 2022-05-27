<?php

use StarfolkSoftware\Pigeonhole\Tests\Mocks\Category as MocksCategory;
use StarfolkSoftware\Pigeonhole\Contracts\CreatesCategories;
use StarfolkSoftware\Pigeonhole\Pigeonhole;
use StarfolkSoftware\Pigeonhole\Tests\Mocks\TestUser;

beforeAll(function () {
    Pigeonhole::supportsTeams(false);
    Pigeonhole::useCategoryModel(MocksCategory::class);
});

it('can create a category', function () {
    $createsCategories = app(CreatesCategories::class);

    $user = TestUser::first();

    $category = $createsCategories(
        $user,
        [
            'name' => 'Category',
        ]
    );

    expect($category->refresh())
        ->name->toBe('Category');
});

it('can create a category with type', function () {
    $createsCategories = app(CreatesCategories::class);

    $user = TestUser::first();

    $category = $createsCategories(
        $user,
        [
            'name' => 'Category',
            'type' => 'product',
        ]
    );

    expect($category->refresh())
        ->name->toBe('Category');

    expect($category->refresh())
        ->type->toBe('product');

    expect(Pigeonhole::newCategoryModel()->ofType('product')->count())
        ->toBe(1);

    expect(Pigeonhole::newCategoryModel()->ofTypes(['product', 'project'])->count())
        ->toBe(1);
});
