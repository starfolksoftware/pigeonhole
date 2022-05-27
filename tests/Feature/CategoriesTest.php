<?php

use StarfolkSoftware\Pigeonhole\Tests\Mocks\Category as MocksCategory;
use StarfolkSoftware\Pigeonhole\Pigeonhole;
use StarfolkSoftware\Pigeonhole\Tests\Mocks\TestUser;

beforeAll(function () {
    Pigeonhole::supportsTeams(false);
    Pigeonhole::useCategoryModel(MocksCategory::class);
});

test('category can be created', function () {
    $user = TestUser::first();

    $response = actingAs($user)->post(route('categories.store'), [
        'name' => 'Category',
        'type' => 'product',
        'redirect' => '/redirect/path',
    ]);

    $response->assertRedirect('/redirect/path');

    $this->assertDatabaseHas('categories', [
        'name' => 'Category',
        'type' => 'product',
    ]);

    expect(Pigeonhole::newCategoryModel()->count())->toEqual(1);

    expect(Pigeonhole::newCategoryModel()->ofType('product')->count())->toEqual(1);

    expect(Pigeonhole::newCategoryModel()->ofTypes(['product', 'project'])->count())->toEqual(1);
});

test('category can be updated', function () {
    $user = TestUser::first();

    $category = Pigeonhole::newCategoryModel()->factory()->create();

    $response = actingAs($user)->put(route('categories.update', $category), [
        'name' => 'Category',
        'redirect' => '/redirect/path',
    ]);

    $response->assertRedirect('/redirect/path');

    $this->assertDatabaseHas('categories', [
        'name' => 'Category',
    ]);
});

test('category can be deleted', function () {
    $user = TestUser::first();

    $category = Pigeonhole::newCategoryModel()->factory()->create();

    $response = actingAs($user)->delete(route('categories.destroy', $category), [
        'redirect' => '/redirect/path',
    ]);

    $response->assertRedirect('/redirect/path');

    expect(Pigeonhole::newCategoryModel()->count())->toEqual(0);
});
