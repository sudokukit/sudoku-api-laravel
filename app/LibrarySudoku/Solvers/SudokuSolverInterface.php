<?php

namespace App\LibrarySudoku;

/**
 * Interface SudokuSolver
 */
interface SudokuSolverInterface
{
    public function solve(SudokuGrid $sudokuGrid);
}
