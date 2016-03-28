<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    private string $id;
	private SodukuGrid $sudokuGrid;
}
