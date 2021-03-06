(function () {
    var app = angular.module('antwerpen_project', ['ngFileUpload','uiGmapgoogle-maps']);


    app.controller('LoginController',['$http','$scope', function ($http,$scope) {
        $scope.login_data ={}
        console.log("register controller activ")
        
        $scope.intialization_csrt_token = function () {

            console.log("intialiseren van token");
        }

        $scope.submit_login =function () {
            //console.log("csrf token is:",$scrf_token);
            console.log("form verzonden data is: ",$scope.login_data);
            
            var data = {
                name: $scope.login_data.name,
                email: $scope.login_data.email,
                password: $scope.login_data.password,
                password_password_confirmation: $scope.login_data.password_confirmation,
                _method: "POST",
            };

            $http.post(root + "/register", data).success(function (data) {
               console.log("return data from loging api",data);
            });
        }
    }])

    app.controller('projectController', ['$http', "$scope", function ($http, $scope) {

        //goole maps
        $scope.map = { center: { latitude: 45, longitude: -73 }, zoom: 8 };





        $scope.project;


        // home page haal alle projecten
        $http.get(root + "/al_projects/api/get")
            .success(function (data) {
                $scope.projects = data;
                //console.log(data);
            });

        $scope.show_project_info = function ($id_project) {
            console.log("id van de gelickte project is = ", $id_project);
            $http.get(root + "/project/" + $id_project + "/api")
                .success(function (data) {
                    $scope.project = data;
                    console.log(data);
                });
        }
        $scope.show_projects = function () {
            console.log("Er is gedrukt op het terug keren naar projecten");
            $scope.project = "";
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
                if (data != "error") {
                    $scope.projects.splice($index, 1);
                }
            });

        }


    }]);

    app.controller('edit_projectController', ['$scope', '$http', function ($scope, $http) {
        //console.log("controller is klaar");

        $scope.google_maps_controller_error_catsher = function ($error) {
            $scope.locations_errors = $error;
        }
        $scope.google_maps_controller = function (lat, lng, adress) {
            //console.log("gegevens van de goole maps zij",lat,lng,adress);

            var data = {
                lat: lat,
                lng: lng,
                address: adress,
                _method: "POST"
            };

            $http.post(root + "/locatie/toevoegen/" + $scope.project_id + "/api", data).success(function (data) {
                //console.log('locaties zijn toegevoegd via google maps controller voor project =', $scope.project_id,data);
                $scope.locations_errors = "";
                if (data.$succes) {
                    $scope.locations.push(data.$location);
                } else {
                    if (data.$errors) {
                        $scope.locations_errors = data.$errors;
                    }
                    $scope.locations_errors = "Oeps, weet je zeker dat alles is goed ingevuld !";
                }

            });
        }

        $scope.delete_elemets_on_edit_page_locatie = function ($id, $index, $tabele) {
            console.log("deleted varagen click with following parameters ==>", $id, $index);
            var data = {
                _method: "POST",
            };
            $http.post(root + "/edit/" + $tabele + "/" + $id + "/delete/api", data).success(function (data) {
                if (data != "error") {
                    $scope.locations.splice($index, 1);

                }
                console.log(data);
            });
        }

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

            $http.get(root + "/locaties/" + $scope.project_id + "/edit/api")
                .success(function (data) {
                    $scope.locations = data;
                    //console.log("vragen data is binnen");
                    //console.log(data);
                });

        }

        $scope.delete_elemets_on_edit_page_vragen = function ($id, $index, $tabele) {
            console.log("deleted varagen click with following parameters ==>", $id, $index);
            var data = {
                _method: "POST",
            };
            $http.post(root + "/edit/" + $tabele + "/" + $id + "/delete/api", data).success(function (data) {
                if (data != "error") {
                    $scope.alle_vragen.splice($index, 1);

                }
                console.log(data);
            });
        }

        $scope.edit_project = function (tabel, id, veldnaam, content, token) {
            var data = {
                rij_naam: veldnaam,
                invul_veld: content,
                _method: "PUT",
                _token: token
            };
            console.log("edit gegevens voor dat ze verzonden worden: ", data);
            $http.post(root + "/" + tabel + "/" + id, data).success(function (data, status) {

                console.log("edit gegevens na dat ze verzonden worden: ", data);
                //$scope.project = data;
                console.log("validation of input from server", data);
                $scope.server_controle_input_veld = "";
                $scope.server_controle_input_veld_succes = "";
                $scope.server_controle_veld__id = data.id;
                if (data.$errors) {
                    $scope.server_controle_input_veld = data.rij_naam;
                    $scope.server_controle_fout = data.$errors.invul_veld;
                    console.log("error messeg afte validation =", $scope.server_controle_fout);
                    console.log("validatiion er gien iets fout");
                }
                if (data.$succes) {

                    $scope.server_controle_input_veld_succes = data.rij_naam;
                    $scope.server_controller_error = data.$succes;
                    console.log("validatiion alles is goed opgeslagen");
                }
            });


        };

        $scope.toon_fout_melding = function ($tabele, $id) {
            if ($scope.server_controle_input_veld == $tabele && $scope.server_controle_veld__id == $id) {
                console.log("toon fout melding van de angepaste veld met id van ", $scope.server_controle_veld__id);
                return true;
            }
        }
        $scope.toon_succes_melding = function ($tabele, $id) {
            console.log("toon succes meldin =" , $scope.server_controle_input_veld_succes , $tabele , $scope.server_controle_veld__id, $id);
            if ($scope.server_controle_input_veld_succes == $tabele && $scope.server_controle_veld__id == $id) {
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

        $scope.delete_elemets_on_edit_page_fotos = function ($id, $index, $tabele) {
            console.log("deleted click with following parameters ==>", $id, $index);

            var data = {
                _method: "POST",
            };
            $http.post(root + "/edit/" + $tabele + "/" + $id + "/delete/api", data).success(function (data) {
                if (data != "error") {
                    $scope.show_fotos.splice($index, 1);
                }

                console.log(data);
            });
        }

        $scope.initializetion_foto = function (id) {
            console.log("fotos  zijn geintializeerd");
            $scope.project_id = id;
            console.log($scope.project_id);

            //haal alle informatie ui fotos database
            $http.get(root + "/fotos/" + $scope.project_id + "/edit/api")
                .success(function (data) {
                    $scope.show_fotos = data;
                    //console.log("project data is binnen");
                    console.log("overzicht van alle fotos = ", $scope.show_fotos);
                });


        }

        $scope.uploadFiles = function (files, errFiles) {
            $scope.files = files;
            $scope.errFiles_fase = errFiles;
            console.log("debug error files upload van fotos: ", $scope.errFiles_fase);
            $scope.errorMsg = " ";
            angular.forEach(files, function (file) {

                if ($scope.errFiles_fase.length == 0) {
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
                            $scope.errorMsg = "Oeps, er ging iets verkeerd";
                            //$scope.errorMsg = response.status + ': ' + response.data;
                        }
                    }, function (evt) {
                        file.progress = Math.min(100, parseInt(100.0 *
                            evt.loaded / evt.total));
                    });
                }
            });
        }
    }]);


    app.controller('add_fase_and_filleController', ['$scope', 'Upload', '$timeout', '$http', function ($scope, Upload, $timeout, $http) {

        $scope.fase_choice = [];

        $scope.delete_elemets_on_edit_page_fase = function ($id, $index, $tabele) {
            console.log("deleted varagen click with following parameters ==>", $id, $index);
            var data = {
                _method: "POST",
            };
            $http.post(root + "/edit/" + $tabele + "/" + $id + "/delete/api", data).success(function (data) {
                if (data != "error") {
                    $scope.show_fases.splice($index, 1);
                }
                console.log(data);
            });
        }

        $scope.fase_update = function ($index, $fase_id) {
            //$scope.fase_choice=event.target.value;
            //console.log( $scope.fase_choice);

            console.log("update fase =", $scope.fase_choice[$index]);

            var data = {
                rij_naam: "fases",
                invul_veld: $scope.fase_choice[$index],
                _method: "PUT"
            };
            $http.post(root + "/fases/" + $fase_id, data).success(function (data, status) {
                //$scope.project = data;
                console.log("validation of input from server", data);
                $scope.fases_server_controle_input_veld = "";
                $scope.fases_server_controle_input_veld_succes = "";
                $scope.fases_server_controle_veld__id = data.id;
                if (data.$errors) {
                    $scope.fases_server_controle_input_veld = data.rij_naam;
                    $scope.fases_server_controle_fout = data.$errors.invul_veld;
                    console.log("validatiion er gien iets fout --- in api cal -- fase --> type fase");
                }
                if (data.$succes) {
                    $scope.fases_server_controle_input_veld_succes = data.rij_naam;
                    $scope.fases_server_controller_error = data.$succes;
                    console.log("validatiion alles is goed opgeslagen--- in api call -- fase --> type fase");
                }
            });
        }

        $scope.type_fase_saved = function ($tabele, $id) {
            //console.log("validation of fase type ==> " ,$scope.fases_server_controle_input_veld_succes, $tabele,$scope.fases_server_controle_veld__id, $id);
            if ($scope.fases_server_controle_input_veld_succes == $tabele && $scope.fases_server_controle_veld__id == $id) {
                //console.log("er is een overeencomst in fase type ")
                return true;
            }
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
                project_id: $scope.project_id,
                _method: "post",
            };
            $http.post(root + "/fase/add_fase/api", data).success(function (data) {
                //$scope.project = data;
                $scope.show_fases.push(data);
                console.log("dases toevoegen zie latste index = ", $scope.show_fases);
            });
        }

        $scope.get_fase_id = function ($fase_id) {
            console.log("id van fase pictuur", $fase_id);
            $scope.fase_id = $fase_id;
        }

        $scope.uploadFiles = function (files, errFiles, $fase_id, $index) {

            console.log("error files bij file upload", errFiles);
            //$scope.files = files;
            $scope.errFiles = errFiles;

            $scope.errorMsg = " ";
            if ($scope.errFiles.length == 0) {
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
                                $scope.errorMsg = response.data.error;
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
                                    if (data.$errors) {
                                        $scope.server_controle_input_veld = data.rij_naam;
                                        $scope.server_controle_fout = data.$errors.invul_veld;
                                        // console.log("error messeg afte validation =" ,$scope.server_controle_fout);
                                        //console.log("validatiion er gien iets fout --- in api cal -- fase");
                                    }
                                    if (data.$succes) {
                                        console.log("src voor verandering = ", $scope.show_fases[$scope.fase_id].fases_picture);
                                        console.log("src voor verandering ", data.fases_picture);
                                        $scope.show_fases[$index].fases_picture = data.fases_picture + '?decache=' + Math.random();
                                        ;
                                        console.log("after update of img src wy gate = ", $scope.show_fases[$scope.fase_id].project_picture);
                                        console.log("index van de fase is ", $index, $scope.show_fases[$index])

                                        $scope.server_controle_input_veld_succes = data.rij_naam;
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
                            $scope.errorMsg = "Oeps, er ging iets verkeerd";
                            //$scope.errorMsg = response.status + ': ' + response.data;
                        }
                    }, function (evt) {
                        file.progress = Math.min(100, parseInt(100.0 *
                            evt.loaded / evt.total));
                    });
                });
            }
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