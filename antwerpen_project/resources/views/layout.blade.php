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

    <script src="{{Request::root()}}/javascript_main"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <!--lodash is nodig om google maps te configureren-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/lodash/4.12.0/lodash.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
    <script src="{{Request::root()}}/js/angular-simple-logger.js"></script>
    <script src="{{Request::root()}}/js/angular-google-maps.js"></script>


    <script src="{{Request::root()}}/js/ng_file_upload/ng-file-upload-shim.min.js"></script>
    <script src="{{Request::root()}}/js/ng_file_upload/ng-file-upload.min.js"></script>
    <script src="{{Request::root()}}/js/edit.js"></script>
    <script src="{{Request::root()}}/js/base.js"></script>
    <script src="{{Request::root()}}/js/script.js"></script>
    <script src="{{Request::root()}}/js/bootstrap-datepicker.min.js"></script>
    <script src="{{Request::root()}}/js/bootstrap-datepicker.nl-BE.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCrmTkGoBzp--pRgO5vRXIsbXPrk3VMp_w&libraries=places"
            type="text/javascript"></script>
    <!-- <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>-->
    <!--<script>
        angular.module("app").constant("CSRF_TOKEN",{csrf_token: '<?php echo csrf_token();?>'})
        angular.module("app").constant()
    </script>-->

    @yield('header')


</head>

<body>



<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{Request::root()}}/auth/login">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Log in</h4>
                </div>

                <div class="modal-body">

                    <div class="modal-body-center">

                        {!! csrf_field() !!}

                        <div>
                            <label>Email</label>
                            <br>
                            <input class="textbox" type="email" name="email" value="{{ old('email') }}">
                        </div>
                        <br>
                        <div>
                            <label>Wachtwoord</label>
                            <br>
                            <input class="textbox" type="password" name="password" id="password">
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
                        {{var_dump($errors)}}
                        @foreach ($errors->all() as $error)
                            <li class="title_red error-message"><i class="fa fa-exclamation-triangle"
                                                                   aria-hidden="true"></i> {{ $error }}</li>
                        @endforeach @if ($errors->all())
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


<div class="modal fade" id="registerModal" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" ng-controller="LoginController as login_ctrl"  >
    <div class="modal-dialog" role="document" ng-init="intialization_csrt_token()">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Registreer</h4>
            </div>
            <div class="modal-body">
                <div class="modal-body-center">
                    <form name="formData" method="POST"   ng-submit="submit_login()" ><!--action="{{Request::root()}}/auth/register"-->
                        {!! csrf_field() !!}

                        <div>
                            <label>Naam</label>
                            <br>
                            <input class="textbox" type="text" name="name" value="" ng-model="login_data.name">
                        </div>
                        <br>
                        <div>
                            <label>Email</label>
                            <br>
                            <input class="textbox" type="email" name="email" value="" ng-model="login_data.email">
                        </div>
                        <br>
                        <div>
                            <label>Wachtwoord</label>
                            <br>
                            <input class="textbox" type="password" name="password" ng-model="login_data.password">
                        </div>
                        <br>
                        <div style="margin-bottom:25px">
                            <label>Bevestig wachtwoord</label>
                            <br>
                            <input class="textbox" type="password" name="password_confirmation"  ng-model="login_data.password_confirmation">
                        </div>


                </div>

                <div id="error-messages">
                    @foreach ($errors->all() as $error)
                        <li class="title_red error-message"><i class="fa fa-exclamation-triangle"
                                                               aria-hidden="true"></i> {{ $error }}</li>
                    @endforeach @if ($errors->all())
                        <script>
                            $('#registerModal').modal('show');
                        </script>
                    @endif
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuleer</button>
                <button id="btn-register" name="submit" type="submit" class="btn btn-primary">Registreer</button>

            </div>


        </div>
    </div>
    </form>
</div>


<nav class="navbar navbar-default col-xs-12 col-md-12 navbar-fixed-top" role="navigation">

    <div class="navbar-header col-md-6 col-xs-11 h100">
        <a class="navbar-brand" href="{{Request::root()}}/" title="home">

            <img src="{{Request::root()}}/img/A_logo_485_RGB_POS.png" alt="logo"/>

        </a>

    </div>


    <div class="h100 col-md-6 col-xs-1">
        <ul id="nav-right" class="pull-right vert-center h100 hidden-xs">


            <li class="search" title="zoek">
                <a href="#" class="">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </a>
            </li>
            @if(Auth::check())


                    <!--                <li>
                    Welkom, {{Auth::user()->name}}!
                </li>-->
            <li>
                <a href="{{Request::root()}}/login" title="mijn account">
                    <i class="fa fa-user" aria-hidden="true"></i>

                </a>
            </li>
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