var sudokuMaster = angular.module('SudokuMaster', ['cfp.hotkeys']);

sudokuMaster.controller('sudokuController', ['$scope', 'hotkeys', function($scope, hotkeys) {
    $scope.stars = [1, 2, 3, 4];
    $scope.numberOfStars = 4;
    $scope.difficulty = 'hard';
    $scope.selected = {
        row: 0,
        cell: 0
    };

    $scope.emptySelectedCell = function() {
        $scope.key = 'Yes';
    };

    hotkeys.add({
        combo: '0',
        description: 'Empty the selected cell',
        callback: function() {
            $scope.emptySelectedCell();
        }
    });

    $scope.selectCell = function(rowId, cellId) {
        $scope.selected = { row: rowId, cell: cellId };
    };

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
