<?php

namespace App\Presentation;

use App\Entities\Grid;

interface PresentationInterface
{
    public function present(Grid $grid): mixed;
}
