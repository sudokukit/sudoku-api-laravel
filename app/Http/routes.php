<?php

Route::get('/', 'HomeController@index');
Route::get('/api/puzzles', 'ApiController@getPuzzle');
Route::get('/api/solutions', 'ApiController@checkSolution');
Route::get('/api/hints', 'ApiController@improveSolution');
