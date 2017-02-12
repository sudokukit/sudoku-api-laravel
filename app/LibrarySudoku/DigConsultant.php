<?php

namespace App\LibrarySudoku;

/**
 * Class DigConsultant
 */
class DigConsultant
{
    /**
     * Checks whether the grid is still uniquely solvable after digging out the given cell.
     *
     * @param SudokuGrid $grid     The grid.
     * @param array      $location The location of the cell.
     * @param integer    $bound    The minimum allowed bound.
     *
     * @return boolean
     */
    public function isSolvableAfterDigging(SudokuGrid $grid, array $location, int $bound)
    {
        $this->checkAllBounds($bound, $grid, $location);

        $solver = new BacktrackSolver();
        $testGrid = clone $grid;
        $testGrid->setCell($location['x'], $location['y'], 0);
        $possibilities = $testGrid->possibilitiesFor($location['x'], $location['y']);
        $count = count($possibilities);
        if ($count > 1) {
            $original = $grid->getCell($location['x'], $location['y']);
            $possibilities = array_values(array_diff($possibilities, [$original]));
            $count--;
            for ($i = 0; $i < $count; $i++) {
                $testGrid->setCell($location['x'], $location['y'], $possibilities[$i]);
                if ($solver->solve($testGrid)) {
                    return false; // cell can't be dug out
                }
            }
        }
        return true;
    }

    private function checkAllBounds(int $bound, SudokuGrid $grid, array $location)
    {
        if ($bound > 0) {
            if (! $this->checkHorizontalBounds($bound, $grid, $location)
                || ! $this->checkVerticalBounds($bound, $grid, $location)
                || ! $this->checkBlockBounds($bound, $grid, $location)
            ) {
                return false;
            }
        }
    }

    private function checkHorizontalBounds($bound, $grid, array $location)
    {
        $row = $grid->getRow($location['y']);
        return $this->checkBounds($bound, $row);
    }

    private function checkVerticalBounds($bound, $grid, array $location)
    {
        $column = $grid->getColumn($location['x']);
        return $this->checkBounds($bound, $column);
    }

    private function checkBlockBounds($bound, $grid, array $location)
    {
        $block = $grid->getBlock($location['x'], $location['y']);
        return $this->checkBounds($bound, $block);
    }

    private function checkBounds($bound, $values)
    {
        $values = array_unique(array_diff($values, [0]));
        $remainingValues = count($values) - 1;
        if ($remainingValues < $bound) {
            return false;
        }
        return true;
    }
}
