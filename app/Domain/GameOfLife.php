<?php

namespace App\Domain;

use App\Entities\Cell;
use App\Entities\Grid;

class GameOfLife implements GameInterface
{
    public function advance(Grid $grid): Grid
    {
        $neighborCounts = [];
        foreach ($grid->getLiveCells() as $key => $_) {
            [$x, $y] = explode(',', $key);
            $x = (int) $x;
            $y = (int) $y;
            for ($dx = -1; $dx <= 1; $dx++) {
                for ($dy = -1; $dy <= 1; $dy++) {
                    $nx = $x + $dx;
                    $ny = $y + $dy;
                    if (($nx === $x && $ny === $y) || !$grid->inBounds(new Cell($nx, $ny))) {
                        continue;
                    }
                    $nKey = "$nx,$ny";
                    $neighborCounts[$nKey] = ($neighborCounts[$nKey] ?? 0) + 1;
                }
            }
        }

        $newLiveCells = [];
        foreach ($neighborCounts as $key => $count) {
            [$cellX, $cellY] = explode(',', $key);
            $targetCell = new Cell($cellX, $cellY);
            $alive = $grid->isAlive($targetCell);
            if (($alive && ($count === 2 || $count === 3)) || (!$alive && $count === 3)) {
                $newLiveCells[] = $targetCell;
            }
        }
        return new Grid($grid->getSize(), $newLiveCells);
    }
}
