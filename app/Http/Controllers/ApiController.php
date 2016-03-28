<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\LibrarySudoku\SudokuValidator;
use App\LibrarySudoku\SudokuGrid;

class ApiController extends Controller
{
	public function getPuzzle(Request $request, $id = null){
		for($i = 0 ;$i < 9; $i++){
			for($j = 0; $j<9;$j++){
				$puzzle[$i][$j] = array('given' => true, 'value' => $j+1);
			}
		}
		$puzzle[0][0] = array('given' => false, 'value' => 23);
		return response()->json(array('puzzle' => $puzzle, 'id' => 1, 'difficulty'=>5));
	}

	public function checkSolution(Request $request, $id = null,$solution = null){

		// todo check input
		// todo parse solution into SudokuGrid
		$sudokuGrid= new SudokuGrid;

		$validator = new SudokuValidator;
		if($validator->validate($sudokuGrid)){
			$numberOfZeros = $validator->countZeros($sudokuGrid);
				if($numberOfZeros > 0){
					$message = "Going great! You still have ".$numberOfZeros." cells to fill.";
				} else {
					$message = "Perfect! How about a new game?";
				}
		} else {
			$message = "Oops! Looks like you made a mistake. Think you can find it without using reset?";
		}
		return response()->json(array('result' => $message));
	}
}
