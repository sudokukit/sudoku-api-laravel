<?php

namespace App\LibrarySudoku;

class SudokuParser {
	public function parse($string){
		$grid=[];
		for($i = 0;$i<9;$i++){
			$grid[$i] = $this->parseRow(substr($string,$i*9,9));
		}
		$sudokuGrid = new SudokuGrid;
		$sudokuGrid->setGrid($grid);
		return $sudokuGrid;
	}

	private function parseRow($string){
		$row = [];
		for($i=0;$i<9;$i++){
			$char = $string{$i};
			$int = (int)$char;
			$row[$i] = $int;
		}
		return $row;
	}
}