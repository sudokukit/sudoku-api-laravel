<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Puzzle extends Model{
	private string $id;
	private int $difficulty;
	private SodukuGrid $sudokuGrid;
	private string $solution_id;
}
