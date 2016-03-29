<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\LibrarySudoku\SudokuValidator;
use App\LibrarySudoku\SudokuGrid;
use App\LibrarySudoku\SudokuParser;
use App\LibrarySudoku\SudokuPuzzle;
use App\LibrarySudoku\SolutionGenerator;
use App\LibrarySudoku\PuzzleGenerator;

class ApiController extends Controller
{
	public function getPuzzle(Request $request, $id = null){
		
		$solutionGenerator = new SolutionGenerator;
		$solution = $solutionGenerator->generateSolution();

		$puzzleGenerator = new PuzzleGenerator;
		$puzzle = $puzzleGenerator->generatePuzzle($solution,3);

		return response()->json(array(
			'puzzle' => $puzzle->getPuzzle(), 
			'id' => $puzzle->getId(), 
			'difficulty'=>$puzzle->getDifficulty()
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
