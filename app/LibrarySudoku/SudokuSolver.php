<?php

namespace App\LibrarySudoku;

interface SudokuSolver {
	public function solve(SudokuGrid $sudokuGrid);		
}