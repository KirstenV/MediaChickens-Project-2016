(function () {
    var app = angular.module('antwerpen_project', ['ngFileUpload']);

    app.controller('projectController', ['$http', "$scope", function ($http, $scope) {
        $scope.project;


        // home page haal alle projecten
        $http.get(root + "/al_projects/api/get")
            .success(function (data) {
                $scope.projects = data;
                //console.log(data);
            });

        $scope.show_project_info = function ($id_project) {
            console.log("id van de gelickte project is = ",$id_project);
            $http.get(root + "/project/"+$id_project+"/api")
                .success(function (data) {
                    $scope.project = data;
                    console.log(data);
                });
        }
        $scope.show_projects =function () {
            console.log("Er is gedrukt op het terug keren naar projecten");
            $scope.project="";
        }
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
            var data = {
                _method: "POST",
            };
            $http.post(root + "/project/" + $id + "/delete/api", data).success(function (data) {
                $scope.projects.splice($index, 1);
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
                rij_naam: veldnaam,
                invul_veld: content,
                _method: "PUT",
                _token: token
            };

            $http.post(root + "/" + tabel + "/" + id, data).success(function (data, status) {
                //$scope.project = data;
                console.log("validation of input from server", data);
                $scope.server_controle_input_veld = "";
                $scope.server_controle_input_veld_succes = "";
                $scope.server_controle_veld__id =data.id;
                if(data.$errors){
                    $scope.server_controle_input_veld = data.rij_naam;
                    $scope.server_controle_fout = data.$errors.invul_veld;
                    console.log("error messeg afte validation =" ,$scope.server_controle_fout);
                    console.log("validatiion er gien iets fout");
                }
                if(data.$succes){

                    $scope.server_controle_input_veld_succes =data.rij_naam;
                    $scope.server_controller_error = data.$succes;
                    console.log("validatiion alles is goed opgeslagen");
                }
            });


        };

        $scope.toon_fout_melding = function ($tabele,$id) {
            if($scope.server_controle_input_veld == $tabele &&   $scope.server_controle_veld__id == $id){
                console.log("toon fout melding van de angepaste veld met id van ", $scope.server_controle_veld__id);
                return true;
            }
        }
        $scope.toon_succes_melding = function ($tabele, $id) {
            console.log("toon succes meldin =" , $scope.server_controle_input_veld_succes , $tabele , $scope.server_controle_veld__id, $id);
            if( $scope.server_controle_input_veld_succes == $tabele &&   $scope.server_controle_veld__id == $id){
                return true;
            }
        }

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


    app.controller('add_fase_and_filleController', ['$scope', 'Upload', '$timeout', '$http', function ($scope, Upload, $timeout, $http) {

        $scope.fase_choice =[];


        
        $scope.fase_update = function ($index,$fase_id) {
            //$scope.fase_choice=event.target.value;
            //console.log( $scope.fase_choice);

            console.log("update fase =" , $scope.fase_choice[$index]);

            var data = {
                rij_naam: "fases",
                invul_veld:  $scope.fase_choice[$index],
                _method: "PUT"
            };
            $http.post(root + "/fases/" + $fase_id, data).success(function (data, status) {
                //$scope.project = data;
                console.log("validation of input from server", data);
                $scope.fases_server_controle_input_veld = "";
                $scope.fases_server_controle_input_veld_succes = "";
                $scope.fases_server_controle_veld__id =data.id;
                if(data.$errors){
                    $scope.fases_server_controle_input_veld = data.rij_naam;
                    $scope.fases_server_controle_fout = data.$errors.invul_veld;
                    console.log("validatiion er gien iets fout --- in api cal -- fase --> type fase");
                }
                if(data.$succes){
                    $scope.fases_server_controle_input_veld_succes =data.rij_naam;
                    $scope.fases_server_controller_error = data.$succes;
                    console.log("validatiion alles is goed opgeslagen--- in api call -- fase --> type fase");
                }
            });
        }

        $scope.type_fase_saved = function ($tabele,$id) {
            //console.log("validation of fase type ==> " ,$scope.fases_server_controle_input_veld_succes, $tabele,$scope.fases_server_controle_veld__id, $id);
            if( $scope.fases_server_controle_input_veld_succes == $tabele &&   $scope.fases_server_controle_veld__id == $id){
                //console.log("er is een overeencomst in fase type ")
                return true;
            }
        }
        
        $scope.fase_delected =function ($value,$fase_type) {
            if( $value == $fase_type && $fase_type != undefined ){
                //console.log("er is een overeenkomst bij het dropdown selct option = ", $value, $fase_type)
                return true;
            }
            //console.log("drop down select option =",$value,$fase_type);
        }


        $scope.initializetion_fase = function (id) {
            $scope.project_id = id;
            //console.log("project id is =",$scope.project_id);

            //haal alle informatie ui fotos database
            $http.get(root + "/fase/get_fase/" + $scope.project_id + "/api")
                .success(function (data) {
                    $scope.show_fases = data;
                    //console.log("project data is binnen");
                    //console.log("overziecht van alle fases = ",$scope.show_fases);
                });
        }

        $scope.add_fase = function () {
            var data = {
                project_id:  $scope.project_id,
                _method: "post",
            };
            $http.post(root + "/fase/add_fase/api", data).success(function (data) {
                //$scope.project = data;
                $scope.show_fases.push(data);
                console.log("dases toevoegen zie latste index = ",$scope.show_fases);
            });
        }
        
        $scope.get_fase_id =function ($fase_id) {
            console.log("id van fase pictuur", $fase_id);
            $scope.fase_id = $fase_id;
        }

        $scope.uploadFiles = function (files, errFiles,$fase_id) {
            console.log("fase id id gekozen via fill upload =", $fase_id);
            //$scope.files = files;
            //$scope.errFiles = errFiles;
            //$scope.errorMsg = " ";
            angular.forEach(files, function (file) {
                file.upload = Upload.upload({
                    url: root + '/Project_fase/update_fase_img/api',
                    data: {fase_photo: file},
                    method: "POST",
                    _token: '{{csrf_token()}}'
                });
                file.upload.then(function (response) {
                    $timeout(function () {

                        file.result = response.data;
                        if (response.data.error) {
                            $scope.error_massage_server = response.data.error;
                        }
                        console.log(response.data);
                        
                        if (response.data.success) {
                            var data = {
                                rij_naam: "fases_picture",
                                invul_veld: response.data.src_image,
                                _method: "PUT"
                            };

                            $http.post(root + "/fases/" + $fase_id, data).success(function (data, status) {
                                //$scope.project = data;
                                console.log("validation of input from server", data);
                                $scope.server_controle_input_veld = "";
                                $scope.server_controle_input_veld_succes = "";
                                if(data.$errors){
                                    $scope.server_controle_input_veld = data.rij_naam;
                                    $scope.server_controle_fout = data.$errors.invul_veld;
                                   // console.log("error messeg afte validation =" ,$scope.server_controle_fout);
                                    //console.log("validatiion er gien iets fout --- in api cal -- fase");
                                }
                                if(data.$succes){
                                    console.log( "src voor verandering = ",$scope.show_fases[$scope.fase_id].fases_picture);
                                    $scope.show_fases[$scope.fase_id].project_picture = data.fases_picture;
                                    console.log( "after update of img src wy gate = ",$scope.show_fases[$scope.fase_id].project_picture);

                                    $scope.server_controle_input_veld_succes =data.rij_naam;
                                    $scope.server_controller_error = data.$succes;
                                   // console.log("validatiion alles is goed opgeslagen--- in api call -- fase ");
                                }
                            });
                        }
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