<!DOCTYPE html>
<html lang="en" ng-app="antwerpen_project">

<head>
    <meta charset="utf-8">
    <title>
    </title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{Request::root()}}/css/google-maps.css">
    <link rel="stylesheet" href="{{Request::root()}}/css/base.css">
    <link rel="stylesheet" href="{{Request::root()}}/css/bootstrap-datepicker3.min.css">
    <link rel="stylesheet" href="{{Request::root()}}/css/star-rating.css">


    <!--lodash is nodig om google maps te configureren-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/lodash/4.12.0/lodash.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
    <script src="{{Request::root()}}/js/angular-simple-logger.js"></script>
    <script src="{{Request::root()}}/js/angular-google-maps.js"></script>


    <script src="{{Request::root()}}/javascript_main"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>


    <script src="{{Request::root()}}/js/star-rating.js"></script>
    <script src="{{Request::root()}}/js/ng_file_upload/ng-file-upload-shim.min.js"></script>
    <script src="{{Request::root()}}/js/ng_file_upload/ng-file-upload.min.js"></script>
    <script src="{{Request::root()}}/js/edit.js"></script>
    <script src="{{Request::root()}}/js/base.js"></script>
    <script src="{{Request::root()}}/js/script.js"></script>
    <script src="{{Request::root()}}/js/bootstrap-datepicker.min.js"></script>
    <script src="{{Request::root()}}/js/bootstrap-datepicker.nl-BE.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCrmTkGoBzp--pRgO5vRXIsbXPrk3VMp_w&libraries=places&language=nl&region=BE" type="text/javascript"></script>
    <!-- <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>-->
    <!--<script>
        angular.module("app").constant("CSRF_TOKEN",{csrf_token: '<?php echo csrf_token();?>'})
        angular.module("app").constant()
    </script>-->

    @yield('header')


</head>

<body ng-controller="GoogleMapsController">


    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{Request::root()}}/auth/login">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Log in</h4>
                    </div>

                    <div class="modal-body">

                        <div class="modal-body-center">

                            {!! csrf_field() !!}

                            <div>
                                <label>Email</label>
                                <br>
                                <input class="form-control" type="email" name="email" value="{{ old('email') }}">
                            </div>
                            <br>
                            <div>
                                <label>Wachtwoord</label>
                                <br>
                                <input class="form-control" type="password" name="password" id="password">
                            </div>
                            <br>
                            <div>
                                <label>
                                    <input type="checkbox" name="remember"> Onthoud mij</label>
                            </div>


                            <br>
                            <br>


                        </div>


                        <div id="error-messages">

                            @foreach ($errors->all() as $error)
                            <li class="title_red error-message"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{ $error }}</li>

                            @if(isset($message)) {{$message}} @endif @endforeach @if ($errors->all() || isset($message))
                            <script>
                                $('#loginModal').modal('show');
                            </script>
                            @endif

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Annuleer</button>
                        <button id="btn-sign-in" name="submit" type="submit" class="btn btn-primary">Log in</button>

                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" ng-controller="LoginController as login_ctrl">

        <form name="formData" method="POST" ng-submit="submit_login()">
            <div class="modal-dialog" role="document" ng-init="intialization_csrt_token()">
                <div class="modal-content">


                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 ng-hide="register_succes" class="modal-title" id="myModalLabel">Registreer</h4>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body-center">

                            <div ng-show="register_succes">
                                <h3>succesvol geregistreerd</h3>

                            </div>

                            <div ng-hide="register_succes">
                                <!--action="{{Request::root()}}/auth/register"-->
                                {!! csrf_field() !!}

                                <div>
                                    <label>Naam</label>
                                    <br>
                                    <input class="form-control" type="text" name="name" value="" ng-model="login_data.name">
                                </div>
                                <br>
                                <div>
                                    <label>Email</label>
                                    <br>
                                    <input class="form-control" type="email" name="email" value="" ng-model="login_data.email">
                                </div>
                                <br>
                                <div>
                                    <label>Wachtwoord</label>
                                    <br>
                                    <input class="form-control" type="password" name="password" ng-model="login_data.password">
                                </div>
                                <br>
                                <div>
                                    <label>Bevestig wachtwoord</label>
                                    <br>
                                    <input class="form-control" type="password" name="password_confirmation" ng-model="login_data.password_confirmation">
                                </div>

                            </div>
                        </div>

                        <div id="error-messages" ng-show="register_errors">

                            <li ng-repeat="error in register_errors" class="title_red error-message"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> @{{ error[0] }}</li>

                        </div>

                    </div>
                    <div class="modal-footer" ng-hide="register_succes">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Annuleer</button>
                        <button id="btn-register" name="submit" type="submit" class="btn btn-primary">Registreer</button>

                    </div>


                </div>
            </div>
        </form>
    </div>










    <div class="modal fade" id="usersModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" ng-controller="LoginController as login_ctrl">

        <form name="formData" method="POST" ng-submit="submit_login()">
            <div id="usersModal-dialog" class="modal-dialog" role="document" ng-init="intialization_csrt_token()">
                <div class="modal-content">


                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Gebruikersbeheer</h4>
                    </div>
                    <div class="modal-body">


                        <!------------------------------start User management-->

                        @if(Auth::check())
                            @if(Auth::user()->is_adm)
                        <div ng-controller="UsersController" class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">

                                    <input placeholder="Zoeken" class="form-control" ng-model="searchText">
                                    <small id="users-search-hint-small">Typ "1" om te zoeken naar admins, "0" om te zoeken naar gebruikers</small>
                                </div>
                            </div>



                            <table id="users-table" class="table tablesorter">
                                <thead>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Naam</th>
                                        <th>Email</th>
                                        <th>Admin?</th>
                                        <th>Verwijder</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-left" ng-repeat="user in all_users | filter:searchText" ng-class-odd="'odd-users'">
                                        <td>@{{ $index }}</td>
                                        <td>@{{ user.name }}</td>
                                        <td>@{{ user.email }}</td>
                                        <td id="pointer" ng-class="chek_for_admin(@{{ user.is_adm }},'fa fa-toggle-on','fa fa-toggle-off')" class="text-center" ng-click="update_user( user.id,user.is_adm,$index)"></td>
                                        <td id="pointer" class="col-md-2 fa fa-trash text-center" ng-click="update_user( user.id,'delete',$index)"></td>
                                    </tr>
                                </tbody>
                            </table>
