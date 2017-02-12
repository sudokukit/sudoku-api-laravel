<?php

namespace App\LibrarySudoku;

/**
 * Solves sudoku using only row, column, and block checks.
 *
 * Class SimpleSolver
 */
class SimpleSolver implements SudokuSolver
{
    /**
     * Solves the grid as much as it can with simple logic.
     *
     * @param SudokuGrid $sudokuGrid The puzzle.
     *
     * @return SudokuGrid
     */
    public function solve(SudokuGrid $sudokuGrid)
    {
        for ($row = 0; $row < 9; $row++) {
            for ($column = 0; $column < 9; $column++) {
                if ($sudokuGrid->getCell($row, $column) == 0) {
                    $opportunities = $sudokuGrid->possibilitiesFor($row, $column);
                    if (count($opportunities) == 1) {
                        $sudokuGrid->setCell($row, $column, $opportunities[0]);
                        $column = 0;
                        $row = 0;
                    }
                }
            }
        }

        return $sudokuGrid;
    }
}
