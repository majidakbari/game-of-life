<?php
namespace App\Presentation;

use App\Entities\Grid;

interface PresentationInterface
{
    function present(Grid $grid);
}
