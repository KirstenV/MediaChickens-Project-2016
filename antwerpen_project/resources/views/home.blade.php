@extends('layout') @section('content')
<div ng-controller="projectController">


	<div class="alle_projecten">
		<div class="project" ng-repeat="project in projects">
			<h1><i>@{{$index}}</i> <a href="project/@{{project.id}}/view">@{{project.titel}}</a>  </h1>
			<div class="edit_home_page"><a href="project/@{{project.id}}/edit">aanpasen</a></div>
			<div class="delete_home_page"><a href="project/@{{project.id}}/delete">verwijderen</a></div>
			<div class="begien_datum_home_page">@{{project.begin_datum}}</a>
			</div>
			<div class="eind_datum_home_page">@{{project.eind_datum}}</a>
			</div>
		</div>
		{{ Form::open(array('url' => 'projecten/add'))}}
{{ Form::close() }}
	</div>


	<h4 id="add_project" class="nieuw_project" contenteditable='true'>Pas mij aan om nieuw project aan te maken</h4>

</div>
<script>
	$(document).ready(function () {
		console.log("ready!");

		$(".nieuw_project").click(function () {
			$(this).text("");
		})

		$(".nieuw_project").on("focusout", function (event) {
			var content = $(this).text();
			if (content != "") {
				var token = $("input[name='_token']").val();
				angular.element(document.getElementById('add_project')).scope().add_project(content,token,1);
			}
			$(this).text("Pas mij aan om nieuw project aan te maken");
		});

		$('.nieuw_project').keypress(function (e) {
			if (e.which == 13) {
				$(this).blur();
			}
		});
	});
</script>
@stop