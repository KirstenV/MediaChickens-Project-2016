@extends('layout') @section('content')
<h1>Hier kommen categorien van projecten</h1>


<div class="alle_projecten">
	@foreach ($projecten as $project)

	<h1><i>{{$project->id}}</i> <a href="{{  url('project/{$project->id}/view') }}">{{$project->titel}}</a> <a href="project/{{$project->id}}/edit">edit</a> <a href="project/{{$project->id}}/delete">delet</a></h1> @endforeach
</div>

<h4 class="nieuw_project" contenteditable='true'>Pas mij aan om nieuw project aan te maken</h4> {{ Form::open(array('url' => 'project_toevoegen/add','files' => true))}} {{ Form::close() }}
<script>
	$(document).ready(function () {
		console.log("ready!");


		$(".nieuw_project").click(function () {
			$(this).text("");
			$()

		})

		$(".nieuw_project").on("focusout", function (event) {
			var content = $(this).text();
			var admin   = 1;
			UpdateProjecten("projecten", "titel", content,admin);
			console.log();
			$(this).text("Pas mij aan om nieuw project aan te maken");
		});

		$('.nieuw_project').keypress(function (e) {
			if (e.which == 13) {
				$(this).blur();
			}
		});

		function UpdateProjecten(tabele, veldnaam, content, admin) {
			var token = $("input[name='_token']").val();
			$.ajax({
					method: "POST",
					url: "http://localhost/school/antwerpen_project_2016/MediaChickens-Project-2016/antwerpen_project/public/" + tabele + "/api/add",
					data: {
						row_name: veldnaam,
						row_content: content,
						admin: admin,
						_method: "PUT",
						_token: token
						
					}
				})
				.done(function (data) {
					console.log(data);
				});
		}

	});
</script>
@stop