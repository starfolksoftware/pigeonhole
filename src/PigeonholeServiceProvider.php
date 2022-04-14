<?php

namespace StarfolkSoftware\Pigeonhole;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use StarfolkSoftware\Pigeonhole\Actions\CreateCategory;
use StarfolkSoftware\Pigeonhole\Actions\DeleteCategory;
use StarfolkSoftware\Pigeonhole\Actions\UpdateCategory;
use StarfolkSoftware\Pigeonhole\Commands\InstallCommand;

class PigeonholeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('pigeonhole')
            ->hasConfigFile()
            ->hasCommand(InstallCommand::class);

        if (Pigeonhole::$runsMigrations) {
            $package->hasMigration('create_pigeonhole_table');
        }

        if (Pigeonhole::$registersRoutes) {
            $package->hasRoutes('web');
        }
    }

    public function packageRegistered()
    {
        Pigeonhole::createCategoriesUsing(CreateCategory::class);

        Pigeonhole::updateCategoriesUsing(UpdateCategory::class);

        Pigeonhole::deleteCategoriesUsing(DeleteCategory::class);
    }
}
