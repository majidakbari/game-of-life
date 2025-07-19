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
        $center = intdiv(25, 2);
        $glider = [
            new Cell($center + 0, $center + 1),
            new Cell($center + 1, $center + 2),
            new Cell($center + 2, $center + 0),
            new Cell($center + 2, $center + 1),
            new Cell($center + 2, $center + 2),
        ];
        $initialGrid = new Grid(25, $glider);
        while (true) {
            $this->gameOfLife->draw($initialGrid);
            usleep(200000);
            $newGrid = $this->gameOfLife->advance($initialGrid);
            if ($this->isGameFinished($newGrid, $initialGrid)) {
                break;
            }
            $initialGrid = $newGrid;
        }
        return Command::SUCCESS;
    }

    private function isGameFinished(Grid $newGrid, Grid $grid): bool
    {
        $aKeys = array_keys($newGrid->getLiveCells());
        $bKeys = array_keys($grid->getLiveCells());

        sort($aKeys);
        sort($bKeys);
        return $aKeys === $bKeys;
    }
}
