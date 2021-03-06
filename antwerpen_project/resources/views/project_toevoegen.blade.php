@extends('layout') @section('content')
<h1>Make nieuw project aan</h1>

<div class="col-md-11">


	{{ Form::open(array('url' => 'project_toevoegen/add','files' => true))}}
	<div class="form-group">
		<!--titel van project-->
		<label for="titel" class="control-label ">Titel van project:</label>
		<input name="titel" type="text" id="titel" class=" form-control">
	</div>
	<!--beschrijving van project-->
	<div class="form-group">
		<label for="beschrijving" class="control-label ">Beschrijving:</label>
		<textarea name="notes" class="form-control" rows="3"></textarea>
	</div>
	<!--fotos selecteren-->
	<div class="form-group">
		<label for="image" class="control-label ">Selecter fotos:</label>
		<input multiple="multiple" name="poject_images[]" type="file" class="">
	</div>


	<!--locatie toevoegen-->
	<div>
		<h4 class="margin_top_form_question">Geef locatie van project in</h4>
		<div class="form-group">
			<label for="straat" class="control-label">Straat:</label>
			<input name="straat" type="text" id="straat" class="col-md-11 form-control">
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<label for="postcode" class="control-label">Postcode:</label>
				<input name="postcode" type="text" id="postcode" class=" form-control">
			</div>
			<div class="col-md-6">
				<label for="huisnummer" class="control-label">Huisnummer:</label>
				<input name="huisnummer" type="text" id="huisnummer" class=" form-control">
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<label for="latitude" class="control-label">Lengtegraad:</label>
				<input name="latitude" type="text" id="latitude" class=" form-control">
			</div>
			<div class="col-md-6">
				<label for="longitude" class="control-label">Breedtegraad:</label>
				<input name="latitude" type="text" id="latitude" class=" form-control">
			</div>
		</div>
	</div>

	<div class="">
		<h4 class="margin_top_form_question">Voeg vragen toe</h4>
		<div class="form-group ">
			<label for="vraag_type" class="">Kies een soort vraag:</label>
			<select id="selected_vraag" class="form-control" name="vraag_categorie">
				<option selected="selected" value="">kies een soort vraag...</option>
				<option value="open_vragen">open vragen</option>
				<option value="meerkeuzevragen">meerkeuzevragen</option>
				<option value="Gesloten_vragen">Gesloten vragen</option>
				<option value="Suggestieve_vragen">Suggestieve vragen</option>
			</select>
			<div class="col-md-12 vragen_content"> </div>



			<div id="toegevoegde_vragen">
				<h4 class="toegevoegde_vragen_header">Toegevoegde vragen</h4>
				<div id="vragen_string"></div>
			</div>
		</div>
	</div>


	<div id="voeg_niew_fase">
		<h4 class="margin_top_form_question">Voeg fase toe</h4>



	</div>
	<div class="alle_fases">
		<h4 class="alle_fasen">Alle fasen</h4>
	</div>



	<div class="form-group">
		<div class="pull-right">
			<input type="submit" value="toevoegen_aan_database " class="btn btn-success">
		</div>
	</div>

	{{ Form::close() }}
</div>
@stop