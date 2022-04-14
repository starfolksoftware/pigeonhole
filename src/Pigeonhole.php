<?php

namespace StarfolkSoftware\Pigeonhole;

use StarfolkSoftware\Pigeonhole\Contracts\CreatesCategories;
use StarfolkSoftware\Pigeonhole\Contracts\DeletesCategories;
use StarfolkSoftware\Pigeonhole\Contracts\UpdatesCategories;

final class Pigeonhole
{
    /**
     * Indicates if Pigeonhole routes will be registered.
     *
     * @var bool
     */
    public static $registersRoutes = true;

    /**
     * Indicates if Pigeonhole migrations should be ran.
     *
     * @var bool
     */
    public static $runsMigrations = true;

    /**
     * The category model that should be used by Pigeonhole.
     *
     * @var string
     */
    public static $categoryModel = 'StarfolkSoftware\\Pigeonhole\\Category';

    /**
     * Indicates if Pigeonhole should support teams.
     *
     * @var bool
     */
    public static $supportsTeams = false;

    /**
     * The team model that should be used by Pigeonhole.
     *
     * @var string
     */
    public static $teamModel;

    /**
     * The callback to perform additional validation when creating new category.
     *
     * @var callable
     */
    public static $validateCategoryCreation;

    /**
     * The callback to perform additional validation when updating a category.
     *
     * @var callable
     */
    public static $validateCategoryUpdate;

    /**
     * The callback to perform additional validation when deleting a category.
     *
     * @var callable
     */
    public static $validateCategoryDeletion;

    /**
     * Get the name of the category model used by the application.
     *
     * @return string
     */
    public static function teamModel()
    {
        return static::$teamModel;
    }

    /**
     * Specify the team model that should be used by Pigeonhole.
     *
     * @param  string  $model
     * @return static
     */
    public static function useTeamModel(string $model)
    {
        static::$teamModel = $model;

        return new static();
    }

    /**
     * Get a new instance of the team model.
     *
     * @return mixed
     */
    public static function newTeamModel()
    {
        $model = static::teamModel();

        return new $model();
    }

    /**
     * Find a team instance by the given ID.
     *
     * @param  mixed  $id
     * @return mixed
     */
    public static function findTeamByIdOrFail($id)
    {
        return static::newTeamModel()->whereId($id)->firstOrFail();
    }

    /**
     * Get the name of the category model used by the application.
     *
     * @return string
     */
    public static function categoryModel()
    {
        return static::$categoryModel;
    }

    /**
     * Get a new instance of the category model.
     *
     * @return mixed
     */
    public static function newCategoryModel()
    {
        $model = static::categoryModel();

        return new $model();
    }

    /**
     * Specify the category model that should be used by Pigeonhole.
     *
     * @param  string  $model
     * @return static
     */
    public static function useCategoryModel(string $model)
    {
        static::$categoryModel = $model;

        return new static();
    }

    /**
     * Register a class / callback that should be used to create Categories.
     *
     * @param  string  $class
     * @return void
     */
    public static function createCategoriesUsing(string $class)
    {
        app()->singleton(CreatesCategories::class, $class);
    }

    /**
     * Register a class / callback that should be used to validate category creation.
     *
     * @param  callable  $callback
     * @return void
     */
    public static function validateCategoryCreationUsing(callable $callback)
    {
        static::$validateCategoryCreation = $callback;
    }

    /**
     * Register a class / callback that should be used to update Categories.
     *
     * @param  string  $class
     * @return void
     */
    public static function updateCategoriesUsing(string $class)
    {
        app()->singleton(UpdatesCategories::class, $class);
    }

    /**
     * Register a class / callback that should be used to validate category update.
     *
     * @param  callable  $callback
     * @return void
     */
    public static function validateCategoryUpdateUsing(callable $callback)
    {
        static::$validateCategoryUpdate = $callback;
    }

    /**
     * Register a class / callback that should be used to delete Categories.
     *
     * @param  string  $class
     * @return void
     */
    public static function deleteCategoriesUsing(string $class)
    {
        app()->singleton(DeletesCategories::class, $class);
    }

    /**
     * Register a class / callback that should be used to validate category deletion.
     *
     * @param  callable  $callback
     * @return void
     */
    public static function validateCategoryDeletionUsing(callable $callback)
    {
        static::$validateCategoryDeletion = $callback;
    }

    /**
     * Configure Pigeonhole to not register its routes.
     *
     * @return static
     */
    public static function ignoreRoutes()
    {
        static::$registersRoutes = false;

        return new static();
    }

    /**
     * Configure Pigeonhole to not run its migrations.
     *
     * @return static
     */
    public static function ignoreMigrations()
    {
        static::$runsMigrations = false;

        return new static();
    }

    /**
     * Configure Pigeonhole to support multiple teams.
     *
     * @param  bool  $value
     * @return static
     */
    public static function supportsTeams(bool $value = true)
    {
        static::$supportsTeams = $value;

        return new static();
    }

    /**
     * Get a completion redirect path for a specific feature.
     *
     * @param  string  $redirect
     * @return string
     */
    public static function redirects(string $redirect, $default = null)
    {
        return config('pigeonhole.redirects.'.$redirect) ?? $default ?? '/';
    }
}
