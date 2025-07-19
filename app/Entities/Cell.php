<?php

namespace App\Entities;

class Cell
{

    public function __construct(private readonly int $x, private readonly int $y, private readonly bool $value)
    {
    }
}
