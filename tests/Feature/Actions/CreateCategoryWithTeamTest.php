<?php

use StarfolkSoftware\Pigeonhole\Tests\Mocks\Category as MocksCategory;
use StarfolkSoftware\Pigeonhole\Contracts\CreatesCategories;
use StarfolkSoftware\Pigeonhole\Pigeonhole;
use StarfolkSoftware\Pigeonhole\Tests\Mocks\TeamModel;
use StarfolkSoftware\Pigeonhole\Tests\Mocks\TestUser;

beforeAll(function () {
    Pigeonhole::supportsTeams(false);
    Pigeonhole::useCategoryModel(MocksCategory::class);
});

it('can create a category with team support', function () {
    $team = TeamModel::forceCreate(['name' => 'Test Team']);

    Pigeonhole::supportsTeams();

    Pigeonhole::useTeamModel(TeamModel::class);

    $createsCategories = app(CreatesCategories::class);

    $user = TestUser::first();

    $category = $createsCategories(
        $user,
        [
            'name' => 'Category',
        ],
        $team->id,
    );

    expect($category->refresh())
        ->name->toBe('Category');

    expect($category->refresh()->team)
        ->id->toBe($team->id)
        ->name->toBe('Test Team');

    expect($team->refresh()->categories()->count())
        ->toBe(1);
});
