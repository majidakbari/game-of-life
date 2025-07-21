<?php

namespace App\Entities;

/**
 * Class Grid
 * Implementing Hashmap data structure to have constant time complexity when accessing cells
 */
class Grid
{
    /**
     * @var array<string, bool>
     */
    private array $liveCellsMap = [];

    /**
     * @param Cell[] $liveCells
     */
    public function __construct(private readonly int $size, private readonly array $liveCells)
    {
        foreach ($liveCells as $cell) {
            if ($this->inBounds($cell) && $cell->isAlive()) {
                $this->liveCellsMap[$cell->coordinates()] = true;
            }
        }
    }

    public function inBounds(Cell $cell): bool
    {
        return $cell->getX() >= 0 && $cell->getX() < $this->size && $cell->getY() >= 0 && $cell->getY() < $this->size;
    }

    public function isAlive(Cell $cell): bool
    {
        return isset($this->liveCellsMap[$cell->coordinates()]);
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getLiveCells(): array
    {
        return $this->liveCells;
    }
}
