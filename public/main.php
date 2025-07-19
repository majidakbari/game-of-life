<?php
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use App\Commands\GameOfLifeCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

$application = new Application();
$command = new GameOfLifeCommand();
$application->add($command);

$command->run(new ArrayInput([]), new ConsoleOutput());
