<?php

namespace StarfolkSoftware\Pigeonhole\Tests\Mocks;

use StarfolkSoftware\Pigeonhole\Category as PigeonholeCategory;
use StarfolkSoftware\Pigeonhole\Events\CategoryCreated;
use StarfolkSoftware\Pigeonhole\Events\CategoryDeleted;
use StarfolkSoftware\Pigeonhole\Events\CategoryUpdated;

class Category extends PigeonholeCategory
{
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return CategoryFactory::new();
    }

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => CategoryCreated::class,
        'updated' => CategoryUpdated::class,
        'deleted' => CategoryDeleted::class,
    ];
}
