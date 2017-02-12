<?php

namespace App\LibrarySudoku;

/**
 * Class BacktrackSolver
 */
class BacktrackSolver implements SudokuSolver
{
    private $given;

    // this beast of a method is basically 'informed' depth first search
    //
    // Algorithm:
    // traverse the grid ltr ttb, ignoring the 'given' cells
    // choose random number from legal options and remove from stack
    // go to next cell until cell has no options
    // backtrack if we run out of possibilities, choose next value from stack at previous node

    /**
     * Solves the given grid.
     *
     * @param SudokuGrid $sudokuGrid The grid to solve.
     *
     * @return SudokuGrid
     */
    public function solve(SudokuGrid $sudokuGrid)
    {
        $possibilities = [];
        for ($i = 0; $i < 9; $i++) {
            for ($j = 0; $j < 9; $j++) {
                $possibilities[$i][$j] = false;
                $value = $sudokuGrid->getCell($j, $i);
                if ($value > 0) {
                    $this->given[] = ['x' => $j, 'y' => $i];
                }
            }
        }

        $backtrack = false;
        for ($y = 0; $y < 9; $y++) {
            for ($x = 0; $x < 9; $x++) {
                if ($backtrack) {
                    if ($possibilities[$y][$x] == false) { // make sure there is a list of possible numbers
                        $possibilities[$y][$x] = $sudokuGrid->possibilitiesFor($x, $y);
                    }
                    if ($this->isGiven($x, $y) == true) {
                        if (! $this->goBack($y, $x)) {
                            return false;
                        }
                    } else {
                        if (count($possibilities[$y][$x]) == 0) {
                            $possibilities[$y][$x] = false;
                            $sudokuGrid->setCell($x, $y, 0);
                            if (! $this->goBack($y, $x)) {
                                return false;
                            }
                        } else {
                            $backtrack = false;
                            $value = $this->getRandomValue($possibilities[$y][$x]);
                            $sudokuGrid->setCell($x, $y, $value);
                            if (count($possibilities[$y][$x] == 1)) {
                                $possibilities[$y][$x] = false;
                            } else {
                                $possibilities[$y][$x] = array_filter(array_values(array_diff($possibilities[$y][$x],
                                    [$value])));
                            }
                        }
                    }
                } else { // if we are not backtracking
                    if ($possibilities[$y][$x] == false) {
                        $possibilities[$y][$x] = $sudokuGrid->possibilitiesFor($x, $y);
                    }
                    if (! $this->isGiven($x, $y) == true) {
                        if (count($possibilities[$y][$x]) == 0) {
                            $backtrack = true;
                            if (! $this->goBack($y, $x)) {
                                return false;
                            }
                        } else {
                            $value = $this->getRandomValue($possibilities[$y][$x]);
                            $sudokuGrid->setCell($x, $y, $value);
                            if (count($possibilities[$y][$x]) == 1) {
                                $possibilities[$y][$x] = false;
                            } else {
                                $possibilities[$y][$x] = array_filter(array_values(array_diff($possibilities[$y][$x],
                                    [$value])));
                            }
                        }
                    }
                }
            }
        }
        return $sudokuGrid;
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
        $numberOfValues = count($values);
        $random = rand(1, $numberOfValues);
        return $values[$random - 1];
    }

    /**
     * @param $x
     * @param $y
     *
     * @return boolean
     */
    private function isGiven($x, $y)
    {
        for ($i = 0; $i < count($this->given); $i++) {
            if ($this->given[$i]['x'] == $x && $this->given[$i]['y'] == $y) {
                return true;
            }
        }
        return false;
    }

    /**
     * Traverse back on the grid.
     *
     * @param $y
     * @param $x
     *
     * @return bool
     */
    private function goBack(&$y, &$x)
    {
        if ($x > 0) {
            $x -= 2;
        } else {
            $x = 7;
            if ($y > 0) {
                $y--;
            } else {
                return false;
            }
        }
        return true;
    }
}
