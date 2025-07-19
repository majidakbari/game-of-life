<?php
namespace App\Entities;

class Cell
{
    public function __construct(private readonly int $x, private readonly int $y, private readonly bool $alive = true)
    {
    }

    public function coordinates(): string
    {
        return sprintf('%d,%d', $this->x, $this->y);
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function isAlive(): bool
    {
        return $this->alive;
    }
}
