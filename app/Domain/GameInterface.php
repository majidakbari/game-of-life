<?php
namespace App\Domain;

use App\Entities\Grid;

interface GameInterface
{
    function advance(Grid $grid): Grid;
}
