<?php

namespace App\LibrarySudoku;

class SudokuValidator {
	
	private $sudokuGrid;
	
	public function validate(SudokuGrid $sudokuGrid){
		$this->sudokuGrid = $sudokuGrid;
		if ($this->validateRows() && $this->validateColumns() && $this->validateBlocks()){
			return true;
		}else{
			return false;
		}
	}

	public function countZeros(){
		$count = 0;
		for($i=0;$i<9;$i++){
			$counted_values = array_count_values($this->sudokuGrid->getRow($i));
			$count += $counted_values['0'];
		}
		return $count;
	}

	private function validateRows(){
		for($i = 0;$i < 9;$i++){
			if(!$this->validateRow($this->sudokuGrid->getRow($i))){return false;}
		}
		return true;
	}
	
	private function validateColumns(){
		for($i = 0;$i < 9;$i++){
			$column=$this->sudokuGrid->getColumn($i);
			if(!$this->validateRow($column)){return false;}
		}
		return true;
	}
	private function validateBlocks(){
		for($i = 0;$i < 3;$i++){
			for($j=0;$j<3;$j++){
				$block = [];
				$x_start = $j * 3;
				$y_start = $i * 3;
				for($y=$y_start;$y < $y_start+3;$y++){
					for($x=$x_start;$x < $x_start+3;$x++){
						$block[] = $this->sudokuGrid->getCell($y,$x);
					}
				}
			if (!$this->validateRow($block)){return false;}
			}
		}
		return true;
	}

	private function validateRow($row){
		$numbers = array_diff($row, [0]);
		if(count(array_unique($numbers)) < count($numbers)){
			return false;
		}
		return true;
	}

}