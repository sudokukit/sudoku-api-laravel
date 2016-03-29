<?php

namespace App\LibrarySudoku;

class BacktrackSolver implements SudokuSolver{
	private $given;
	
	// this beast of a method is basically 'smart' depth first search
	//
	// Algorithm:
	// traverse the grid ltr ttb, ignoring the 'given' cells
	// choose random number from legal options and remove from stack
	// go to next cell until cell has no options
	// backtrack if we run out of possibilities, choose next value from stack at previous node

	public function solve(SudokuGrid $sudokuGrid){
		$possibilities;
		for($i=0;$i<9;$i++){
			for($j=0;$j<9;$j++){
				$possibilities[$i][$j] = false;
				$value = $sudokuGrid->getCell($j,$i);
				if($value > 0){
					$this->given[] = array('x' => $j, 'y' => $i);
				}
			}
		}
		$backtrack = false;
		for($y=0;$y<9;$y++){
			for($x=0;$x<9;$x++){
				if($backtrack){
					if($possibilities[$y][$x] == false){ // make sure there is a list of possible numbers
						$possibilities[$y][$x] = $sudokuGrid->possibilitiesFor($x,$y);
					}
					if($this->isGiven($x,$y) == true){
						if(!$this->goBack($y,$x)){
							return false;
						}
					}else if(count($possibilities[$y][$x]) == 0){
						$possibilities[$y][$x] = false;
						$sudokuGrid->setCell($x,$y,0);
						if(!$this->goBack($y, $x)){
							return false;
						}	
					}else{
						$backtrack = false;
						$value = $this->getRandomValue($possibilities[$y][$x]);
						$sudokuGrid->setCell($x,$y,$value);
						if(count($possibilities[$y][$x] == 1)){
							$possibilities[$y][$x] = false;
						} else {
							$possibilities[$y][$x] = array_filter(array_values(array_diff($possibilities[$y][$x],[$value])));
						} 
					}
				}else{ // if we are not backtracking
					if($possibilities[$y][$x] == false){
						$possibilities[$y][$x] = $sudokuGrid->possibilitiesFor($x,$y);
					}
					if(!$this->isGiven($x,$y) == true){
						if(count($possibilities[$y][$x]) == 0){
							$backtrack = true;
							if(!$this->goBack($y, $x)){
								return false;
							}
						}else{ 
							$value = $this->getRandomValue($possibilities[$y][$x]);
							$sudokuGrid->setCell($x,$y,$value);
							if(count($possibilities[$y][$x]) == 1){
								$possibilities[$y][$x] =false;
							}else{
								$possibilities[$y][$x] = array_filter(array_values(array_diff($possibilities[$y][$x],[$value])));
							}
						}
					}
				}
			}
		}
		return $sudokuGrid;
	}

	private function getRandomValue($values){
		$count = count($values);
		$random = rand(1,$count);
		return $values[$random-1];
	}

	private function isGiven(int $x, int $y){
		for($i=0;$i<count($this->given);$i++){
			if($this->given[$i]['x'] == $x && $this->given[$i]['y'] == $y){
			return true;
			}	
		}
		return false;
	}

	private function goBack(int &$y, int &$x){
		if($x > 0){
			$x -= 2;
		}else{
			$x = 7;
			if($y>0){
				$y--;
			}else{
				return false;
			}
		}
		return true;
	}
}