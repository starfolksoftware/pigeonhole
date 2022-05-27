<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use StarfolkSoftware\Pigeonhole\Actions\CreateCategory;
use StarfolkSoftware\Pigeonhole\Actions\DeleteCategory;
use StarfolkSoftware\Pigeonhole\Actions\UpdateCategory;
use StarfolkSoftware\Pigeonhole\Pigeonhole;

class PigeonholeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Pigeonhole::createCategoriesUsing(CreateCategory::class);

        Pigeonhole::updateCategoriesUsing(UpdateCategory::class);

        Pigeonhole::deleteCategoriesUsing(DeleteCategory::class);

        Pigeonhole::useCategoryModel(Category::class);
    }
}