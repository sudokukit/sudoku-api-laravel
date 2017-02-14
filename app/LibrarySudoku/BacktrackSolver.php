<?php

namespace App\LibrarySudoku;

/**
 * BackTrackSolver - Informed depth first search.
 *
 * The solver will traverse the grid ltr-ttb.
 * Ignores any 'given' cells.
 * For each empty cell it encounters:
 * 1. Gets the possibilities.
 * 2. Randomly fills one of those in.
 * 3. Continues until it reaches the end (solved) or
 *    encounters a cell that has no possibilities
 * 4. Go back to the previous cell with multiple possibilities,
 *    and choose another one from the random stack of options
 * Class BacktrackSolver
 */
class BacktrackSolver implements SudokuSolver
{
    const DIRECTION_FORWARD = true;
    const DIRECTION_BACKWARDS = false;

    /**
     * A list of the original given cells of the sudoku puzzle.
     *
     * @var array
     */
    private $givenCells;

    /**
     * A matrix with for each cell a list of possibilities or 'false' if none.
     *
     * @var array
     */
    private $possibilities;

    /**
     * The sudoku grid.
     *
     * @var SudokuGrid
     */
    private $sudokuGrid;

    /**
     * Direction of the solver.
     *
     * @var boolean
     */
    private $direction;

    /**
     * The current row.
     *
     * @var integer
     */
    private $row;

    /**
     * The current column.
     *
     * @var integer
     */
    private $column;

    /**
     * BacktrackSolver constructor.
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Solves the given grid.
     *
     * @param SudokuGrid $sudokuGrid The grid to solve.
     *
     * @return SudokuGrid
     */
    public function solve(SudokuGrid $sudokuGrid)
    {
        $this->initializeSolveGrid($sudokuGrid);
        while ($this->locationIsValid()) {
            if (! $this->cellIsGiven()) {
                if ($this->goingBackwards()) {
                    if ($this->hasPossibilities()) {
                        $this->fillCell();
                    } else {
                        $this->emptyCell();
                    }
                } else {
                    $this->initializePossibilities();
                    if ($this->hasPossibilities()) {
                        $this->fillCell();
                    } else {
                        $this->emptyCell();
                        $this->direction = self::DIRECTION_BACKWARDS;
                    }
                }
            }
            $this->nextCell();
        }

        return $this->success() ? $sudokuGrid : false;
    }

    /**
     * Empties the current cell.
     *
     * @return void
     */
    private function emptyCell()
    {
        $this->sudokuGrid->emptyCell($this->row, $this->column);
    }

    /**
     * Checks whether the solver was successful in solving the given sudoku.
     *
     * @return boolean
     */
    private function success()
    {
        if ($this->row == 9 && $this->column == 0) {
            $response = true;
        } else {
            $response = false;
        }

        return $response;
    }

    /**
     * Resets the class variables.
     *
     * @return void
     */
    private function reset()
    {
        $this->possibilities = [];
        $this->givenCells = [];
        $this->direction = self::DIRECTION_FORWARD;
        $this->column = 0;
        $this->row = 0;
    }

    /**
     * Checks whether the current cell has any possibilities.
     *
     * @return boolean
     */
    private function hasPossibilities()
    {
        return ! empty($this->possibilities[$this->row][$this->column]);
    }

    /**
     * Gets all possible fields from the grid for the current cell.
     *
     * @return void
     */
    private function initializePossibilities()
    {
        $possibilities = $this->sudokuGrid->possibilitiesFor($this->row, $this->column);
        $this->possibilities[$this->row][$this->column] = $possibilities;
    }

    /**
     * Checks if we are going backwards.
     *
     * @return boolean
     */
    private function goingBackwards()
    {
        return $this->direction == self::DIRECTION_BACKWARDS;
    }

    /**
     * Checks whether our current location ($row, $column) is still a valid position.
     *
     * @return boolean
     */
    private function locationIsValid()
    {
        return $this->column >= 0 && $this->column < 9 && $this->row >= 0 && $this->row < 9;
    }

    /**
     * Moves the row and column pointer 1 forward or backwards based on the current direction.
     */
    private function nextCell()
    {
        if ($this->direction == self::DIRECTION_FORWARD) {
            $this->row = $this->column == 8 ? $this->row + 1 : $this->row;
            $this->column = $this->column == 8 ? 0 : $this->column + 1;
        } else {
            $this->row = $this->column == 0 ? $this->row - 1 : $this->row;
            $this->column = $this->column == 0 ? 8 : $this->column - 1;
        }
    }

    /**
     * Fills a cell with a random choice of one of its possibilities.
     * Then sets direction to forward.
     *
     * @return void
     */
    private function fillCell()
    {
        $possibilities = $this->possibilities[$this->row][$this->column];
        $value = $this->getRandomValue($possibilities);
        $this->sudokuGrid->setCell($this->row, $this->column, $value);
        $this->possibilities[$this->row][$this->column] = array_values(array_diff($possibilities, [$value]));
        $this->direction = self::DIRECTION_FORWARD;
    }

    /**
     * Saves all the given cells into the internal array.
     *
     * @param SudokuGrid $sudokuGrid The given sudoku puzzle.
     *
     * @return void
     */
    private function initializeSolveGrid(SudokuGrid $sudokuGrid)
    {
        $this->reset();
        $this->sudokuGrid = $sudokuGrid;
        for ($row = 0; $row < 9; $row++) {
            for ($column = 0; $column < 9; $column++) {
                if ($this->sudokuGrid->getCell($row, $column) > 0) {
                    $this->givenCells[$row][$column] = true;
                }
            }
        }
    }

    /**
     * Selects a random value of an array of values.
     *
     * @param array $values The values.
     *
     * @return mixed
     */
    private function getRandomValue(array $values)
    {
        $random = rand(1, count($values));
        return $values[($random - 1)];
    }

    /**
     * Checks if cell was given in original puzzle.
     *
     * @return boolean
     */
    private function cellIsGiven()
    {
        return ! empty($this->givenCells[$this->row][$this->column]);
    }
}
