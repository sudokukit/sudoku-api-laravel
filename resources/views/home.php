<!DOCTYPE html>
<html ng-app="SudokuMaster">
	<head>
		<title>SudokuMaster.net | Play Sudoku!</title>

		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" >
		<link rel="stylesheet" type="text/css" href="/assets/style.css">
		<link rel="stylesheet" type="text/css" href="/assets/hotkeys.min.css">
		
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min.js"></script>
		<script type="text/javascript" src="/assets/hotkeys.min.js"></script>
		<script type="text/javascript" src="/assets/sudoku.js"></script>
	</head>
	<body>
		<div ng-controller="sudokuController" class="wrapper">
			<h1>SudokuMaster.net</h1>
			
			<div class="difficulty">
				<div class="stars">
					<i ng-repeat="star in difficulty.stars" class="glyphicon glyphicon-star star"></i>
				</div>
				<div class="description">
					<h4>Difficulty: {{difficulty.name}} ({{difficulty.level}} star{{difficulty.level == 1 ? "" : "s"}})</h4>
				</div>
			</div>

			<div class="puzzle" >
				<table>
					<tr ng-repeat="row in puzzle">
						<td ng-repeat="item in row track by $index" ng-class=" $index == selected.cell && $parent.$index == selected.row ? 'selected' : '' " ng-click="selectCell($parent.$index,$index)">
						<span ng-if="item.given == true" class="given">
						{{item.value == 0 ? ' ' : item.value }}	
						</span>
						<span ng-if="item.given == false">
						{{item.value == 0 ? ' ' : item.value }}
						</span>
						</td>
					</tr>
				</table>	
			</div>

			<div class="buttons">
			<h4>{{result}}</h4>

				<button type="button" class="btn btn-danger btn-lg" ng-click="reset()">
					<i class="glyphicon glyphicon-remove"></i>
					Reset
				</button>
				<button type="button" class="btn btn-primary btn-lg" ng-click="validate()">
					<i class="glyphicon glyphicon-ok"></i>
					Check Sudoku
				</button>
				<button type="button" class="btn btn-success btn-lg" ng-click="newGame()">
					<i class="glyphicon glyphicon-play"></i>
					New Game
				</button>
			</div>
			<div class="difficultyButtons">
				<h4>Preferred Difficulty: {{preferredDifficulty.name}}
					<i ng-repeat="star in preferredDifficulty.stars" class="glyphicon glyphicon-star star"></i>
				</h4>
				<div class="btn-group">
					<button type="button" class="btn btn-lg" ng-repeat="difficultyButton in difficulties" ng-click="setPreferredDifficulty(difficultyButton.level)" ng-class="preferredDifficulty == difficultyButton ? 'btn-primary' : 'btn-default'">{{difficultyButton.name}}</button>
				</div>
			</div>
		</div>
	</body>
</html>