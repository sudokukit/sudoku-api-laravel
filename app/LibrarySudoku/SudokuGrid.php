<?php

namespace App\LibrarySudoku;

/**
 * Class SudokuGrid
 */
class SudokuGrid
{
    /**
     * Matrix representation of sudoku grid.
     *
     * @var array
     */
    private $grid;

    /**
     * SudokuGrid constructor.
     */
    public function __construct()
    {
        $this->initializeGrid();
    }

    /**
     * Initializes the grid to empty fields.
     *
     * @return void
     */
    private function initializeGrid()
    {
        $grid = [];
        for ($i = 0; $i < 9; $i++) {
            for ($j = 0; $j < 9; $j++) {
                $grid[$i][$j] = 0;
            }
        }
        $this->grid = $grid;
    }

    /**
     * Sets the cell with given position to given value.
     *
     * @param integer $x     The x position of the cell.
     * @param integer $y     The y position of the cell.
     * @param integer $value The value of the cell.
     */
    public function setCell(int $x, int $y, int $value)
    {
        if ($value >= 0 && $value <= 9) {
            $this->grid[$y][$x] = $value;
        }
    }

    /**
     * Getter for single cell from the grid.
     *
     * @param integer $x The x position of the cell.
     * @param integer $y The y position of the cell.
     *
     * @return integer
     */
    public function getCell($x, $y)
    {
        return $this->grid[$y][$x];
    }

    /**
     * Setter for the internal grid.
     *
     * @param array $grid The new grid.
     */
    public function setGrid($grid)
    {
        $this->grid = $grid;
    }

    /**
     * Getter for the grid.
     *
     * @return array
     */
    public function getGrid()
    {
        return $this->grid;
    }

    public function getGridAsString()
    {
        $gridAsString = '';
        foreach ($this->grid as $row) {
            foreach ($row as $value) {
                $gridAsString .= (string) $value;
            }
        }

        return $gridAsString;
    }

    /**
     * Returns given row of the grid.
     *
     * @param integer $rowNumber The row number.
     *
     * @return array
     */
    public function getRow(int $rowNumber)
    {
        return $this->grid[$rowNumber];
    }

    /**
     * Returns a given column.
     *
     * @param integer $columnNumber The column number.
     *
     * @return array
     */
    public function getColumn(int $columnNumber)
    {
        $column = [];
        for ($i = 0; $i < 9; $i++) {
            $column[$i] = $this->getCell($columnNumber, $i);
        }
        return $column;
    }

    /**
     * Returns block by number (ltr,ttb) (0-8)
     *
     * @param integer $blockNumber The block number.
     *
     * @return array
     */
    public function getBlockByNumber(int $blockNumber)
    {
        $mod3 = $blockNumber % 3;
        $column = $mod3 * 3;
        $row = $blockNumber - $mod3;
        return $this->getBlock($row, $column);
    }

    /**
     * Gets the entire block for a given single cell.
     *
     * @param integer $row    The row number.
     * @param integer $column The column number.
     *
     * @return array
     */
    public function getBlock($row, $column)
    {

        list($firstRowInBlock, $firstColumnInBlock) = $this->getFirstCellInBlock($row, $column);
        $block = [];
        for ($i = 0; $i < 3; $i++) {
            $number = $i * 3;
            for ($j = 0; $j < 3; $j++) {
                $block[$number + $j] = $this->getCell($j + $firstColumnInBlock, $i + $firstRowInBlock);
            }
        }
        return $block;
    }

    /**
     * Gets the first (left-top) cell of a 3x3 block.
     *
     * @param integer $row    The row.
     * @param integer $column The column.
     *
     * @return array
     */
    private function getFirstCellInBlock($row, $column)
    {
        $columnNumberInBlock = $column % 3;
        $rowNumberInBlock = $row % 3;
        $firstColumnInBlock = $column - $columnNumberInBlock;
        $firstRowInBlock = $row - $rowNumberInBlock;

        return [$firstRowInBlock, $firstColumnInBlock];
    }

    /**
     * Returns all possibilities for a given cell.
     *
     * @param integer $column The column position of the cell.
     * @param integer $row    The row position of the cell.
     *
     * @return array|null
     */
    public function possibilitiesFor(int $column, int $row)
    {
        if ($this->getCell($column, $row) > 0) {
            return null;
        }
        $invalid_numbers = array_unique(array_merge(
            $this->getRow($row),
            $this->getColumn($column),
            $this->getBlock($row, $column)
        ));
        $array = [1, 2, 3, 4, 5, 6, 7, 8, 9];
        return array_filter(array_values(array_diff($array, $invalid_numbers)));
    }
}
