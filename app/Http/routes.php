<?php

Route::get('/puzzles', 'ApiController@getPuzzle');
Route::get('/solutions', 'ApiController@checkSolution');
Route::get('/hints', 'ApiController@improveSolution');