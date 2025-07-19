<?php

namespace App\Domain;

use App\Entities\Cell;
use App\Entities\Grid;

class GameOfLife
{
    public function advance(Grid $grid): bool
    {
        $neighborCounts = [];

        foreach ($grid->getLiveCells() as $key => $_) {
            [$x, $y] = explode(',', $key);
            $x = (int)$x;
            $y = (int)$y;
            for ($dx = -1; $dx <= 1; $dx++) {
                for ($dy = -1; $dy <= 1; $dy++) {
                    if ($dx === 0 && $dy === 0) continue;

                    $nx = $x + $dx;
                    $ny = $y + $dy;

                    if (!$grid->inBounds(new Cell($nx, $ny))) continue;

                    $nkey = "$nx,$ny";
                    $neighborCounts[$nkey] = ($neighborCounts[$nkey] ?? 0) + 1;
                }
            }
        }

        $newLiveCells = [];

        foreach ($neighborCounts as $key => $count) {
            $alive = isset($this->liveCells[$key]);
            if (($alive && ($count === 2 || $count === 3)) || (!$alive && $count === 3)) {
                $newLiveCells[$key] = true;
            }
        }

        if ($grid->getLiveCells() === $newLiveCells) {
            return false;
        }

        $grid->setLiveCells($newLiveCells);
        return true;
    }

    public function draw(Grid $grid): void
    {
        echo "\033[H\033[2J"; // Clear terminal

        for ($y = 0; $y < $grid->getSize(); $y++) {
            for ($x = 0; $x < $grid->getSize(); $x++) {
                echo isset($this->liveCells["$x,$y"]) ? "⬛" : "⬜";
            }
            echo PHP_EOL;
        }
    }
}
