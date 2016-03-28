<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\LibrarySudoku\SudokuValidator;
use App\LibrarySudoku\SudokuGrid;
use App\LibrarySudoku\SudokuParser;
use App\LibrarySudoku\SudokuPuzzle;

class ApiController extends Controller
{
	public function getPuzzle(Request $request, $id = null){
		$puzzleAsString = "004060007010970040006050030045300021009102700620005490050010900090024060200030100";
		$sudokuParser = new SudokuParser;
		$sudokuGrid= $sudokuParser->parse($puzzleAsString);
		
		$sudokuPuzzle = new SudokuPuzzle;
		$sudokuPuzzle->setDifficulty(3);
		$sudokuPuzzle->setId('uuid123');
		$sudokuPuzzle->setSolutionId('uuid123');
		$sudokuPuzzle->setPuzzle($sudokuGrid);

		return response()->json(array(
			'puzzle' => $sudokuPuzzle->getPuzzle(), 
			'id' => $sudokuPuzzle->getId(), 
			'difficulty'=>$sudokuPuzzle->getDifficulty()
			));
	}

	public function checkSolution(Request $request, $id = null){
		// todo check input
		$solution = $request->query('solution');
		// todo check solution length and exotic characters
		$sudokuParser = new SudokuParser;
		$sudokuGrid= $sudokuParser->parse($solution);

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
