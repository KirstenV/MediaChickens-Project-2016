(function () {
	var app = angular.module('antwerpen_project', []);

	app.controller('projectController', ['$http', "$scope", function ($http, $scope) {

		// home page haal alle projecten 
		$http.get(root + "/al_projects/api/get")
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

			$http.post(root + "/projecten/api/add", data).success(function (data, status) {
				$scope.projects.push(data);
			});
	
		$scope.set_id = function (id) {
			$http.get(root + "/al_projects/api/get")
				.success(function (data) {
					$scope.projects = data;
					console.log(data);
				});

		};
		};
	}]);

	app.controller('edit_projectController', ['$scope', '$http', function ($scope, $http) {
		$scope.initializetion = function (id) {
			$scope.id = id;
			console.log($scope.tab);

			$http.get(root + "/project/" + $scope.id + "/edit/api")
				.success(function (data) {
					console.log(data);
					$scope.project = data;
				});
		}

		$scope.edit_project = function (tabel, id, veldnaam, content, token) {
			var data = {
				row_name: veldnaam,
				row_content: content,
				_method: "PUT",
				_token: token
			};


			$http.post(root + "/" + tabel + "/" + id, data).success(function (data, status) {
				$scope.project = data;
			});


		};



		}])
})();