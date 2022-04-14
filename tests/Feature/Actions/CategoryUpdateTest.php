<?php

use StarfolkSoftware\Pigeonhole\Category;
use StarfolkSoftware\Pigeonhole\Contracts\UpdatesCategories;
use StarfolkSoftware\Pigeonhole\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Pigeonhole\Pigeonhole::supportsTeams(false);
});

it('can update a tax', function () {
    $updatesCategories = app(UpdatesCategories::class);

    $user = TestUser::first();

    $tax = Category::factory()->create();

    $tax = $updatesCategories(
        $user,
        $tax,
        [
            'name' => 'Category',
        ]
    );

    expect($tax->refresh())
        ->name->toBe('Category');
});
