<?php

namespace App\LibrarySudoku

class SolutionGenerator {

	private $sudokuGrid;

	public function generateSolution(){
		do {
			$sudokuGrid = new SudokuGrid;
			$this->placeRandomStarters();	
		} while(!$this->solveSudoku());
		return $this->sudokuGrid;
	}

	private function placeRandomStarters(){
		for($i=0;$i<11;$i++){
			$location = $this->getRandomEmptyCell();
			do{
				$value = rand(1,9);
				$this->sudokuGrid->setCell($location['x'],$location['y'],$value);
			}
			while($this->isValid());
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
			$x = rand(1,9);
			$y = rand(1,9);
		} while($this->sudokuGrid->getCell($x,$y) != 0);
		return array('x'=>$x,'y'=>$y);
	}

	private function solveSudoku(){
		$solver = new BruteForceSolver;
		if($solver->solve($this->sudokuGrid)){
			return true;
		} else {
			return false;
		}
	}
}