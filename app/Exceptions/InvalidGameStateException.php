<?php
namespace App\Exceptions;

use Exception;

class InvalidGameStateException extends Exception
{
    public function __construct()
    {
        parent::__construct('Initial state is required to run the game of life');
    }
}
