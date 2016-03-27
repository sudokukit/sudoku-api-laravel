<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;

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
		return response()->json(array('result' => 'Perfect! How about a new game?'));
	}
}
