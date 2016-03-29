<?php

namespace App\LibrarySudoku;

// only does row, column and block checks
// TODO needs to be tested
class SimpleSolver implements SudokuSolver{
	private $sudokuGrid;
	private $edited;

	public function solve(SudokuGrid $sudokuGrid){
		$this->sudokuGrid = $sudokuGrid;
		$finished = false;
		while(!$finished){
			$this->edited=false;
			for($i=0;$i<9;$i++){
				for($j=0;$j<9;$j++){
					if($this->sudokuGrid->getCell($j,$i) == 0){
						$this->checkForCell($j,$i);
					}
				}
			}
			$validator = new SudokuValidator;
			if($validator->countZeros($this->sudokuGrid) == 0){
				$finished = true;
			} else if (!$this->edited){
				return false;
			}
		}
		return $this->sudokuGrid;
	}

	public function checkForCell($x,$y){
		$stack = [1,2,3,4,5,6,7,8,9];
		$row = $this->sudokuGrid->getRow($y);
		$stack = array_diff($stack,$row);
		if(count($stack) > 1){
			$column = $this->sudokuGrid->getColumn($x);
			$stack = array_diff($stack,$column);
		}
		if(count($stack) > 1){
			$block = $this->sudokuGrid->getBlock($x,$y);	
		}
		if(count($stack) == 1){
			$this->sudokuGrid->setCell($x,$y);	
			$this->edited=true;
		}
	}
}