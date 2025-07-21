<?php

declare(strict_types=1);

namespace App\Presentation;

use App\Entities\Cell;
use App\Entities\Grid;

class ConsolePresenter implements PresentationInterface
{
    public function present(Grid $grid): bool
    {
        echo PHP_EOL;
        $size = $grid->getSize();
        for ($x = 0; $x < $size; $x++) {
            for ($y = 0; $y < $size; $y++) {
                echo $grid->isAlive(new Cell($x, $y)) ? '⬛' : '⬜';
            }
            echo PHP_EOL;
        }
        return true;
    }
}
