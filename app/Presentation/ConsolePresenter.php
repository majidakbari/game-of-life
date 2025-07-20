<?php

declare(strict_types=1);

namespace App\Presentation;

use App\Entities\Cell;
use App\Entities\Grid;

class ConsolePresenter implements PresentationInterface
{
    public function present(Grid $grid): void
    {
        echo PHP_EOL;
        for ($x = 0; $x < $grid->getSize(); $x++) {
            for ($y = 0; $y < $grid->getSize(); $y++) {
                echo $grid->isAlive(new Cell($x, $y)) ? '⬛' : '⬜';
            }
            echo PHP_EOL;
        }
    }
}
