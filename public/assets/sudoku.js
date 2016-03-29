var sudokuMaster = angular.module('SudokuMaster', ['cfp.hotkeys']).config(function(hotkeysProvider) {
    hotkeysProvider.includeCheatSheet = false;
});

sudokuMaster.controller('sudokuController', ['$scope', '$http', 'hotkeys', function($scope, $http, hotkeys) {

    // Navigating
    $scope.selected = {
        row: 0,
        cell: 0
    };

    $scope.moveUp = function() {
        if ($scope.selected.row == 0) {
            $scope.selected.row = 8;
        } else {
            $scope.selected.row--;
        }
    };

    $scope.moveDown = function() {
        if ($scope.selected.row == 8) {
            $scope.selected.row = 0;
        } else {
            $scope.selected.row++;
        }
    };

    $scope.moveLeft = function() {
        if ($scope.selected.cell == 0) {
            $scope.selected.cell = 8;
        } else {
            $scope.selected.cell--;
        }
    };

    $scope.moveRight = function() {
        if ($scope.selected.cell == 8) {
            $scope.selected.cell = 0;
        } else {
            $scope.selected.cell++;
        }
    };

    hotkeys.add({ combo: 'up', description: 'Move up', callback: function() { $scope.moveUp(); } });
    hotkeys.add({ combo: 'down', description: 'Move down', callback: function() { $scope.moveDown(); } });
    hotkeys.add({ combo: 'left', description: 'Move left', callback: function() { $scope.moveLeft(); } });
    hotkeys.add({ combo: 'right', description: 'Move right', callback: function() { $scope.moveRight(); } });

    // Input 
    $scope.setSelectedCell = function(number) {
        var cell = $scope.puzzle[$scope.selected.row][$scope.selected.cell];
        if (cell.given) {
            // cell is given so do nothing
        } else {
            cell.value = number;
        }
    };

    hotkeys.add({
        combo: '0',
        description: 'Empty the selected cell',
        callback: function() {
            $scope.setSelectedCell(0);
        }
    });
    hotkeys.add({
        combo: 'backspace',
        description: 'Empty the selected cell',
        callback: function() {
            $scope.setSelectedCell(0);
        }
    });
    hotkeys.add({
        combo: '1',
        description: 'Puts 1 in the selected cell',
        callback: function() {
            $scope.setSelectedCell(1);
        }
    });
    hotkeys.add({
        combo: '2',
        description: 'Puts 2 in the selected cell',
        callback: function() {
            $scope.setSelectedCell(2);
        }
    });
    hotkeys.add({
        combo: '3',
        description: 'Puts 3 in the selected cell',
        callback: function() {
            $scope.setSelectedCell(3);
        }
    });
    hotkeys.add({
        combo: '4',
        description: 'Puts 4 in the selected cell',
        callback: function() {
            $scope.setSelectedCell(4);
        }
    });
    hotkeys.add({
        combo: '5',
        description: 'Puts 5 in the selected cell',
        callback: function() {
            $scope.setSelectedCell(5);
        }
    });
    hotkeys.add({
        combo: '6',
        description: 'Puts 6 in the selected cell',
        callback: function() {
            $scope.setSelectedCell(6);
        }
    });
    hotkeys.add({
        combo: '7',
        description: 'Puts 7 in the selected cell',
        callback: function() {
            $scope.setSelectedCell(7);
        }
    });
    hotkeys.add({
        combo: '8',
        description: 'Puts 8 in the selected cell',
        callback: function() {
            $scope.setSelectedCell(8);
        }
    });
    hotkeys.add({
        combo: '9',
        description: 'Puts 9 in the selected cell',
        callback: function() {
            $scope.setSelectedCell(9);
        }
    });


    $scope.selectCell = function(rowId, cellId) {
        $scope.selected = { row: rowId, cell: cellId };
    };

    // Puzzle
    $scope.setDifficulty = function(difficulty) {
        switch (difficulty) {
            case 1:
                $scope.difficulty = { name: 'Very Easy', level: 1, stars: [1] };
                break;
            case 2:
                $scope.difficulty = { name: 'Easy', level: 2, stars: [1, 2] };
                break;
            case 3:
                $scope.difficulty = { name: 'Normal', level: 3, stars: [1, 2, 3] };
                break;
            case 4:
                $scope.difficulty = { name: 'Hard', level: 4, stars: [1, 2, 3, 4] };
                break;
            case 5:
                $scope.difficulty = { name: 'Legendary', level: 5, stars: [1, 2, 3, 4, 5] };
                break;
            default:
                $scope.setDifficulty(1);
                break;
        }
    };

    $scope.puzzleToString = function() {
        $result = '';
        for (var i = 0; i < 9; i++) {
            for (var j = 0; j < 9; j++) {
                $result += $scope.puzzle[i][j].value.toString();
            }
        }
        return $result;
    };

    $scope.setPuzzle = function(data) {
        $scope.puzzle = data.puzzle;
        $scope.backupPuzzle = angular.copy(data.puzzle);
        $scope.puzzleId = data.id;
        $scope.setDifficulty(data.difficulty);
        $scope.resetResult();
    };

    $scope.reset = function() {
        $scope.puzzle = angular.copy($scope.backupPuzzle);
    };

    $scope.newGame = function() {
        $http({
            method: 'GET',
            url: '/api/puzzles/?difficulty=' + $scope.preferredDifficulty
        }).then(function successCallback(response) {
            $scope.setPuzzle(response.data);
        }, function errorCallback(response) {});
    };

    $scope.validate = function() {
        $http({
            method: 'GET',
            url: '/api/solutions/?id=' + $scope.puzzleId + '&solution=' + $scope.puzzleToString()
        }).then(function successCallback(response) {
            $scope.result = response.data.result;
        }, function errorCallback(response) {});
    };

    $scope.resetResult = function() {
        $scope.result = "No results yet. Hit 'Check Sudoku' to check your progress!";
    }

    // Initialize first puzzle
    $scope.preferredDifficulty = 3;
    $scope.newGame();
    $scope.resetResult();

}]);
