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
	<h4 class="">Geef locatie van project in</h4>
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
	
	<div class="form-group">
	<label for="vraag_type" class="col-md-12">Kiez een soort vraag:</label>

	<select  class="form-control" name="size"><option selected="selected" value="">kies een soort vraag...</option><option value="open_vragen">open vragen</option><option value="meerkeuzevragen">meerkeuzevragen</option><option value="Gesloten_vragen">Gesloten vragen</option><option value="Suggestieve_vragen">Suggestieve vragen</option></select>

	<div><strong>hier moet via javascript mogelijkheid geven om meerdere vragen in te vullen </strong></div>
	<button type="button" class="btn btn-primary" id="voeg_vraag_toe">Voeg vraag toe</button>
	</div>
	
	
	<div id="voeg_niew_fase">
	<h4>Voeg fase in</h4>
	<div class="form-group">
		<!--titel van project-->
		<label for="titel_fase_1" class="control-label ">Titel van project:</label>
		<input name="titel_fase_1" type="text" id="titel" class=" form-control">
	</div>
	<!--beschrijving van project-->
	<div class="form-group">
		<label for="beschrijving_fase_1" class="control-label ">Beschrijving:</label>
		<textarea name="beschrijving_fase_1" class="form-control" rows="3"></textarea>
	</div>
	<!--fotos selecteren-->
	<div class="form-group">
	<label for="image_fase_1" class="control-label ">Selecter fotos:</label>
	<input name="image_fase_1" type="file" class="">
	</div>
		<button type="button" class="btn btn-primary" id="voeg_fase_toe">Voeg fase toe</button>
	</div>
	
	<div class="form-group">
	<div class="pull-right">
		<input type="submit" value="toevoegen aan database " class="btn btn-success">
	</div>
	</div>

	{{ Form::close() }}
</div>
@stop