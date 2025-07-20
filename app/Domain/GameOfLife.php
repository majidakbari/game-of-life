<?php

namespace App\Domain;

use App\Entities\Cell;
use App\Entities\Grid;

class GameOfLife implements GameInterface
{
    public function advance(Grid $grid): Grid
    {
        $liveNeighbours = $this->countLiveNeighbours($grid);
        $newLiveCells = $this->applyRules($liveNeighbours, $grid);
        return new Grid($grid->getSize(), $newLiveCells);
    }

    /**
     * @return array<string, int>
     */
    public function countLiveNeighbours(Grid $grid): array
    {
        $output = [];
        foreach ($grid->getLiveCells() as $key => $_) {
            [$x, $y] = explode(',', $key);
            $x = (int)$x;
            $y = (int)$y;
            for ($dx = -1; $dx <= 1; $dx++) {
                for ($dy = -1; $dy <= 1; $dy++) {
                    $nx = $x + $dx;
                    $ny = $y + $dy;
                    if (($nx === $x && $ny === $y) || !$grid->inBounds(new Cell($nx, $ny))) {
                        continue;
                    }
                    $nKey = "$nx,$ny";
                    $output[$nKey] = ($output[$nKey] ?? 0) + 1;
                }
            }
        }
        return $output;
    }

    /**
     * @return Cell[]
     */
    public function applyRules(array $liveNeighbours, Grid $grid): array
    {
        $newLiveCells = [];
        foreach ($liveNeighbours as $key => $count) {
            [$cellX, $cellY] = explode(',', $key);
            $targetCell = new Cell($cellX, $cellY);
            $alive = $grid->isAlive($targetCell);
            if (($alive && ($count === 2 || $count === 3)) || (!$alive && $count === 3)) {
                $newLiveCells[] = $targetCell;
            }
        }
        return $newLiveCells;
    }
}
