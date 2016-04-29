(function () {
    var app = angular.module('antwerpen_project', ['ngFileUpload']);

    app.controller('projectController', ['$http', "$scope", function ($http, $scope) {

        // home page haal alle projecten
        $http.get(root + "/al_projects/api/get")
            .success(function (data) {
                $scope.projects = data;
                //console.log(data);
            });

        //vers
        $scope.add_project = function (content, token, admin) {
            //console.log(name, token, admin);
            var data = {
                row_content: content,
                admin: admin,
                _method: "PUT",
                _token: token
            };

            $http.post(root + "/projecten/api/add", data).success(function (data, status) {
                $scope.projects.push(data);
                //console.log("data");
                //console.log(data);
                $scope.highlight_class = data.id;

            });

            $scope.set_id = function (id) {
                $http.get(root + "/al_projects/api/get")
                    .success(function (data) {
                        $scope.projects = data;
                        //console.log(data);
                    });

            };
        };

        $scope.is_tru_id = function (variabel1, variabel2) {
            if (variabel1 == variabel2) {
                return "highlight_class";
            }
        }

        $scope.delete_project = function ($id, $index) {
            console.log("project om te verwijderen: " + $id + " index in de repeat: " + $index);
            console.log("project om te verwijderen: " + $id);

            var data = {
                _method: "POST",
            };
            $http.post(root + "/project/" + $id + "/delete/api", data).success(function (data) {
                //$scope.projects = data;
                //$scope.project.indexOf(data);
                $scope.projects.splice($index, 1);

                console.log("projecten in de lijst: " + $scope.projects.length);

                /*
                 angular.forEach($scope.projects, function(value, key) {
                 if(value.id == data.id){
                 delete $scope.projects[key];
                 console.log("project met id "+ key + " vervijderd!");
                 this.break;
                 }
                 });*/


                /*
                 for(var i=0; i< $scope.projects.length; i++){
                 console.log("cheking id: "+i);
                 if($scope.projects[i].id == data.id){
                 delete $scope.projects[i];
                 $scope.projects.length--;
                 console.log("verwijder id: "+i);
                 break;
                 }
                 }*/
                console.log("projecten in de lijst: " + $scope.projects.length + " na verwijder actie.");
                console.log("projects scope na verwijderen: ", $scope.projects);
                //console.log(data);

            });

        }

    }]);

    app.controller('edit_projectController', ['$scope', '$http', function ($scope, $http) {
        //console.log("controller is klaar");

        $scope.initializetion = function (id) {
            //console.log("project is geintializeerd");
            $scope.project_id = id;
            //console.log($scope.project_id);

            //haal alle informatie ui projecten database
            $http.get(root + "/project/" + $scope.project_id + "/edit/api")
                .success(function (data) {
                    $scope.project = data;
                    //console.log("project data is binnen");
                    //console.log(data);
                });

            //haal alle vragen uit behorende project
            $http.get(root + "/vragen/" + $scope.project_id + "/edit/api")
                .success(function (data) {
                    $scope.alle_vragen = data;
                    //console.log("vragen data is binnen");
                    //console.log(data);
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
            //console.log(question);
            var data = {
                question_type: question,
                project_id: $scope.project_id,
                _method: "PUT"
            };

            $http.post(root + "/Vragen/api/add_dependency", data).success(function (data) {
                $scope.alle_vragen.push(data);
            });
        }

    }]);


    app.controller('file_uplodController', ['$scope', 'Upload', '$timeout', '$http', function ($scope, Upload, $timeout, $http) {

        $scope.initializetion_foto = function (id) {
            console.log("fotos  zijn geintializeerd");
            $scope.project_id = id;
            console.log($scope.project_id);

            //haal alle informatie ui fotos database
            $http.get(root + "/fotos/" + $scope.project_id + "/edit/api")
                .success(function (data) {
                    $scope.show_fotos = data;
                    //console.log("project data is binnen");
                    console.log($scope.show_fotos);
                });


        }

        $scope.uploadFiles = function (files, errFiles) {
            $scope.files = files;
            $scope.errFiles = errFiles;
            $scope.errorMsg = " ";
            angular.forEach(files, function (file) {

                console.log($scope);
                file.upload = Upload.upload({
                    url: root + '/upload_form',
                    data: {project_photo: file},
                    method: "POST",
                    _token: '{{csrf_token()}}'
                });
                file.upload.then(function (response) {
                    $timeout(function () {

                        file.result = response.data;
                        if (response.data.error) {
                            $scope.errorMsg = response.data.error;
                        }
                        console.log(response.data.success);
                        console.log(response.data.src_image);
                        if (response.data.success) {
                            var data = {
                                project_id: $scope.project_id,
                                row_content: response.data.src_image,
                                _method: "PUT",
                            };

                            $http.post(root + "/Project_foto/add_foto/api", data).success(function (data) {
                                //$scope.project = data;
                                $scope.show_fotos.push(data);
                                console.log($scope.show_fotos);
                            });

                        }

                        console.log(file.result);
                    });
                }, function (response) {
                    console.log("respons functie");
                    console.log(response);
                    if (response.status > 0) {

                        $scope.errorMsg = response.status + ': ' + response.data;
                    }
                }, function (evt) {
                    file.progress = Math.min(100, parseInt(100.0 *
                        evt.loaded / evt.total));
                });
            });
        }
    }]);

    /*
     app.controller('MyCtrl', ['$scope', 'Upload', '$timeout', function ($scope, Upload, $timeout) {
     $scope.uploadFiles = function(files, errFiles) {
     $scope.files = files;
     $scope.errFiles = errFiles;
     $scope.errorMsg = " ";
     angular.forEach(files, function(file) {

     console.log($scope);
     file.upload = Upload.upload({
     url: root+ '/upload_form',
     data: {project_photo: file},
     method: "POST",
     _token: '{{csrf_token()}}'
     });
     file.upload.then(function (response) {
     $timeout(function () {
     file.result = response.data;
     if(response.data.error){
     $scope.errorMsg = response.data.error;
     }

     console.log(file.result);
     });
     }, function (response) {
     console.log("respons functie");
     console.log(response);
     if (response.status > 0){

     $scope.errorMsg = response.status + ': ' + response.data;
     }
     }, function (evt) {
     file.progress = Math.min(100, parseInt(100.0 *
     evt.loaded / evt.total));
     });
     });
     }
     }]);
     */
})();