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
        $output->writeln('<info>Running the game</info>');

        $gridSize = (int) $_ENV['GRID_SIZE'];
        $center = intdiv($gridSize, 2);
        $glider = [
            new Cell($center - 1, $center),
            new Cell($center, $center + 1),
            new Cell($center + 1, $center - 1),
            new Cell($center + 1, $center),
            new Cell($center + 1, $center + 1),
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

        $output->writeln('<info>The game is over!</info>');
        return Command::SUCCESS;
    }

    private function isGameOver(Grid $newState, Grid $currentState): bool
    {
        $newLiveCells = array_map(fn (Cell $cell) => $cell->coordinates(), $newState->getLiveCells());
        $currentLiveCells = array_map(fn (Cell $cell) => $cell->coordinates(), $currentState->getLiveCells());
        sort($newLiveCells);
        sort($currentLiveCells);
        return $newLiveCells === $currentLiveCells;
    }
}
