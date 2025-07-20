<?php
namespace App\Commands;

use App\Domain\GameInterface;
use App\Entities\Cell;
use App\Entities\Grid;
use App\Presentation\PresentationInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:run-game', description: 'Runs the target game until it is over.')]
class RunGameCommand extends Command
{

    public function __construct(
        private readonly GameInterface $game,
        private readonly PresentationInterface $presentation,
    ) {
        parent::__construct();
    }

    public function __invoke(OutputInterface $output): int
    {
        $gridSize = (int) $_ENV['GRID_SIZE'];
        $center = intdiv($gridSize, 2);
        $glider = [
            new Cell($center + 0, $center + 1),
            new Cell($center + 1, $center + 2),
            new Cell($center + 2, $center + 0),
            new Cell($center + 2, $center + 1),
            new Cell($center + 2, $center + 2),
        ];
        $currentState = new Grid($gridSize, $glider);
        while (true) {
            $this->presentation->present($currentState);
            $newState = $this->game->advance($currentState);
            if ($this->isGameOver($newState, $currentState)) {
                break;
            }
            $currentState = $newState;
            usleep(200000);
        }
        return Command::SUCCESS;
    }

    private function isGameOver(Grid $newState, Grid $currentState): bool
    {
        $newLiveCells = array_keys($newState->getLiveCells());
        $currentLiveCells = array_keys($currentState->getLiveCells());
        sort($newLiveCells);
        sort($currentLiveCells);
        return $newLiveCells === $currentLiveCells;
    }
}