@endif
                            @endif



                            <div ng-show="error_users_management">@{{ error_users_management }}</div>

                        </div>


                        <!------------------------------end User management-->


                        <div id="error-messages" ng-show="register_errors">

                            <li ng-repeat="error in register_errors" class="title_red error-message"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> @{{ error[0] }}</li>

                        </div>

                    </div>
                    <div class="modal-footer" ng-hide="register_succes">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>

                    </div>


                </div>
            </div>
        </form>
    </div>










    <nav class="navbar navbar-default col-xs-12 col-md-12 navbar-fixed-top" role="navigation">

        <div class="navbar-header col-md-6 col-xs-11 h100 no-padding">
            <a class="navbar-brand" href="{{Request::root()}}/" title="home">

                <img src="{{Request::root()}}/img/A_logo_485_RGB_POS.png" alt="logo" />

            </a>

        </div>


        <div class="h100 col-md-6 col-xs-1 no-padding">
            <ul id="nav-right" class="pull-right vert-center h100 hidden-xs">



                @if(Auth::check())


                <!--                <li>
                    Welkom, {{Auth::user()->name}}!
                </li>-->
                @if (Auth::user()->is_adm)
                
                <li>
                    <a href="{{Request::root()}}/export/xls" title="Verzamel inspraak">
                        <i class="fa fa-download" aria-hidden="true"></i>


                    </a>
                </li>
                
                
                <li>
                    <a href="" title="Gebruikersbeheer" data-toggle="modal" data-target="#usersModal">
                        <i class="fa fa-users" aria-hidden="true"></i>

                    </a>
                </li>
                @endif
                <li>
                    <a href="{{Request::root()}}/auth/logout" title="log uit">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                    </a>
                </li>
                @else






                <li class="" title="registreer" data-toggle="modal" data-target="#registerModal">
                    <a href="">
                        <i class=" fa fa-user-plus" aria-hidden="true"></i>
                    </a>

                </li>

                <li class="" title="login" data-toggle="modal" data-target="#loginModal">
                    <a href="">
                        <i class=" fa fa-sign-in" aria-hidden="true"></i>
                    </a>

                </li>
                @endif
            </ul>
        </div>

    </nav>


    <!--	<nav class="navbar navbar-inverse nav_bar_margin_top" role="navigation">
		<div class="container">
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav">
					<li class="">
						<a href="{{  url('project_toevoegen') }}">Project toevoegen</a>
					</li>
					<li>
						<a href="#">wijzig project </a>
					</li>
					<li>
						<a href="#">verwijder project</a>
					</li>
					<li>
						<a href="#">gegevens verzamelen </a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
-->




    @yield('map') @yield('homeContent') @yield('editContent')


    <div class="col-md-8" style="display: none;">
        <h3>
        Span 4
    </h3>
        <p>
            Content
        </p>
    </div>

    @yield('footer')

</body>

</html>