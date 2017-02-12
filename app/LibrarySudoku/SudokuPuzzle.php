<?php

namespace App\LibrarySudoku;

/**
 * Class SudokuPuzzle
 */
class SudokuPuzzle
{
    /**
     * The puzzle.
     *
     * @var array
     */
    private $puzzle;

    /**
     * Getter for the puzzle.
     *
     * @return array
     */
    public function getPuzzle()
    {
        return $this->puzzle;
    }

    /**
     * Fills the puzzle with given grid.
     *
     * @param SudokuGrid $sudokuGrid The sudoku grid.
     *
     * @return void
     */
    public function setGrid(SudokuGrid $sudokuGrid)
    {
        for ($i = 0; $i < 9; $i++) {
            for ($j = 0; $j < 9; $j++) {
                $value = $sudokuGrid->getCell($i, $j);
                $this->puzzle[$j][$i] = [
                    'given' => $value > 0,
                    'value' => $value
                ];
            }
        }
    }
}
