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
	
	<link rel="stylesheet" href="{{Request::root()}}/css/base.css">
    <link rel="stylesheet" href="{{Request::root()}}/css/bootstrap-datepicker3.min.css">
	
	<script src="{{Request::root()}}/javascript_main"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<script  type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
	<script src="{{Request::root()}}/js/ng_file_upload/ng-file-upload-shim.min.js"></script>
	<script src="{{Request::root()}}/js/ng_file_upload/ng-file-upload.min.js"></script>
	<script src="{{Request::root()}}/js/edit.js"></script>
	<script src="{{Request::root()}}/js/base.js"></script>
	<script src="{{Request::root()}}/js/script.js"></script>
    <script src="{{Request::root()}}/js/bootstrap-datepicker.min.js"></script>
    <script src="{{Request::root()}}/js/bootstrap-datepicker.nl-BE.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCrmTkGoBzp--pRgO5vRXIsbXPrk3VMp_w&libraries=places" type="text/javascript"></script>

	
	@yield('header')
	
</head>
<body>
	
	
	<nav class="navbar navbar-default" role="navigation">
		
			<div class="navbar-header">
				<a class="navbar-brand" href="{{Request::root()}}/" title="home">
				
					<img src="{{Request::root()}}/svg/A_logo_485_RGB_POS.png" alt="logo"/>
					
				</a>
				
			</div>
			<div class="navbar-search">
			
				<form>
					<input class="textbox" type="text" value="zoeken"></input>
					<a href="" title="zoeken">
						<i class="fa fa-search" aria-hidden="true"></i>
					
					</a>
					

				</form>
				
			</div> <!-- END DIV NAVBAR-SEARCH -->
			<div class="collapse navbar-collapse navbar-ex1-collapse pull-right">
				<ul class="nav navbar-nav">
				
					<li>
						<a href="#" title="log in">
							<i class="fa fa-user" aria-hidden="true"></i>
						</a>
					</li>
				
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
		
			@yield('map')
		

		
		
			@yield('homeContent')
		
		
		
		
		
			@yield('editContent')
	
		
		
		
		
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