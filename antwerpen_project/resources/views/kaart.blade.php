<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <script src="http://maps.google.com/maps/api/js?sensor=false"
            type="text/javascript"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
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
	  
	  
	  $.ajax({url: "http://project.local/antwerpen_project/public/kaart/api/get_locations", success: function(data){
        
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
			$.ajax({url: "http://project.local/antwerpen_project/public/kaart/" + locatie_id + "/api/get_locations", success: function(data2){
			
			
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
    
    function doNothing() {}
    //]]>
  </script>
  </head>

  <body onload="load()">
    <div id="map" style="width: 50%; bottom: 0%; top:15%; left:0%; position: absolute"></div>
  </body>
</html>