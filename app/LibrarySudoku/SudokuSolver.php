<?php

namespace App\LibrarySudoku;

/**
 * Interface SudokuSolver
 */
interface SudokuSolver
{
    public function solve(SudokuGrid $sudokuGrid);
}
