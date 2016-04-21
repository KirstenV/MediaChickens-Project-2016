<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
	
	<!--<link rel="stylesheet" href="css/base.css"> -->
	
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js">
	</script>
	
	<script src="{{Request::root()}}/js/base.js"></script>
	@yield('header')
</head>
<body>
	
	
	<nav class="navbar navbar-default" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="http://localhost/school/antwerpen_project_2016/MediaChickens-Project-2016/antwerpen_project/public">HOME</a>
			</div>
			<div class="collapse navbar-collapse navbar-ex1-collapse pull-right">
				<ul class="nav navbar-nav">
					<li class="">
						<a href="#">log in</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<nav class="navbar navbar-inverse nav_bar_margin_top" role="navigation">
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
		<div class="col-md-4">
			<img src="http://i.stack.imgur.com/yEshb.gif" width="600px" height="400px">
		</div>
		<div class="col-md-4">
			@yield('content')
		</div>
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