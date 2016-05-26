(function () {
    var app = angular.module('antwerpen_project', ['ngFileUpload', 'uiGmapgoogle-maps']);


    app.directive('googleplace', function () {
        return {
            require: 'ngModel',
            link: function (scope, element, attrs, model) {
                var options = {
                    types: [],
                    componentRestrictions: {}
                };
                scope.gPlace = new google.maps.places.Autocomplete(element[0], options);

                google.maps.event.addListener(scope.gPlace, 'place_changed', function () {
                    scope.$apply(function () {
                        model.$setViewValue(element.val());
                    });
                });
            }
        };
    });


    app.directive('myEnter', function () {
        return function (scope, element, attrs) {
            element.bind("keydown keypress", function (event) {
                if (event.which === 13) {
                    scope.$apply(function () {
                        scope.$eval(attrs.myEnter);
                    });

                    event.preventDefault();
                }
            });
        };
    });

    app.controller("UsersController", ['$http', '$scope', function ($http, $scope) {
        console.log("--user management-- --initialize controller--");
        $scope.error_users_management;
        $scope.all_users;

        $http({
            method: 'GET',
            url: root + '/gebruikers/api'
        }).then(function successCallback(response) {
            console.log("--user management-- reseav data is: ", response);
            if (response.data.$error) {
                $scope.error_users_management = response.data.$error;
            } else {
                $scope.all_users = response.data;
            }

        }, function errorCallback(response) {
            $scope.error_users_management = "Fout met server refresh je venster aub";
        });

        $scope.chek_for_admin = function (is_adm, class1, class2) {
            if (is_adm) {
                return class1;
            } else {
                return class2;
            }
        }
        $scope.update_user = function (user_id, action, index) {
            if (index != -1) {
                $http({
                    method: 'POST',
                    url: root + '/gebruikers/api',
                    data: {
                        id: user_id,
                        action: action,
                    }
                }).then(function successCallback(response) {
                    console.log("--user management-- reseav data is: ", response);
                    if (response.data.$error) {
                        $scope.error_users_management = response.data.$error;
                    } else {
                        if (response.data.succes) {

                            $http({
                                method: 'GET',
                                url: root + '/gebruikers/api'
                            }).then(function successCallback(response) {
                                console.log("--user management-- reseav data is: ", response);
                                if (response.data.$error) {
                                    $scope.error_users_management = response.data.$error;
                                } else {
                                    $scope.all_users = response.data;
                                }

                            }, function errorCallback(response) {
                                $scope.error_users_management = "Fout met server refresh je venster aub";
                            });
                        }
                    }
                }, function errorCallback(response) {
                    $scope.error_users_management = "Fout met server refresh je venster aub";
                });
            }
        }

    }])


    app.controller('GoogleMapsController', ['$http', '$scope', function ($http, $scope) {


        $scope.map_initializetion = function ($project_id) {
            $scope.project_id = $project_id;

            $scope.locations = [];

            if ($project_id != 0) {
                //-----------------------------------------------------------------------------------------------------------google maps for edit page-------------------------------------------------------------------------------------------//

                $scope.delete_elemets_on_edit_page_locatie = function ($id, $index, $tabele) {
                    console.log("deleted varagen click with following parameters ==>", $id, $index);
                    var data = {
                        _method: "POST",
                    };
                    $http.post(root + "/edit/" + $tabele + "/" + $id + "/delete/api", data).success(function (data) {
                        if (data != "error") {
                            $scope.locations.splice($index, 1);

                        }
                    });
                }

                //goole maps
                function add_location_to_database(lat, lng, adress, project_id) {
                    var data = {
                        lat: lat,
                        lng: lng,
                        address: adress,
                        _method: "POST"
                    };
                    $http.post(root + "/locatie/toevoegen/" + project_id + "/api", data).success(function (data) {
                        //console.log('locaties zijn toegevoegd via google maps controller voor project =', $scope.project_id,data);
                        $scope.locations_errors = "";
                        if (data.$succes) {
                            console.log("--edit-- --api call-- - function- -succes-", data.$location);

                            $scope.locations.push({
                                id: data.$location.id,
                                address: data.$location.straat_naam,
                                location: {
                                    latitude: data.$location.position_latitude,
                                    longitude: data.$location.position_longitude
                                }
                            });
                        } else {
                            if (data.$errors) {
                                $scope.locations_errors = data.$errors;
                            }
                            $scope.locations_errors = "Oeps, er gien iets verkeerd!";

                        }

                    });
                }


                $scope.input_location;
                $scope.add_location_on_enter = function (loc) {
                    console.log("--edit-- --enter key press or mous click-- -> add location:", loc);
                    $scope.locations_errors = "";
                    if (loc != undefined) {


                        $http.get(" https://maps.googleapis.com/maps/api/geocode/json?address=" + loc + "&key=AIzaSyChcI5yCog1780Of_wshHhIZ6yeLrMhkQM")
                            .success(function (data) {


                                if (data.status != "ZERO_RESULTS") {
                                    console.log("--edit-- --ajax-call for lat ngt from address-- get lng lat string", data);
                                    var lat = data.results[0].geometry.location.lat;
                                    var lng = data.results[0].geometry.location.lng;
                                    add_location_to_database(lat, lng, loc, $scope.project_id);
                                } else {
                                    $scope.locations_errors = "Oeps, er gien iets verkeerd!";
                                }


                            });
                    } else {
                        $scope.locations_errors = "Oeps, er gien iets verkeerd!";

                    }
                }

                $scope.map = {
                    center: {latitude: 51.21945, longitude: 4.40246},
                    zoom: 12,
                    marker_events: {
                        mouseover: function (gMarker, eventName, model) {

                            console.log("--edit-- --event -> mousover-- on markers");
                            model.show = true;

                            //$scope.$apply();

                        },
                        mouseout: function (gMarker, eventName, model) {

                            console.log("--edit-- --event -> mouseleave-- on markers");
                            model.show = false;

                            //$scope.$apply();

                        }
                    },
                    events: {
                        click: function (map, eventName, originalEventArgs) {
                            var e = originalEventArgs[0];
                            var lat = e.latLng.lat(), lon = e.latLng.lng();

                            $http.get("https://maps.googleapis.com/maps/api/geocode/json?latlng=" + lat + "," + lon + "&key=AIzaSyChcI5yCog1780Of_wshHhIZ6yeLrMhkQM")
                                .success(function (data) {

                                    console.log("--edit-- --ajax-call-- get locatie string", data.results[0].formatted_address);

                                    add_location_to_database(lat, lon, data.results[0].formatted_address, $project_id);

                                });
                            $scope.$apply();
                        }
                    }
                };
                //initialize for edit page
                $http.get(root + "/locaties/" + $project_id + "/edit/api")
                    .success(function (data) {
                        //$scope.locations = data;

                        for (var i = 0; i < data.length; i++) {
                            //console.log(data[i]);

                            $scope.locations.push({
                                id: data[i].id,
                                address: data[i].straat_naam,
                                location: {
                                    latitude: data[i].position_latitude,
                                    longitude: data[i].position_longitude
                                }
                            });
                        }
                        //console.log("--edit-- -api get all locations-- saved location:",  $scope.locations);
                    });
                //--------------------------------------------------------------------end google maps voor edit pagina------------------------------------------------------------------------------------------------------------------------//
            } else {


                //-------------------------------------------------------------------------------project controller-------------------------------------------------------//
                $scope.project;
                $scope.projects_for_user = [];

                $scope.whatClassIsIt = function ($controll_variabel, $class_1, $class_2) {
                    if ($controll_variabel) {
                        return $class_1;
                    } else {
                        return $class_2;
                    }
                }
                // home page haal alle projecten
                $http.get(root + "/al_projects/api/get")
                    .success(function (data) {
                        $scope.projects = data;
                        //console.log(data);
                        console.log("--home page-- --ajax call-- get projects:", $scope.projects);


                        //loop trou project and controll if they are in date reng
                        for (var i = 0; i < $scope.projects.length; i++) {
                            console.log("--home page-- --loop cotrolle all projects on date--", $scope.projects[i]);

                            var start_date = new Date($scope.projects[i].begin_datum);
                            var end_date = new Date($scope.projects[i].eind_datum);
                            var date_now = new Date();
                            if (start_date != "Invalid Date" && end_date != "Invalid Date") {
                                var sart_time = start_date.getTime();
                                var end_time = end_date.getTime();
                                var current_time = date_now.getTime();
                                if (current_time >= sart_time && current_time <= end_time) {

                                    $scope.projects_for_user.push($scope.projects[i]);

                                    $http.get(root + "/kaart/api/get_locations/" + $scope.projects[i].id)
                                        .success(function (data) {
                                            console.log("--home page-- --ajax call-- get project --> locations --> first foto:", data);

                                            if (data.image.length > 0) {
                                                var image_src = data.image[0].project_picture;
                                                console.log("--home page-- --get img in the marker-- src", image_src);
                                            } else {
                                                var image_src = "antwerpen_logo.png";
                                                console.log("--home page-- --get img in the marker-- src", image_src);
                                            }


                                            for (var i = 0; i < data.locaties.length; i++) {
                                                console.log(data[i]);

                                                $scope.locations.push({
                                                    id: data.locaties[i].id,
                                                    project_id: data.project.id,

                                                    address: data.locaties[i].straat_naam,
                                                    image: image_src,
                                                    titel: data.project.titel.substr(0, 35),
                                                    discription: data.project.beschrijving.substr(0, 100),
                                                    location: {
                                                        latitude: data.locaties[i].position_latitude,
                                                        longitude: data.locaties[i].position_longitude
                                                    }
                                                });
                                            }
                                            // console.log("--edit-- -api get all locations-- saved location:", $scope.locations);
                                        });
                                }

                            }

                            //if($scope.projects[i].begin_datum)
                        }


                    });


                $scope.answer_post_succes="";
                $scope.questions_answer = {};
                $scope.answers_post = function () {

                    /*for(var key in  $scope.questions_answer){
                     for(var index in  $scope.questions_answer[key]){
                     console.log("--home page-- --questions-- $scope.questions_answer",index, $scope.questions_answer[key][index]);
                     }
                     }*/
                    $scope.answer_post_error = "";
                    $http({
                        method: 'POST',
                        url: root + "/question/answer",
                        data: {
                            message: $scope.questions_answer,
                        },
                    }).then(function successCallback(response) {
console.log("--home page-- --aswers feadback-- server answer:0",response.data);
                        if (response.data.succes) {
                            $scope.answer_post_succes = "Dank u voor het invullen van de vragen, uw mening telt";
                           
                        } else {
                            $scope.answer_post_error= "Oeps, er ging iets fout. Kunt u de pagina herstarten en het nog eens proberen aub. "
                        }

                    }, function errorCallback(response) {
                        $scope.answer_post_error = "oeps er ging iets mis, vernieuw de pagina aub."
                    });

                    console.log("--home page-- --question post-- sumit data: ", $scope.questions_answer);
                }





                $scope.show_project_info = function ($id_project) {
                    $scope.$id_project = $id_project;
                    console.log("id van de gelickte project is = ", $id_project);
                    $http.get(root + "/project/" + $id_project + "/api")
                        .success(function (data) {
                            if (data.error) {
                                $scope.project.error = "oeps er ging iets mis, vernieuw de pagina aub."
                            } else {
                                $scope.project = data;
                            }


                            //get all users
                            $http.get(root + "/project/reacttions/3/" + $id_project + "/api")
                                .success(function (data) {
                                    if (data.error) {
                                        $scope.project.error = "oeps er ging iets mis, vernieuw de pagina aub."
                                    } else {
                                        $scope.project.reactions = data;
                                    }

                                    console.log("--home page-- ------------------------------->get special number of rections: ", data);

                                });


                        });
                }
                $scope.review_to_get = 3;

                $scope.get_more_reviews = function () {
                    $scope.review_to_get += 3;
                    $http.get(root + "/project/reacttions/" + $scope.review_to_get + "/" + $scope.$id_project + "/api")
                        .success(function (data) {
                            if (data.error) {
                                $scope.project.error = "oeps er ging iets mis, vernieuw de pagina aub."
                            } else {
                                $scope.project.reactions = data;
                            }
                            console.log("--home page-- --get more review-- limit: ", data);
                            if ($scope.review_to_get > $scope.project.reactions.length) {
                                $scope.get_mor_reviews = true;

                            }

                            console.log("--home page-- ------------------------------->get special number of rections: ", data);

                        });
                }


                $scope.select_rating = function (value) {
                    $scope.selected_rating = value;
                    console.log("--home page-- --function-- --initialize rating-- :", $scope.selected_rating);
                }

                $scope.reaction_post = {};
                $scope.submit_reaction = function (user_id) {
                    if ($scope.selected_rating) {
                        if (!$scope.reaction_post.massage) {
                            $scope.project.post_error = "Tekst invoerveld is verplicht."
                        }
                        $http({
                            method: 'POST',
                            url: root + "/review/message",
                            data: {
                                message: $scope.reaction_post.massage,
                                project_id: $scope.$id_project,
                                user_id: user_id,
                                rating: $scope.selected_rating,

                            },
                        }).then(function successCallback(response) {
                            console.log("--home page-- --post review-- --resiv data", response);
                            if (response.data.error) {
                                $scope.project.post_error = response.data.error;
                            } else {

                                $scope.project.reactions.push(response.data);
                            }
                        }, function errorCallback(response) {
                            $scope.project.post_error = "oeps er ging iets mis, vernieuw de pagina aub."
                        });
                    } else {
                        $scope.project.post_error = "Met hoeveel sterren waardeert u deze project?"
                    }

                    console.log("--home page -- submit form after clieck");
                }


                $scope.delete_review = function (review_id, index) {
                    $http({
                        method: 'POST',
                        url: root + "/review/delete",
                        data: {
                            review_id: review_id,
                        },
                    }).then(function successCallback(response) {

                        if (response.data.succes) {
                            $scope.project.reactions.splice(index, 1);
                            console.log("-home page-- review is verwijder onder id: ", response.data);
                        } else {
                            $scope.project.post_error = response.data.error;

                        }
                    }, function errorCallback(response) {
                        $scope.project.post_error = "oeps er ging iets mis, vernieuw de pagina aub."
                    });
                }

                $scope.show_projects = function () {
                    console.log("Er is gedrukt op het terug keren naar projecten");
                    $scope.project = "";
                }


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


                //--------------------------------------------------------------------google maps for all the rest------------------------------------------------------------------------------------------------------------------------//

                $scope.map = {
                    center: {latitude: 51.21945, longitude: 4.40246},
                    zoom: 12,
                    options:{
                        draggable: false,      icon: root+'/img/google_maps/marker.png',
                    },
                    marker_events: {
                        mouseover: function (gMarker, eventName, model) {

                            console.log("--edit-- --event -> mousover-- on markers");
                            model.show = true;

                            //$scope.$apply();

                        },
                        mouseout: function (gMarker, eventName, model) {

                            console.log("--edit-- --event -> mousover-- on markers");
                            model.show = false;

                            //$scope.$apply();

                        },
                        click: function ($event) {
                            console.log("--home page-- --click event-- marker", $event.model.location)
                            $scope.map.center ={latitude:  $event.model.location.latitude, longitude: $event.model.location.longitude};
                            $scope.map.zoom=15;
                            $scope.show_project_info($event.model.project_id)
                        }
                    }
                };

                //initialize for home page

            }
        }


    }])

    app.controller('LoginController', ['$http', '$scope', function ($http, $scope) {
        $scope.login_data = {}
        console.log("register controller activ")

        $scope.intialization_csrt_token = function () {

            console.log("intialiseren van token");
        }

        $scope.submit_login = function () {
            //console.log("csrf token is:",$scrf_token);
            console.log("form verzonden data is: ", $scope.login_data);
            $scope.register_errors = "";
            var data = {
                name: $scope.login_data.name,
                email: $scope.login_data.email,
                password: $scope.login_data.password,
                password_password_confirmation: $scope.login_data.password_confirmation,
                _method: "POST",
            };

            $http.post(root + "/register", data).success(function (data) {
                console.log("return data from loging api", data);
                if (data.errors) {
                    $scope.register_errors = data.errors;
                }
                if (data.succes) {
                    $scope.register_succes = data.succes;
                }
            });
        }
    }])

    app.controller('projectController', ['$http', "$scope", function ($http, $scope) {


    }]);

    app.controller('edit_projectController', ['$scope', '$http', function ($scope, $http) {
        //console.log("controller is klaar");


        /*$scope.google_maps_controller_error_catsher = function ($error) {
         $scope.locations_errors = $error;
         }*/
        /*$scope.google_maps_controller = function (lat, lng, adress) {
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
         }*/

        /* $scope.delete_elemets_on_edit_page_locatie = function ($id, $index, $tabele) {
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
         }*/

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

            /*  $http.get(root + "/locaties/" + $scope.project_id + "/edit/api")
             .success(function (data) {
             $scope.locations = data;
             //console.log("vragen data is binnen");
             //console.log(data);
             });*/

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
                    //   console.log("validatiion alles is goed opgeslagen");
                }
            });


        };

        $scope.toon_fout_melding = function ($tabele, $id) {
            if ($scope.server_controle_input_veld == $tabele && $scope.server_controle_veld__id == $id) {
                // console.log("toon fout melding van de angepaste veld met id van ", $scope.server_controle_veld__id);
                return true;
            }
        }
        $scope.toon_succes_melding = function ($tabele, $id) {
//            console.log("toon succes meldin =" , $scope.server_controle_input_veld_succes , $tabele , $scope.server_controle_veld__id, $id);
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
                    //console.log("overzicht van alle fotos = ", $scope.show_fotos);
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