<?php

use StarfolkSoftware\Pigeonhole\Category;
use StarfolkSoftware\Pigeonhole\Contracts\CreatesCategories;
use StarfolkSoftware\Pigeonhole\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Pigeonhole\Pigeonhole::supportsTeams(false);
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

    expect(Category::ofType('product')->count())
        ->toBe(1);

    expect(Category::ofTypes(['product', 'project'])->count())
        ->toBe(1);
});
