<?php

namespace App\LibrarySudoku;

class SudokuValidator
{
    private $sudokuGrid;

    public function validate(SudokuGrid $sudokuGrid)
    {
        $this->sudokuGrid = $sudokuGrid;
        if ($this->validateRows() && $this->validateColumns() && $this->validateBlocks()) {
            return true;
        } else {
            return false;
        }
    }

    public function countZeros($sudokuGrid)
    {
        $this->sudokuGrid = $sudokuGrid;
        $count = 0;
        for ($i = 0; $i < 9; $i++) {
            $counted_values = array_count_values($this->sudokuGrid->getRow($i));
            // check if [0] exists then add it up
            if (array_key_exists('0', $counted_values)) {
                $count += $counted_values['0'];
            }
        }
        return $count;
    }

    private function validateRows()
    {
        for ($i = 0; $i < 9; $i++) {
            if (! $this->validateRow(
                $this->sudokuGrid->getRow($i)
            )
            ) {
                return false;
            }
        }
        return true;
    }

    private function validateColumns()
    {
        for ($i = 0; $i < 9; $i++) {
            $column = $this->sudokuGrid->getColumn($i);
            if (! $this->validateRow($column)) {
                return false;
            }
        }
        return true;
    }

    private function validateBlocks()
    {
        for ($i = 0; $i < 9; $i++) {
            $block = $this->sudokuGrid->getBlockByNumber($i);
            if (! $this->validateRow($block)) {
                return false;
            }
        }
        return true;
    }

    private function validateRow($row)
    {
        $numbers = array_values(array_diff($row, [0]));
        if (count(array_unique($numbers)) < count($numbers)) {
            return false;
        }
        return true;
    }
}
