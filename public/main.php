<?php
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use App\Commands\RunGameCommand;
use App\Domain\GameOfLife;
use App\Presentation\ConsolePresenter;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
$dotenv->required('GRID_SIZE')->isInteger();

$application = new Application();
$command = new RunGameCommand(new GameOfLife(), new ConsolePresenter());
$application->add($command);

$command->run(new ArrayInput([]), new ConsoleOutput());
