<?php

declare(strict_types=1);

namespace App\Presentation;

use App\Entities\Cell;
use App\Entities\Grid;

class ConsolePresenter implements PresentationInterface
{
    public function present(Grid $grid): bool
    {
        $this->clearTerminal();

        for ($x = 0; $x < $grid->getSize(); $x++) {
            for ($y = 0; $y < $grid->getSize(); $y++) {
                echo $grid->isAlive(new Cell($x, $y)) ? '⬛' : '⬜';
            }
            echo PHP_EOL;
        }
        return true;
    }

    private function clearTerminal(): void
    {
        echo chr(27) . chr(91) . 'H' . chr(27) . chr(91) . 'J';
        echo PHP_EOL;
    }
}
