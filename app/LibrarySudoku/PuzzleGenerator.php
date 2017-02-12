<?php

namespace App\LibrarySudoku;

class PuzzleGenerator
{
    const DIFFICULTY_LEVELS = [
        ['level' => 1, 'holes' => 30, 'bound' => 5],
        ['level' => 2, 'holes' => 40, 'bound' => 4],
        ['level' => 3, 'holes' => 50, 'bound' => 3],
        ['level' => 4, 'holes' => 60, 'bound' => 2],
        ['level' => 5, 'holes' => 70, 'bound' => 0]
    ];

    /**
     * Difficulty level.
     *
     * @var integer
     */
    private $difficulty;

    private $stack;
    private $sudokuGrid;

    public function generatePuzzle(SudokuGrid $sudokuGrid, $difficulty)
    {
        $this->sudokuGrid = $sudokuGrid;
        $this->difficulty = $difficulty;
        $this->populateRandomStack();
        $this->digHoles();
        return $this->createPuzzle();
    }

    private function populateRandomStack()
    {
        $numberOfHoles = self::DIFFICULTY_LEVELS[$this->difficulty - 1]['holes'];
        for ($i = 0; $i < $numberOfHoles; $i++) {
            $this->stack[] = ['x' => rand(0, 8), 'y' => rand(0, 8)];
        }
    }

    private function digHoles()
    {
        $numberOfHoles = self::DIFFICULTY_LEVELS[$this->difficulty - 1]['holes'];
        $bound = self::DIFFICULTY_LEVELS[$this->difficulty - 1]['bound'];
        for ($i = 0; $i < $numberOfHoles; $i++) {
            if ($this->canDig($this->stack[$i], $bound)) {
                $this->sudokuGrid->setCell($this->stack[$i]['x'], $this->stack[$i]['y'], 0);
            }
        }
    }

    private function canDig($location, $bound)
    {
        $digConsultant = new DigConsultant();
        if ($digConsultant->isSolvableAfterDigging($this->sudokuGrid, $location, $bound)) {
            $response = true;
        } else {
            $response = false;
        }

        return $response;
    }

    private function createPuzzle()
    {
        $sudokuPuzzle = new SudokuPuzzle();
        $sudokuPuzzle->setGrid($this->sudokuGrid);
        return $sudokuPuzzle;
    }
}
