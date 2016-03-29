<?php

namespace App\LibrarySudoku;

class SolutionGenerator {

	private $sudokuGrid;

	public function generateSolution(){
		$this->sudokuGrid = new SudokuGrid;
		$this->placeRandomStarters();
		$this->solveSudoku();
		return $this->sudokuGrid;
	}

	private function placeRandomStarters(){
		for($i=0;$i<11;$i++){
			$location = $this->getRandomEmptyCell();
			do{
				$value = rand(1,9);
				$this->sudokuGrid->setCell($location[0],$location[1],$value);
			}
			while(!$this->isValid());
		}
	}

	private function isValid(){
		$validator = new SudokuValidator;
		return $validator->validate($this->sudokuGrid);
	}

	private function getRandomEmptyCell(){
		$x=0;
		$y=0;
		do{
			$x = rand(0,8);
			$y = rand(0,8);
		} while($this->sudokuGrid->getCell($x,$y) != 0);
		return [$x,$y];
	}

	private function solveSudoku(){
		$solver = new BacktrackSolver;
		if($solver->solve($this->sudokuGrid)){
			return true;
		} else {
			return false;
		}
	}
}