(function () {
	var app = angular.module('antwerpen_project', []);

	app.controller('projectController', ['$http', "$scope", function ($http, $scope) {
		
		// home page haal alle projecten 
		$http.get(root+"/al_projects/api/get")
			.success(function (data) {
				$scope.projects = data;
				console.log(data);
			});
		
		//vers
		$scope.add_project = function (content, token, admin) {
			console.log(name, token, admin);
			var data = {
				row_content: content,
				admin: admin,
				_method: "PUT",
				_token: token
			};
			

			$http.post(root+"/projecten/api/add", data).success(function (data, status) {
                console.log(data);
				$scope.projects.push(data);
			})
		}
	}]);
})();