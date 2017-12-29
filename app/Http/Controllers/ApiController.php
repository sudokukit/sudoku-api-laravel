<?php

namespace App\Http\Controllers;

use CoenMooij\Sudoku\Generator\HintGenerator;
use CoenMooij\Sudoku\Serializer\GridSerializer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ApiController
 */
class ApiController extends Controller
{

    /**
     * @var HintGenerator
     */
    private $hintGenerator;

    public function __construct(HintGenerator $hintGenerator)
    {
        $this->hintGenerator = $hintGenerator;
    }

    public function getHint(Request $request): JsonResponse
    {
        $grid = GridSerializer::deserialize($request->get('grid'));
        $location = $this->hintGenerator->generateOne($grid);

        $data = ['row' => $location->getRow(), 'column' => $location->getColumn()];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    public function improveSolution(Request $request): JsonResponse
    {
        $solution = $request->get('solution');
        if (!is_numeric($solution)) {
            throw new BadRequestHttpException();
        }
        try {
            GridSerializer::deserialize($request->get('solution'));
        } catch (\LengthException $exception) {
            throw new BadRequestHttpException();
        }
        $difficulty = $request->query('difficulty');
        if (!is_numeric($difficulty) || $difficulty < 1 || $difficulty > 5) {
            throw new BadRequestHttpException();
        }

        $simpleSolver = new SimpleSolver();
        $sudokuGrid = $simpleSolver->solve($sudokuGrid);

        $improvedPuzzle = new SudokuPuzzle($sudokuGrid);

        return response()->json(
            [
                'puzzle' => $improvedPuzzle->getPuzzle(),
                'difficulty' => $difficulty
            ]
        );
    }

    /**
     * Controller method for the GET /puzzles endpoint.
     *
     * @param Request $request The request.
     *
     * @return Response
     * @throws BadRequestHttpException Throws exception when difficulty parameter is not valid.
     */
    public function getPuzzle(
        Request $request
    ) {
        $difficulty = $request->query('difficulty');
        if (!is_numeric($difficulty) || $difficulty < 1 || $difficulty > 5) {
            throw new BadRequestHttpException('Invalid parameter: `difficulty`');
        }

        $solutionGenerator = new SolutionGenerator();
        $solution = $solutionGenerator->generateSolution();

        $puzzleGenerator = new PuzzleGenerator();
        $puzzle = $puzzleGenerator->generatePuzzle($solution, $difficulty);

        return response()->json(
            [
                'puzzle' => $puzzle->getPuzzle(),
                'difficulty' => $difficulty
            ]
        );
    }

    /**
     * Controller method for the GET /solutions endpoint.
     * Checks if the solution is valid.
     *
     * @param Request $request The request.
     *
     * @return Response
     */
    public function checkSolution(
        Request $request
    ) {
        $solution = $request->query('solution');
        if (strlen($solution) != 81 || !is_numeric($solution)) {
            throw new BadRequestHttpException('Invalid parameter `solution`.');
        }
        $sudokuParser = new SudokuParser();
        $sudokuGrid = $sudokuParser->parse($solution);

        $validator = new SudokuValidator();
        if ($validator->validate($sudokuGrid)) {
            $numberOfEmptyFields = $validator->numberOfEmptyFields($sudokuGrid);
            if ($numberOfEmptyFields > 0) {
                $message = "Going great! You still have " . $numberOfEmptyFields . " cells to fill.";
            } else {
                $message = "Perfect! How about a new game?";
            }
        } else {
            $message = "Oops! Looks like you made a mistake. Think you can find it without using reset?";
        }

        return response()->json(
            [
                'result' => $message
            ]
        );
    }
}
