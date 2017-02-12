<?php

namespace App\LibrarySudoku;

/**
 * Class DigConsultant
 */
class DigConsultant
{
    /**
     * The solver.
     *
     * @var SudokuSolver
     */
    private $solver;

    /**
     * DigConsultant constructor.
     */
    public function __construct()
    {
        $this->solver = new BacktrackSolver();
    }

    /**
     * Checks whether the grid is still uniquely solvable after digging out the given cell.
     *
     * @param SudokuGrid $sudokuGrid The grid.
     * @param array      $location   The location of the cell.
     * @param integer    $bound      The minimum allowed bound.
     *
     * @return boolean
     */
    public function isSolvableAfterDigging(SudokuGrid $sudokuGrid, array $location, int $bound)
    {
        if (! $this->checkAllBounds($bound, $sudokuGrid, $location)) {
            return false;
        }
        $originalValue = $sudokuGrid->getCell($location['y'], $location['x']);
        $testGrid = clone $sudokuGrid;
        $testGrid->emptyCell($location['y'], $location['x']);
        $possibilities = $testGrid->possibilitiesFor($location['y'], $location['x']);
        if (count($possibilities) > 1) {
            $possibilities = array_diff($possibilities, [$originalValue]);
            foreach ($possibilities as $possibility) {
                $testGrid->setCell($location['y'], $location['x'], $possibility);
                if ($this->solver->solve($testGrid)) {
                    return false; // Digging action results in multi solvable solution
                }
            }
        }
        return true;
    }

    /**
     * Checks all bounds for rows, columns & blocks. Makes sure there is at least $bound amount
     * of filled in values present in said row, column or block.
     *
     * @param integer    $bound    The bound.
     * @param SudokuGrid $grid     The grid.
     * @param array      $location The location of the cell.
     *
     * @return boolean
     */
    private function checkAllBounds(int $bound, SudokuGrid $grid, array $location)
    {
        $response = true;
        if ($bound > 0) { // performance
            if (! $this->checkHorizontalBounds($bound, $grid, $location)
                || ! $this->checkVerticalBounds($bound, $grid, $location)
                || ! $this->checkBlockBounds($bound, $grid, $location)
            ) {
                $response = false;
            }
        }

        return $response;
    }

    /**
     * Checks the row if bound constraint is still met.
     *
     * @param integer    $bound    The bound.
     * @param SudokuGrid $grid     The grid.
     * @param array      $location The location of the cell.
     *
     * @return boolean
     */
    private function checkHorizontalBounds(int $bound, SudokuGrid $grid, array $location)
    {
        $row = $grid->getRow($location['y']);
        return $this->checkBound($bound, $row);
    }

    /**
     * Checks the column if bound constraint is still met.
     *
     * @param integer    $bound    The bound.
     * @param SudokuGrid $grid     The grid.
     * @param array      $location The location of the cell.
     *
     * @return boolean
     */
    private function checkVerticalBounds(int $bound, SudokuGrid $grid, array $location)
    {
        $column = $grid->getColumn($location['x']);
        return $this->checkBound($bound, $column);
    }

    /**
     * Checks the 3x3 block if bound constraint is still met.
     *
     * @param integer    $bound    The bound.
     * @param SudokuGrid $grid     The grid.
     * @param array      $location The location of the cell.
     *
     * @return boolean
     */
    private function checkBlockBounds(int $bound, SudokuGrid $grid, array $location)
    {
        $block = $grid->getBlock($location['y'], $location['x']);
        return $this->checkBound($bound, $block);
    }


    /**
     * Checks if the list of values has at least $bound - 1 values > 0
     *
     * @param integer $bound  The bound.
     * @param array   $values The values.
     *
     * @return boolean
     */
    private function checkBound(int $bound, array $values)
    {
        $values = array_unique(array_diff($values, [0]));
        $remainingValues = count($values) - 1; // -1 is to check without the currently filled in cell.
        if ($remainingValues < $bound) {
            $response = false;
        } else {
            $response = true;
        }

        return $response;
    }
}
