<?php

namespace App\LibrarySudoku;

/**
 * Class DigConsultant
 */
class DigConsultant
{
    private $grid;
    private $location;
    private $bound;

    public function consultOnDigging(SudokuGrid $grid, $location, $bound)
    {
        $this->grid = $grid;
        $this->location = $location;
        $this->bound = $bound;

        if ($bound > 0) {
            if ($this->checkHorizontalBounds()
                && $this->checkVerticalBounds()
                && $this->checkBlockBounds()
            ) {
                // everything OK
            } else {
                return false;
            }
        }
        $solver = new BacktrackSolver;

        $testGrid = clone $this->grid;
        $testGrid->setCell($this->location['x'], $this->location['y'], 0);
        $possibilities = $testGrid->possibilitiesFor($this->location['x'], $this->location['y']);
        $count = count($possibilities);
        if ($count > 1) {
            $original = $this->grid->getCell($this->location['x'], $this->location['y']);
            $possibilities = array_values(array_diff($possibilities, [$original]));
            $count--;
            for ($i = 0; $i < $count; $i++) {
                $testGrid->setCell($this->location['x'], $this->location['y'], $possibilities[$i]);
                if ($solver->solve($testGrid)) {
                    return false; // cell can't be dug out
                }
            }
        }
        return true;
    }

    private function checkHorizontalBounds()
    {
        $row = $this->grid->getRow($this->location['y']);
        return $this->checkBounds($row);
    }

    private function checkVerticalBounds()
    {
        $column = $this->grid->getColumn($this->location['x']);
        return $this->checkBounds($column);
    }

    private function checkBlockBounds()
    {
        $block = $this->grid->getBlock($this->location['x'], $this->location['y']);
        return $this->checkBounds($block);
    }

    private function checkBounds($values)
    {
        $values = array_unique(array_diff($values, [0]));
        $remainingValues = count($values) - 1;
        if ($remainingValues < $this->bound) {
            return false;
        }
        return true;
    }
}
