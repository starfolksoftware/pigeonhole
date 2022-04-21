<?php

use StarfolkSoftware\Pigeonhole\Category;
use StarfolkSoftware\Pigeonhole\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Pigeonhole\Pigeonhole::supportsTeams(false);
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

    expect(Category::count())->toEqual(1);

    expect(Category::ofType('product')->count())->toEqual(1);

    expect(Category::ofTypes(['product', 'project'])->count())->toEqual(1);
});

test('category can be updated', function () {
    $user = TestUser::first();

    $category = Category::factory()->create();

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

    $category = Category::factory()->create();

    $response = actingAs($user)->delete(route('categories.destroy', $category), [
        'redirect' => '/redirect/path',
    ]);

    $response->assertRedirect('/redirect/path');

    expect(Category::count())->toEqual(0);
});
