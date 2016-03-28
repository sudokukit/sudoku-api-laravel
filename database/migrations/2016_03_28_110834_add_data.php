<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::$table('solutions')->insert(array(
                'grid' => '934268517512973648876451239745396821389142756621785493453617982197824365268539174'
            ));

        $results = DB::select('select * from solutions', array(1));

        DB::$table('puzzles')->insert(array(
                'grid' => '004060007010970040006050030045300021009102700620005490050010900090024060200030100',
                'solution_id' => $solution_id,
                'difficulty' => 3
            ));
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
