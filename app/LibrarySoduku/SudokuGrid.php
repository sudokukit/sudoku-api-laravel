<?php

namespace App

public class SudokuGrid {
	private $grid;

	public function __construct{
		for($i=0;$i<9;$i++){
			for($j=0;$j<9;$j++){
				$grid[$i][$j] = 0;
			}
		}
		$this->grid = $grid;
	}

	public function setCell(int $x, int $y, int $value){
		if($value >= 0 && $value =< 9){
			$this->grid[$y][$x] = $value;
		}
	}

	public function getCell(int $x, int $y){
		return $this->grid[$y][$x];
	}
}