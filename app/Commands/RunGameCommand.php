<?php
namespace App\Commands;

use App\Domain\GameOfLife;
use App\Entities\Cell;
use App\Entities\Grid;
use App\Presentation\PresentationInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:game-of-life', description: 'Runs the the Game of life')]
class RunGameCommand extends Command
{

    public function __construct(
        private readonly GameOfLife $gameOfLife,
        private readonly PresentationInterface $presentation,
    ) {
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
            $this->gameOfLife->setCurrentState($initialGrid);
            $this->presentation->present($initialGrid);
            $newGrid = $this->gameOfLife->advance();
            if ($this->isGameOver($newGrid, $initialGrid)) {
                break;
            }
            $initialGrid = $newGrid;
            usleep(200000);
        }
        return Command::SUCCESS;
    }

    private function isGameOver(Grid $newGrid, Grid $grid): bool
    {
        $newLiveCells = array_keys($newGrid->getLiveCells());
        $currentLiveCells = array_keys($grid->getLiveCells());
        sort($newLiveCells);
        sort($currentLiveCells);
        return $newLiveCells === $currentLiveCells;
    }
}
