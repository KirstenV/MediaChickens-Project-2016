(function () {
	var app = angular.module('antwerpen_project', []);

	app.controller('projectController', ['$http', "$scope", function ($http, $scope) {
		$scope.text="vul mij in";
		$http.get("al_projects/api/get")
			.success(function (data) {
				$scope.projects = data;
				console.log(data);
			});
		$scope.add_project = function (content, token, admin) {

			console.log(name, token, admin);
			var data = {
				row_content: content,
				admin: admin,
				_method: "PUT",
				_token: token
			};

			$http.post("projecten/api/add", data).success(function (data, status) {
				$scope.projects.push(data);
			})
		}
	}]);
})();