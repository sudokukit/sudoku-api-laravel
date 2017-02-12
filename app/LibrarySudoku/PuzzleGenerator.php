<?php

namespace App\LibrarySudoku;

class PuzzleGenerator
{
    private $difficulty;
    private $levels = [
        ['level' => 1, 'holes' => 30, 'bound' => 5],
        ['level' => 2, 'holes' => 40, 'bound' => 4],
        ['level' => 3, 'holes' => 50, 'bound' => 3],
        ['level' => 4, 'holes' => 60, 'bound' => 2],
        ['level' => 5, 'holes' => 70, 'bound' => 0]
    ];
    private $stack;
    private $sudokuGrid;

    public function generatePuzzle(SudokuGrid $sudokuGrid, $difficulty)
    {
        $this->sudokuGrid = $sudokuGrid;
        $this->setDifficulty($difficulty);
        $this->populateRandomStack();
        $this->digHoles();
        return $this->createPuzzle();
    }

    public function mockPuzzle()
    {
        $puzzleAsString = "004060007010970040006050030045300021009102700620005490050010900090024060200030100";
        $sudokuParser = new SudokuParser;
        $this->sudokuGrid = $sudokuParser->parse($puzzleAsString);
        $this->setDifficulty(3);
        return $this->createPuzzle();
    }

    private function setDifficulty($difficulty)
    {
        if ($difficulty < 1 || $difficulty > 5) {
            $difficulty = 3;
        }
        $this->difficulty = $difficulty;
    }

    private function populateRandomStack()
    {
        $numberOfHoles = $this->levels[$this->difficulty - 1]['holes'];
        for ($i = 0; $i < $numberOfHoles; $i++) {
            $this->stack[] = ['x' => rand(0, 8), 'y' => rand(0, 8)];
        }
    }

    private function digHoles()
    {
        $numberOfHoles = $this->levels[$this->difficulty - 1]['holes'];
        $bound = $this->levels[$this->difficulty - 1]['bound'];
        for ($i = 0; $i < $numberOfHoles; $i++) {
            if ($this->canDig($this->stack[$i], $bound)) {
                $this->sudokuGrid->setCell($this->stack[$i]['x'], $this->stack[$i]['y'], 0);
            }
        }
    }

    private function canDig($location, $bound)
    {
        $digConsultant = new DigConsultant;
        if (! $digConsultant->ConsultOnDigging($this->sudokuGrid, $location, $bound)) {
            return false;
        }
        return true;
    }

    private function createPuzzle()
    {
        $sudokuPuzzle = new SudokuPuzzle;
        $sudokuPuzzle->setId('uuid123'); // TODO store in db and retrieve uuid
        $sudokuPuzzle->setSolutionId('uuid123'); // TODO get from solution
        $sudokuPuzzle->setDifficulty($this->difficulty);
        $sudokuPuzzle->setPuzzle($this->sudokuGrid);
        return $sudokuPuzzle;
    }
}
