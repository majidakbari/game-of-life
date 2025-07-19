<?php

namespace App\Entities;

class Grid
{

    /**
     * @param Cell[] $cells
     */
    public function __construct(private readonly int $size, private readonly array $cells)
    {
    }
}
