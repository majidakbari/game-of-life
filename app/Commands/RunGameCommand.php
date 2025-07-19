<?php
namespace App\Commands;

use App\Domain\GameOfLife;
use App\Entities\Cell;
use App\Entities\Grid;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:game-of-life', description: 'Runs the the Game of life')]
class RunGameCommand extends Command
{

    public function __construct(private readonly GameOfLife $gameOfLife)
    {
        parent::__construct();
    }

    public function __invoke(OutputInterface $output): int
    {
        $center = intdiv(50, 2);
        $glider = [
            new Cell($center + 0, $center + 1),
            new Cell($center + 1, $center + 2),
            new Cell($center + 2, $center + 0),
            new Cell($center + 2, $center + 1),
            new Cell($center + 2, $center + 2),
        ];
        $grid = new Grid(50, $glider);
        while (true) {
            $this->gameOfLife->draw($grid);
            usleep(200000);
            if (!$this->gameOfLife->advance($grid)) {
                break;
            }
        }
        return Command::SUCCESS;
    }
}
