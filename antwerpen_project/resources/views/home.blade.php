@extends('layout') 


@section('content')
<div id="projectContainer" ng-controller="projectController">

	<div id="editable">
		<h4 id="add_project" class="nieuw_project" contenteditable='true'>Pas mij aan om een nieuw project aan te maken</h4>
	</div> <!-- END DIV EDITABLE -->
	
	


	<div class="alle_projecten">
		<div class="project">


			

			

		</div> <!-- END DIV PROJECT -->
		{{ Form::open(array('url' => 'projecten/add'))}}
{{ Form::close() }}
	</div> <!-- END DIV ALLE_PROJECTEN -->




 <div class="panel-group" id="accordion">
  <div class="panel panel-default">
    
<!--	
	<a class="accordion-toggle" data-toggle="collapse"  data-parent="#accordion" href="#collapse1">
		<div class="panel-heading">
	      <h4 class="panel-title">
	        
	        Thema 1 <i class="fa fa-angle-double-down" aria-hidden="true"></i>

	      </h4>
	    </div> 
	</a>
-->
    <div id="collapse1" class="panel-collapse collapse in">
      <div class="panel-body" ng-repeat="project in projects">
	  
	  	<h1 id="div-inline"><a href="project/@{{project.id}}/view">@{{project.titel}}</a>  </h1>
		<div id="div-inline" class="edit_home_page"><a href="project/@{{project.id}}/edit"title="pas project aan"><i class="fa fa-pencil" aria-hidden="true"></i></a></div>
		<div id="div-inline" class="delete_home_page"><a href="project/@{{project.id}}/delete" title="verwijder project"><i class="fa fa-trash" aria-hidden="true"></i></a></div>
<!--		<br><small><div id="div-inline"  class="begien_datum_home_page"><strong>Begindatum: </strong>@{{project.begin_datum}}</a></div></small> -->
<!--		<small><div id="div-inline"  class="eind_datum_home_page"><strong>Einddatum: </strong>@{{project.eind_datum}}</a></div></small> -->
<!--		<br><div id="div-inline"  class="begien_datum_home_page"><strong>Beschrijving: </strong>@{{project.beschrijving}}</a></div> -->
	  	<hr>
	  </div> <!-- END DIV -->
    </div>
  </div>
  
  <div class="panel panel-default">
 <!--
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse2">
		<div class="panel-heading">
	      <h4 class="panel-title">
	        
	        Thema 2 <i class="fa fa-angle-double-right" aria-hidden="true"></i>
	      </h4>
	    </div>
	</a>
    <div id="collapse2" class="panel-collapse collapse">
      <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
      sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
      minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
      commodo consequat.</div>
    </div>
  </div>
  <div class="panel panel-default">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse3">
		<div class="panel-heading">
	      <h4 class="panel-title">
	        
	        Thema 3 <i class="fa fa-angle-double-right" aria-hidden="true"></i>
	      </h4>
	    </div>
	</a>
    <div id="collapse3" class="panel-collapse collapse">
      <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
      sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
      minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
      commodo consequat.</div>
    </div>
  </div>
-->
</div> 


	

</div>

@stop

@section('map')

  
	<div id="map-container">
	    <div id="map"></div>
	</div>
@stop