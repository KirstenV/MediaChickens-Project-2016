


@extends('layout') 
@section('header')

@stop


@section('content')

	<style>
		.thumb {
			width: 24px;
			height: 24px;
			float: none;
			position: relative;
			top: 7px;
		}
	</style>

<div ng-controller="edit_projectController" ng-init="initializetion({{$id}})">

	<div id="add_project" class="container">
		<div class="row">
			<h1>edit project</h1>
			<div class="alle_content">
				<div class="col-md-2">Titel</div>
				<div class='project titel col-md-10' data-update_status='init' data-titel='titel' data-tabel='projecten' data-id='{{$id}}' contenteditable='true'>@{{project.titel}}</div>
				<div class="col-md-2">Titel</div>
				<div class='project beschrijving col-md-10' data-update_status='init' data-titel='beschrijving' data-tabel='projecten' data-id='{{$id}}' contenteditable='true'>@{{project.beschrijving}}</div>
				<div class="col-md-2">Titel</div>
				<div class='project begin_datum col-md-10' data-update_status='init' data-titel='begin_datum' data-tabel='projecten' data-id='{{$id}}' contenteditable='true'>@{{project.begin_datum}}</div>
				<div class="col-md-2">Titel</div>
				<div class='project eind_datum col-md-10' data-update_status='init' data-titel='eind_datum' data-tabel='projecten' data-id='{{$id}}' contenteditable='true'>@{{project.eind_datum}}</div>
			</div>

				{{ Form::open(array('url' => 'project_toevoegen/add','files' => true))}} {{ Form::close() }}

			<div >
				<div class="alle_fotos " class="row" ng-controller="file_uplodController" ng-init="initializetion_foto({{$id}})">

					<div class="show_fotos" ng-repeat="foto in show_fotos">
						<img ng-src="{{Request::root()}}/img/project/@{{ foto.project_picture }}" alt="@{{ foto.project_picture }}">

					</div><!--end of foto galerij-->
					<div class="add_fotos"  >

						<h4>Upload on file select</h4>

						<button ngf-select="uploadFiles($files, $invalidFiles)" multiple
								accept="image/*" ngf-max-height="1000" ngf-accept="'image/*'" ngf-max-size="1MB">
							Select Files</button>
						<br><br>
						Files:
						<ul>
							<li ng-repeat="f in errFiles" style="font:smaller">@{{f.name}} @{{f.$error}} @{{f.$errorParam}}
							</li>
						</ul>
						@{{errorMsg}}
					</div>
				</div><!--end of file_upload Conroller-->
			</div>

			<div class="row">
				<div class="alle_fases">
				</div>
			</div>

			<div class="row">


				<div class="col-md-12">
					<div class="btn-group " role="group" aria-label="...">
						<div class="btn-group " role="group">
							<button type="button" class="btn btn-default" ng-click="add_question('open vragen')">open vragen</button>
						</div>
						<div class="btn-group" role="group">
							<button type="button" class="btn btn-default" ng-click="add_question('meerkeuzevragen')">meerkeuzevragen</button>
						</div>
						<div class="btn-group" role="group">
							<button type="button" class="btn btn-default" ng-click="add_question('Gesloten vragen')">Gesloten vragen</button>
						</div>
					</div>
				</div>

				<div class="col-md-12">
					<div class="col-md-4" ng-repeat="vraag in alle_vragen">
						<div ng-show="vraag.choices == 'open vragen'">
							<div>@{{ $index }}</div>
							<h4>@{{vraag.choices}}</h4>
							<h5 class='vraag project titel col-md-12' data-update_status='init' data-titel='vraag' data-tabel='Vragen' data-id='@{{vraag.id}}' contenteditable='true'>@{{vraag.vraag}}</h5>
						</div>
						<div ng-show="vraag.choices == 'meerkeuzevragen'">
							<div>@{{ $index }}</div>
							<h4>@{{vraag.choices}}</h4>
							<h5 class='vraag project titel col-md-12' data-update_status='init' data-titel='vraag' data-tabel='Vragen' data-id='@{{vraag.id}}' contenteditable='true'>@{{vraag.vraag}}</h5>
							<h5 class='vraag project titel col-md-12' data-update_status='init' data-titel='mogelijke_antwoorden_1' data-tabel='Vragen' data-id='@{{vraag.id}}' contenteditable='true'> @{{vraag.mogelijke_antwoorden_1}}</h5>
							<h5 class='vraag project titel col-md-12' data-update_status='init' data-titel='mogelijke_antwoorden_2' data-tabel='Vragen' data-id='@{{vraag.id}}' contenteditable='true'> @{{vraag.mogelijke_antwoorden_2}}</h5>
							<h5 class='vraag project titel col-md-12' data-update_status='init' data-titel='mogelijke_antwoorden_3' data-tabel='Vragen' data-id='@{{vraag.id}}' contenteditable='true'> @{{vraag.mogelijke_antwoorden_3}}</h5>
							<h5 class='vraag project titel col-md-12' data-update_status='init' data-titel='mogelijke_antwoorden_4' data-tabel='Vragen' data-id='@{{vraag.id}}' contenteditable='true'> @{{vraag.mogelijke_antwoorden_4}}</h5>
						</div>
						<div ng-show="vraag.choices == 'Gesloten vragen'">
							<div>@{{ $index }}</div>
							<h4>@{{vraag.choices}}</h4>
							<h5 class='vraag project titel col-md-12' data-update_status='init' data-titel='vraag' data-tabel='Vragen' data-id='@{{vraag.id}}' contenteditable='true'>@{{vraag.vraag}}</h5>
							<h5 class='vraag project titel col-md-12' data-update_status='init' data-titel='mogelijke_antwoorden_1' data-tabel='Vragen' data-id='@{{vraag.id}}' contenteditable='true'><i class="glyphicon glyphicon-unchecked"></i> @{{vraag.mogelijke_antwoorden_1}}</h5>
							<h5 class='vraag project titel col-md-12' data-update_status='init' data-titel='mogelijke_antwoorden_2' data-tabel='Vragen' data-id='@{{vraag.id}}' contenteditable='true'><i class="glyphicon glyphicon-unchecked"></i> @{{vraag.mogelijke_antwoorden_2}}</h5>
						</div>
					</div>
				</div><!--end of vragen div-->
			</div>
		</div>
	</div>
</div>
<script>

</script>

@stop