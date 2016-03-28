<?php

namespace App\LibrarySudoku

public interface SudokuSolver {
	public function solve(SudokuGrid $sudokuGrid);		
}