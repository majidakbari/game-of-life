<?php

namespace App\Domain;

use App\Entities\Cell;
use App\Entities\Grid;

class GameOfLife
{
    private Grid $currentState;

    public function advance(): Grid
    {
        $neighborCounts = [];
        foreach ($this->currentState->getLiveCells() as $key => $_) {
            [$x, $y] = explode(',', $key);
            $x = (int)$x;
            $y = (int)$y;
            for ($dx = -1; $dx <= 1; $dx++) {
                for ($dy = -1; $dy <= 1; $dy++) {
                    if ($dx === 0 && $dy === 0) continue;

                    $nx = $x + $dx;
                    $ny = $y + $dy;

                    if (!$this->currentState->inBounds(new Cell($nx, $ny))) continue;

                    $nkey = "$nx,$ny";
                    $neighborCounts[$nkey] = ($neighborCounts[$nkey] ?? 0) + 1;
                }
            }
        }

        $newLiveCells = [];


        foreach ($neighborCounts as $key => $count) {
            $alive = isset($this->currentState->getLiveCells()[$key]);
            if (($alive && ($count === 2 || $count === 3)) || (!$alive && $count === 3)) {
                [$newLiveCellX, $newLiveCellY] = explode(',', $key);
                $newLiveCells[] = new Cell($newLiveCellX, $newLiveCellY);
            }
        }
        return new Grid($this->currentState->getSize(), $newLiveCells);
    }

    public function setCurrentState(Grid $currentState): void
    {
        $this->currentState = $currentState;
    }
}
