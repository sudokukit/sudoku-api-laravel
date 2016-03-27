var sudokuMaster = angular.module('SudokuMaster', ['cfp.hotkeys']).config(function(hotkeysProvider) {
    hotkeysProvider.includeCheatSheet = false;
});

sudokuMaster.controller('sudokuController', ['$scope', 'hotkeys', function($scope, hotkeys) {

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
        $scope.puzzle[$scope.selected.row][$scope.selected.cell] = number;
    };

    hotkeys.add({
        combo: '0',
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

    $scope.stars = [1, 2, 3, 4];
    $scope.numberOfStars = 4;
    $scope.difficulty = 'hard';

    $scope.puzzle = [
        [1, 2, 3, 4, 5, 6, 7, 8, 9],
        [1, 2, 3, 4, 0, 6, 7, 8, 9],
        [1, 2, 3, 4, 5, 6, 7, 8, 9],
        [1, 2, 3, 4, 0, 6, 7, 0, 9],
        [1, 2, 0, 4, 5, 6, 7, 8, 9],
        [1, 2, 3, 4, 5, 0, 7, 8, 9],
        [1, 2, 3, 4, 5, 6, 0, 8, 9],
        [1, 2, 3, 4, 5, 6, 7, 8, 9],
        [1, 2, 3, 4, 5, 6, 7, 8, 9]
    ];

}]);
