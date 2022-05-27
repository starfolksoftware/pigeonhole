<?php

use StarfolkSoftware\Pigeonhole\Pigeonhole;
use StarfolkSoftware\Pigeonhole\Tests\Mocks\Category as MocksCategory;
use StarfolkSoftware\Pigeonhole\Tests\Mocks\TestProduct;

beforeAll(function () {
    Pigeonhole::supportsTeams(false);
    Pigeonhole::useCategoryModel(MocksCategory::class);
});

it('can sync category to a model', function () {
    $category = Pigeonhole::newCategoryModel()->factory()->create();

    list($product) = TestProduct::factory()->count(5)->create();

    $product->syncCategories($category);

    expect($product->categories()->count())->toBe(1);

    expect($product->categories()->first())
        ->id->toBe($category->id)
        ->team_id->toBeNull()
        ->type->toBe($category->type)
        ->name->toBe($category->name)
        ->rate->toBe($category->rate);

    // test that only one product has category
    expect($product->hasCategories($category))->toBeTrue();
    expect($product->hasAllCategories($category))->toBeTrue();
    expect(TestProduct::withAllCategories($category)->count())->toBe(1);
    expect(TestProduct::withAnyCategories($category)->count())->toBe(1);
    expect(TestProduct::withoutCategories($category)->count())->toBe(4);
    expect(TestProduct::withoutAnyCategories()->count())->toBe(4);
});

it('can attach and detach category to a model', function () {
    list($category1, $category2, $category3) = Pigeonhole::newCategoryModel()->factory()->count(3)->create();

    list($product) = TestProduct::factory()->count(5)->create();

    $product->attachCategories([$category1->id, $category2->id]);

    expect($product->categories()->count())->toBe(2);

    expect(TestProduct::withoutCategories($category3)->count())->toBe(5);

    expect($product->categories()->first())
        ->id->toBe($category1->id)
        ->team_id->toBeNull()
        ->type->toBe($category1->type)
        ->name->toBe($category1->name)
        ->rate->toBe($category1->rate);

    $product->detachCategories($category1);

    expect($product->categories()->count())->toBe(1);

    expect(TestProduct::withAnyCategories($category2)->count())->toBe(1);

    $product->detachCategories();

    expect($product->categories()->count())->toBe(0);

    expect(TestProduct::withoutAnyCategories()->count())->toBe(5);
});
