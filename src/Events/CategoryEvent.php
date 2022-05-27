<?php

namespace StarfolkSoftware\Pigeonhole\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class CategoryEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param  mixed  $user
     * @param  mixed  $category
     * @param  array  $data
     * @return void
     */
    public function __construct(
        public $user = null,
        public $category = null,
        public $data = []
    ) {
    }
}