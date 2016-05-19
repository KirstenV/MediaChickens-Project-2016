(function () {
    var app = angular.module('antwerpen_project', ['uiGmapgoogle-maps']);
	app.controller('projectController', ["$scope", function ($scope) {
		$scope.ready= "hallo ik ben ready";
		$scope.map = { center: { latitude: 45, longitude: -73 }, zoom: 8 };
	}]);
	
	})();