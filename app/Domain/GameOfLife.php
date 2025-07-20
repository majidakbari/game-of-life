<?php

namespace App\Domain;

use App\Entities\Cell;
use App\Entities\Grid;
use App\Exceptions\InvalidGameStateException;

class GameOfLife
{
    private Grid $currentState;

    /**
     * @throws InvalidGameStateException
     */
    public function advance(): Grid
    {
        if (!isset($this->currentState)) {
            throw new InvalidGameStateException();
        }
        $neighborCounts = [];
        foreach ($this->currentState->getLiveCells() as $key => $_) {
            [$x, $y] = explode(',', $key);
            $x = (int) $x;
            $y = (int) $y;
            for ($dx = -1; $dx <= 1; $dx++) {
                for ($dy = -1; $dy <= 1; $dy++) {
                    $nx = $x + $dx;
                    $ny = $y + $dy;
                    if (($nx === $x && $ny === $y) || !$this->currentState->inBounds(new Cell($nx, $ny))) {
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
            $alive = $this->currentState->isAlive($targetCell);
            if (($alive && ($count === 2 || $count === 3)) || (!$alive && $count === 3)) {
                $newLiveCells[] = $targetCell;
            }
        }
        return new Grid($this->currentState->getSize(), $newLiveCells);
    }

    public function setCurrentState(Grid $currentState): void
    {
        $this->currentState = $currentState;
    }
}
