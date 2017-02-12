<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LibrarySudoku\SudokuValidator;
use App\LibrarySudoku\SudokuParser;
use App\LibrarySudoku\SolutionGenerator;
use App\LibrarySudoku\PuzzleGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ApiController extends Controller
{
    /**
     * Controller method for the GET /puzzles endpoint.
     *
     * @param Request $request The request.
     *
     * @return Response
     *
     * @throws BadRequestHttpException Throws exception when difficulty parameter is not valid.
     */
    public function getPuzzle(Request $request)
    {
        $difficulty = $request->query('difficulty');
        if (! is_numeric($difficulty) || $difficulty < 1 || $difficulty > 5) {
            throw new BadRequestHttpException('Invalid parameter: `difficulty`');
        }

        $solutionGenerator = new SolutionGenerator();
        $solution = $solutionGenerator->generateSolution();

        $puzzleGenerator = new PuzzleGenerator();
        $puzzle = $puzzleGenerator->generatePuzzle($solution, $difficulty);

        return response()->json([
            'puzzle' => $puzzle->getPuzzle(),
            'difficulty' => $difficulty
        ]);
    }

    /**
     * Controller method for the GET /solutions endpoint.
     * Checks if the solution is valid.
     *
     * TODO : move most of the logic to a new manager
     * TODO : move messages to front-end
     *
     * @param Request $request The request.
     *
     * @return Response
     */
    public function checkSolution(Request $request)
    {
        $solution = $request->query('solution');
        if (strlen($solution) != 81 || ! is_numeric($solution)) {
            throw new BadRequestHttpException('Invalid parameter `solution`.');
        }
        $sudokuParser = new SudokuParser();
        $sudokuGrid = $sudokuParser->parse($solution);

        $validator = new SudokuValidator();
        if ($validator->validate($sudokuGrid)) {
            $numberOfEmptyFields = $validator->numberOfEmptyFields($sudokuGrid);
            if ($numberOfEmptyFields > 0) {
                $message = "Going great! You still have ".$numberOfEmptyFields." cells to fill.";
            } else {
                $message = "Perfect! How about a new game?";
            }
        } else {
            $message = "Oops! Looks like you made a mistake. Think you can find it without using reset?";
        }
        return response()->json([
            'result' => $message
        ]);
    }
}
