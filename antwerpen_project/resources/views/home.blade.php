@extends('layout') @section('content')
<div ng-controller="projectController">

	<h1><i>@{{$index}}</i><a>@{{project.titel}}</a> </h1>
	<div></div>


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
	load();
</script>
@stop

@section('map')
    <script type="text/javascript">
	
    //<![CDATA[
	
    var customIcons = {
      restaurant: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png',
        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      },
      bar: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png',
        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      }
    };
    function load() {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(51.21945, 4.40246),
        zoom: 14,
        mapTypeId: 'roadmap'
      });
      var infoWindow = new google.maps.InfoWindow;
      // Change this depending on the name of your PHP file
	  
	  
	  $.ajax({url: root+"/kaart/api/get_locations", success: function(data){
        
		data.unshift("null");
		console.log(data);
		for(var i=1; i<data.length; i++){
			
			
			console.log(i);
			var point = new google.maps.LatLng(
              parseFloat(data[i]["position_latitude"]),
              parseFloat(data[i]["position_longitude"]));
        
         	var marker = new google.maps.Marker({
            	map: map,
            	position: point
          	});
			
			var locatie_id = data[i]["id"];
			//console.log(locatie_id);
			//var j = i+1;
			
			//console.log(j);
			$.ajax({url: root+"/kaart/" + locatie_id + "/api/get_locations", success: function(data2){
			
			
			console.log(data2);
			console.log(data2[0]["pivot"]["locatie_id"]);
			if(locatie_id == data2[0]["pivot"]["locatie_id"]){
				
				console.log("ik ben binnen");
				console.log(data2[0]["titel"]);
				var html = data2[0]["titel"];
				
				var infowindow = new google.maps.InfoWindow;
				bindInfoWindow(marker, map, infowindow, html);
				
			}
			
			}});
			
			
		  	

			
		}
    }});
      
    }
    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'mouseover', function() {
	  	infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
	  google.maps.event.addListener(marker, 'mouseout', function() {
        infoWindow.close();
      });
    }
    

  </script>
  
	<div id="map-container">
	    <div id="map"></div>
	</div>
@stop