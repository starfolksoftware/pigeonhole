<?php

namespace App\Models;

use StarfolkSoftware\Pigeonhole\Category as PigeonholeCategory;
use StarfolkSoftware\Pigeonhole\Events\CategoryCreated;
use StarfolkSoftware\Pigeonhole\Events\CategoryDeleted;
use StarfolkSoftware\Pigeonhole\Events\CategoryUpdated;

class Category extends PigeonholeCategory
{
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