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
		console.log("controller is klaar");
		
		$scope.initializetion = function (id) {
			console.log("project id is geintializeerd");
			$scope.project_id = id;
			//console.log($scope.project_id);
			
			//haal alle informatie ui projecten database 
			$http.get(root + "/project/" + $scope.project_id + "/edit/api")
				.success(function (data) {
					$scope.project = data;
				//console.log("project data is binnen");
				console.log(data);
				});

			//haal alle vragen uit behorende project
			$http.get(root + "/vragen/" + $scope.project_id + "/edit/api")
				.success(function (data) {
				$scope.alle_vragen = data;
				//console.log("vragen data is binnen");
				console.log(data);
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
				//$scope.project = data;
			});


		};





		$scope.add_question = function (question) {
			console.log(question);
			var data = {
				question_type: question,
				project_id: $scope.project_id,
				_method: "PUT"
			};

			$http.post(root + "/Vragen/api/add_dependency", data).success(function (data) {
				$scope.alle_vragen.push(data);
			});
		}

		}])
})();