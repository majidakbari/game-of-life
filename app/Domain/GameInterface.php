<?php

namespace App\Domain;

use App\Entities\Grid;

interface GameInterface
{
    public function advance(Grid $grid): Grid;
}
