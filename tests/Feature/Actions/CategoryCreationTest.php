<?php

use StarfolkSoftware\Pigeonhole\Contracts\CreatesCategories;
use StarfolkSoftware\Pigeonhole\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Pigeonhole\Pigeonhole::supportsTeams(false);
});

it('can create a tax', function () {
    $createsCategories = app(CreatesCategories::class);

    $user = TestUser::first();

    $tax = $createsCategories(
        $user,
        [
            'name' => 'Category',
        ]
    );

    expect($tax->refresh())
        ->name->toBe('Category');
});
