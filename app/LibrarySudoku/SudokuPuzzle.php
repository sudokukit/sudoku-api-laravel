<?php

namespace App\LibrarySudoku;

class SudokuPuzzle{
	private $difficulty;
	private $id;
	private $solution_id;
	private $puzzle;

	public function getDifficulty(){return $this->difficulty;}
	public function setDifficulty($difficulty){$this->difficulty = $difficulty;}

	public function getId(){return $this->id;}
	public function setId($id){$this->id = $id;}

	public function getSolutionId(){return $this->solution_id;}
	public function setSolutionId($solution_id){$this->solution_id = $solution_id;}

	public function getPuzzle(){return $this->puzzle;}
	
	public function setPuzzle(SudokuGrid $sudokuGrid){
		for($i=0;$i<9;$i++){
			for($j=0;$j<9;$j++){
				$value = $sudokuGrid->getCell($i,$j);
				if($value == 0){
					$this->puzzle[$j][$i] = array(
							'given' => false,
							'value' => $value
						);
				}else{
					$this->puzzle[$j][$i] = array(
							'given' => true,
							'value' => $value
						);
				}
				
			}
		}	
	}
}