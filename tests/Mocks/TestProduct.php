<?php

namespace StarfolkSoftware\Pigeonhole\Tests\Mocks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use StarfolkSoftware\Pigeonhole\Categorizable;

class TestProduct extends Model
{
    use HasFactory;
    use Categorizable;

    protected $table = 'products';
}
