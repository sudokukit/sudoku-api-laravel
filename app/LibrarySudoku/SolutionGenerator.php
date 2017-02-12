<?php

namespace App\LibrarySudoku;

/**
 * Class SolutionGenerator
 */
class SolutionGenerator
{
    /**
     * @var SudokuGrid
     */
    private $sudokuGrid;

    /**
     * Generates
     * @return SudokuGrid
     */
    public function generateSolution()
    {
        do {
            $this->sudokuGrid = new SudokuGrid();
            $this->placeRandomStarters();
        } while (! $this->sudokuIsSolvable());

        return $this->sudokuGrid;
    }

    /**
     * Places 11 random numbers on the board while adhering to the rules.
     *
     * @return void
     */
    private function placeRandomStarters()
    {
        for ($i = 0; $i < 11; $i++) {
            list($row, $column) = $this->getRandomEmptyCell();
            do {
                $value = rand(1, 9);
                $this->sudokuGrid->setCell($row, $column, $value);
            } while (! $this->isValid());
        }
    }

    /**
     * Checks whether the sudoku currently is valid.
     *
     * @return boolean
     */
    private function isValid()
    {
        $validator = new SudokuValidator();
        return $validator->validate($this->sudokuGrid);
    }

    /**
     * Returns a random currently empty cell.
     *
     * @return array
     */
    private function getRandomEmptyCell()
    {
        do {
            $column = rand(0, 8);
            $row = rand(0, 8);
        } while ($this->sudokuGrid->getCell($row, $column) != 0);
        return [$row, $column];
    }

    /**
     * Uses the backtrack solver to check whether the given sudoku is solvable.
     *
     * @return boolean
     */
    private function sudokuIsSolvable()
    {
        $solver = new BacktrackSolver();
        if (! $solver->solve($this->sudokuGrid)) {
            $response = false;
        } else {
            $response = true;
        }

        return $response;
    }
}
