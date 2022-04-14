<?php

namespace StarfolkSoftware\Pigeonhole\Tests\Mocks;

use Illuminate\Database\Eloquent\Model;
use StarfolkSoftware\Pigeonhole\TeamHasCategories;

class TeamModel extends Model
{
    use TeamHasCategories;

    protected $table = 'teams';
}
