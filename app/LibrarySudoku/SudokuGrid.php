<?php

namespace App\LibrarySudoku;

class SudokuGrid {
	private $grid;

	public function __construct(){
		for($i=0;$i<9;$i++){
			for($j=0;$j<9;$j++){
				$grid[$i][$j] = 0;
			}
		}
		$this->grid = $grid;
	}

	public function setCell($x, $y, $value){
		if($value >= 0 && $value <= 9){
			$this->grid[$y][$x] = $value;
		}
	}

	public function getCell($x, $y){
		return $this->grid[$y][$x];
	}

	public function setGrid($grid){
		$this->grid = $grid;
	}

	public function getGrid(){
		return $this->grid;
	}

	public function getRow($y){
		return $this->grid[$y];
	}

	public function getColumn($x){
		$column = [];
		for($i = 0;$i<9;$i++){
			$column[$i] = $this->getCell($x,$i);
		}
		return $column;
	}

	public function getBlockByNumber($b){
		$mod3 = $b % 3;
		$x_start = $mod3 * 3;
		$y_start = $b - $mod3;
		return $this->getBlock($x_start,$y_start);
	}

	public function getBlock($x, $y){
		$block = [];
		$mod_x = $x % 3;
		$mod_y = $y % 3;
		$x_start = $x-$mod_x;
		$y_start = $y-$mod_y;

		for($i=0;$i<3;$i++){
			for($j=0;$j<3;$j++){
				$number = $i * 3;
				$block[$number+$j] = $this->getCell($j+$x_start,$i+$y_start);
			}
		}
		return $block;
	}

	public function possibilitiesFor($x, $y){
		if($this->getCell($x,$y) > 0){
			return null;
		}
		$invalid_numbers = array_unique(array_merge(
				$this->getRow($y),
				$this->getColumn($x),
				$this->getBlock($x,$y)
			));
		$array = [1,2,3,4,5,6,7,8,9];
		return array_filter(array_values(array_diff($array,$invalid_numbers)));
	}
}