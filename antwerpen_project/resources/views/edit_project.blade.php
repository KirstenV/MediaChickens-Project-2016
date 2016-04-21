@extends('layout') @section('content')


<h1>edit project</h1>
<div class="alle_content">
	<div class='project titel' data-update_status='init' data-titel='titel' data-tabel='projecten' data-id='{{$id}}' contenteditable='true'  ></div>
	<div class='project beschrijving' data-update_status='init' data-titel='beschrijving' data-tabel='projecten' data-id='{{$id}}' contenteditable='true'></div>

	{{ Form::open(array('url' => 'project_toevoegen/add','files' => true))}} {{ Form::close() }}

	<div class="alle_vragen ">
		<div class="vragen_overzicht">
		</div>
		<div class="vraag_toevoegen">
			<button class="vraag_toevoegen_button">Voeg vraag toe</button>
		</div>
	</div>
	<div class="alle_fases">
	</div>

</div>


<script>
	$(document).ready(function () {
		console.log("ready!");





		//project edit vragen

		$.ajax({
			url: "http://localhost/school/antwerpen_project_2016/MediaChickens-Project-2016/antwerpen_project/public/vragen/{{$id}}/edit/api",
			success: function (data) {
				$.each(data, function (key, val) {
					$.each(val, function (index, value) {
						vragen_DataToDiv(index, value);
					})
					action_focusout("vragen", (key+1));
				})
				
			}
		});

		function vragen_DataToDiv(row_name, row_content) {
			$('<div class="vragen ' + row_name + '" data-update_status="init" data-titel="' + row_name + '" data-tabel="vragen" data-id="" contenteditable="true"">').text(row_content).appendTo($('.vragen_overzicht'));
		}









		//project edite titel

		$.ajax({
			url: "http://localhost/school/antwerpen_project_2016/MediaChickens-Project-2016/antwerpen_project/public/project/{{$id}}/edit/api",
			success: function (data) {
				//console.log(data);
				$.each(data, function (key, val) {
					DataToDiv(key, val);
				});
				//$("<div class='project titel' data-update_status='init' data-titel='titel' contenteditable='true'>" + data.titel + "</div>").appendTo(".alle_content");
				//console.log(data);
				//register triggers 

				action_focusout("project",{{$id}});
			}
		});




		function action_focusout(class_name,id) {
			$("." + class_name).on("focusout", function (event) {
				console.log("focus out");
				var row_name = $(this).attr("data-titel");
				var row_content = $(this).text();
				var tabel = $(this).attr("data-tabel");
				console.log(row_name, row_content);
				UpdateProjecten(tabel, row_name, row_content,id);
			});
		}


		function DataToDiv(row_name, row_content) {
			$('.' + row_name).text(row_content);
		}

		function UpdateProjecten(tabele, veldnaam, content, id) {
			var token = $("input[name='_token']").val();
			console.log(token);
			$.ajax({
					method: "POST",
					url: "http://localhost/school/antwerpen_project_2016/MediaChickens-Project-2016/antwerpen_project/public/" + tabele + "/" + id,
					data: {
						row_name: veldnaam,
						row_content: content,
						_method: "PUT",
						_token: token
					}
				})
				.done(function (data) {
					console.log(data);
					$('.' + veldnaam).attr('data-update_status', data);
				});
		}


	});
</script>

@stop