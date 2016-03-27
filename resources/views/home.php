<!DOCTYPE html>
<html ng-app="SudokuMaster">
	<head>
		<title>SudokuMaster.net | Play Sudoku!</title>

		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
		<link href="https://fonts.googleapis.com/css?family=Lora:400,700&subset=latin,latin-ext" rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="/assets/style.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min.js"></script>
		<script type="text/javascript" src="/assets/sudoku.js"></script>
	
	</head>
	<body>
		<div ng-controller="sudokuController" class="wrapper">
			<h1>SudokuMaster.net</h1>
			
			<div class="difficulty">
				<div class="stars">
					<i ng-repeat="star in stars" class="glyphicon glyphicon-star star"></i>
				</div>
				<div class="description">
					<h3>Difficulty: {{difficulty}} ({{numberOfStars}} star{{numberOfStars == 1 ? "" : "s"}})</h3>
				</div>
			</div>
			<div class="puzzle" >
				<table>
					<tr ng-repeat="row in puzzle">
						<td ng-repeat="item in row">{{item}}</td>
					</tr>
				</table>	
			</div>

			<div class="buttons">
				<input ng-model="name" type="text">
				<h2>{{name}}</h2>
				validate, new game
			</div>
		</div>
	</body>
</html>