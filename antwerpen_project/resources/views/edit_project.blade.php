@extends('layout') @section('content')
<div ng-controller="edit_projectController" ng-init="initializetion({{$id}})">

<div id="add_project"></div>

	<h1>edit project</h1>
	<div class="alle_content">
		<div class='project titel' data-update_status='init' data-titel='titel' data-tabel='projecten' data-id='{{$id}}' contenteditable='true'>@{{project.titel}}</div>
		<div class='project beschrijving ' data-update_status='init' data-titel='beschrijving' data-tabel='projecten' data-id='{{$id}}' contenteditable='true'>@{{project.beschrijving}}</div>
		<div class='project begin_datum ' data-update_status='init' data-titel='begin_datum' data-tabel='projecten' data-id='{{$id}}' contenteditable='true'>@{{project.begin_datum}}</div>
		<div class='project eind_datum ' data-update_status='init' data-titel='eind_datum' data-tabel='projecten' data-id='{{$id}}' contenteditable='true'>@{{project.eind_datum}}</div>

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

</div>
<script>
	$(document).ready(function () {

		$(".project").on("focusout", function (event) {
			console.log("focus out");
			var token = $("input[name='_token']").val();
			var row_name = $(this).attr("data-titel");
			var row_content = $(this).text();
			var tabel = $(this).attr("data-tabel");
			var row_id = $(this).attr("data-id");
			angular.element(document.get)
			angular.element(document.getElementById('add_project')).scope().edit_project(tabel,row_id, row_name, row_content, token);
			//UpdateProjecten(tabel, row_name, row_content, token);
		});


		/*
		console.log("ready!");





		//project edit vragen

		$.ajax({
			url: root+"/vragen/{{$id}}/edit/api",
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
			url: root+"/project/{{$id}}/edit/api",
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
					url:root+"/" + tabele + "/" + id,
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

*/
	});
</script>

@stop