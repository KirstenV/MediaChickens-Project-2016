$(document).ready(function () {
    console.log("ready!");


    $(".nieuw_project").click(function () {
        $(this).text("");
    })

    $(".nieuw_project").on("focusout", function (event) {
        var content = $(this).text();
        if (content != "") {
            var token = $("input[name='_token']").val();
            angular.element(document.getElementById('add_project')).scope().add_project(content, token, 1);

            $('#projectContainer').animate({
                scrollTop: $('#accordion').height()
            }, 'slow');
        }
        $(this).text("Nieuw project toevoegen");


    });

    $('.nieuw_project').keypress(function (e) {
        if (e.which == 13) {
            $(this).blur();
        }
    });




    //    var map = new google.maps.Map(document.getElementById("map"), {
    //        center: new google.maps.LatLng(51.21945, 4.40246)
    //        , zoom: 14
    //        , mapTypeId: 'roadmap'
    //    });
    //    var infoWindow = new google.maps.InfoWindow;
    //
    //
    //    $.ajax({
    //        url: root + "/kaart/api/get_locations"
    //        , success: function (data) {
    //
    //            if (data != '') {
    //
    //                data.unshift("null");
    //                console.log(data);
    //                for (var i = 1; i < data.length; i++) {
    //
    //
    //                    console.log(i);
    //                    var point = new google.maps.LatLng(
    //                        parseFloat(data[i]["position_latitude"])
    //                        , parseFloat(data[i]["position_longitude"]));
    //
    //                    var marker = new google.maps.Marker({
    //                        map: map
    //                        , position: point
    //                    });
    //
    //                    var locatie_id = data[i]["id"];
    //                    //console.log(locatie_id);
    //                    //var j = i+1;
    //
    //                    //console.log(j);
    //                    $.ajax({
    //                        url: root + "/kaart/" + locatie_id + "/api/get_locations"
    //                        , success: function (data2) {
    //
    //
    //                            console.log(data2);
    //                            console.log(data2[0]["pivot"]["locatie_id"]);
    //                            if (locatie_id == data2[0]["pivot"]["locatie_id"]) {
    //
    //                                console.log("ik ben binnen");
    //                                console.log(data2[0]["titel"]);
    //                                var html = data2[0]["titel"];
    //
    //                                var infowindow = new google.maps.InfoWindow;
    //                                bindInfoWindow(marker, map, infowindow, html);
    //
    //                            }
    //
    //                        }
    //                    });
    //
    //
    //                }
    //            } else {
    //                console.log("geen locaties");
    //            }
    //        }
    //    });
    //
    //
    //    google.maps.event.addListener(map, 'click', function (event) {
    //
    //
    //        placeMarker(event.latLng);
    //
    //        var lat_lng = event.latLng.lat() + "," + event.latLng.lng();
    //
    //
    //        $.ajax({
    //            url: "https://maps.googleapis.com/maps/api/geocode/json?latlng=" + lat_lng + "&key=AIzaSyChcI5yCog1780Of_wshHhIZ6yeLrMhkQM"
    //            , success: function (data) {
    //
    //                //$("#map-locatie").append('<br>' + data["results"][0]["formatted_address"] + "  " + '<a href="" style="text-decoration:none" title="verwijder"><i class="fa fa-times inline" aria-hidden="true"></i></a>' + "<br>");
    //                if (data["results"][0]["geometry"]["location"] !== undefined) {
    //                    angular.element(document.getElementById('edit_project')).scope().google_maps_controller(event.latLng.lat(), event.latLng.lng(), data["results"][0]["formatted_address"]);
    //                } else {
    //                    angular.element(document.getElementById('edit_project')).scope().google_maps_controller_error_catsher("Oeps, dit adres bestaat niet");
    //                }
    //
    //            }
    //        });
    //
    //    });
    //
    //
    //    // Create the autocomplete object, restricting the search to geographical
    //    // location types.
    //    var autocomplete = new google.maps.places.Autocomplete(
    //        /** @type {!HTMLInputElement} */
    //        (document.getElementById('autocomplete')), {
    //            types: ['geocode']
    //            , componentRestrictions: {
    //                country: 'be'
    //            }
    //        });
    //
    //    // When the user selects an address from the dropdown, populate the address
    //    // fields in the form.
    //    autocomplete.addListener('place_changed', fillInAddress);
    //
    //
    //    function fillInAddress() {
    //        // Get the place details from the autocomplete object.
    //        var place = autocomplete.getPlace();
    //
    //        //$("#map-locatie").append('<br>' + place["formatted_address"] + "  " + '<a href="" style="text-decoration:none" title="verwijder"><i class="fa fa-times inline" aria-hidden="true"></i></a>' + "<br>");
    //
    //        $.ajax({
    //            url: "https://maps.googleapis.com/maps/api/geocode/json?address=" + place["formatted_address"] + "&key=AIzaSyChcI5yCog1780Of_wshHhIZ6yeLrMhkQM"
    //            , success: function (data) {
    //
    //                if (data["results"][0]["geometry"]["location"] !== undefined) {
    //
    //
    //                    var myLat = data["results"][0]["geometry"]["location"]["lat"];
    //                    var myLng = data["results"][0]["geometry"]["location"]["lng"];
    //
    //
    //                    var myLatLng = {
    //                        lat: myLat
    //                        , lng: myLng
    //                    };
    //                    console.log("platsen van de marker gegevens: ", data);
    //                    placeMarker(myLatLng);
    //                    angular.element(document.getElementById('edit_project')).scope().google_maps_controller(myLat, myLng, place["formatted_address"]);
    //                } else {
    //                    angular.element(document.getElementById('edit_project')).scope().google_maps_controller_error_catsher("Oeps, dit adres bestaat niet");
    //                }
    //            }
    //        });
    //
    //    }
    //
    //
    //    function placeMarker(location) {
    //
    //        var marker = new google.maps.Marker({
    //            position: location
    //            , map: map
    //        });
    //
    //    }
    //
    //
    //    $("#autocomplete").on("click", function () {
    //
    //        $(this).val("");
    //
    //    });
    //
    //
    //    function bindInfoWindow(marker, map, infoWindow, html) {
    //        google.maps.event.addListener(marker, 'mouseover', function () {
    //            infoWindow.setContent(html);
    //            infoWindow.open(map, marker);
    //        });
    //        google.maps.event.addListener(marker, 'mouseout', function () {
    //            infoWindow.close();
    //        });
    //    }


    $('#datepicker input').datepicker({
        format: "yyyy-mm-dd"
        , weekStart: 1
        , todayBtn: "linked"
        , clearBtn: true
        , language: "nl-BE"
        , daysOfWeekHighlighted: "0,6"
        , todayHighlight: true
    });

    $('[data-toggle="tooltip"]').tooltip();


    // Fill modal with content from link href
    $(".openModal").on("click", function (e) {
        var link = $(this).data("href");
        $('#myModal').modal("show");
        $('#myModal .modal-content').load(link);

    });


    //    $("div").on("click", "#div-project", function () {
    //
    //        $('#homeContainer').removeClass("col-md-6").addClass("col-md-8").addClass("width-transition");
    //        $('#mapContainer').removeClass("col-md-6").addClass("col-md-4").addClass("width-transition");
    //
    //    });
    //
    //    $("div").on("click", "#project-back", function () {
    //
    //        $('#homeContainer').removeClass("col-md-8").addClass("col-md-6");
    //        $('#mapContainer').removeClass("col-md-4").addClass("col-md-6");
    //
    //    });
    $("#nav-right li").each(function () {

        $(this).on("mouseover", function () {

            $(this).css("background-color", "#DA291C");
            $(this).css("outline", "1px solid #DA291C");
            $(this).find("i").css("color", "white");

        });

        $(this).on("mouseout", function () {
            $(this).css("background-color", "white");
            $(this).css("outline", "none");
            $(this).find("i").css("color", "#DA291C");

        });
    });



    $("#project-back").on("mouseover", function () {

        $(this).css("opacity", "1");
        //        $(this).find("i").css("color", "#DA291C");
        //        $(this).find("div").css("color", "#DA291C");

    });

    $("#project-back").on("mouseout", function () {

        $(this).css("opacity", "0.4");
        //        $(this).find("i").css("color", "#DA291C");
        //        $(this).find("div").css("color", "#DA291C");

    });



    //		$('.collapse').on('shown.bs.collapse', function(){
    //			$(this).parent().find(".fa-angle-double-right").removeClass("fa-angle-double-right").addClass("fa-angle-double-down");
    //		}).on('hidden.bs.collapse', function(){
    //			$(this).parent().find(".fa-angle-double-down").removeClass("fa-angle-double-down").addClass("fa-angle-double-right");
    //		});









    $(document).on("click", '#thumb-pic', function () {

        var img = $(this).find("img").clone();

        $('#main-pic').html(img);

    });

    if ($("#thumb-container").scrollTop() === 0) {

        $('#thumb-scroll-up').hide();

    }



    $("#thumb-container").scroll(function () {
        var y = $(this).scrollTop();
        var x = $(this).innerHeight();
        var z = $(this)[0].scrollHeight;
        if (y > 0) {

            $('#thumb-scroll-up').fadeIn();

        } else {
            $('#thumb-scroll-up').fadeOut();
        }

        console.log($(this).height());
        if (y + x >= z) {
            console.log("helllllllll");
            $('#thumb-scroll-down').fadeOut();
            $('#thumb-scroll-up').fadeIn();

        } else {
            $('#thumb-scroll-down').fadeIn();
        }
    });

    $('#thumb-scroll-down').on("click", function () {


        var y = $("#thumb-container").scrollTop();
        $("#thumb-container").animate({
            scrollTop: y + 200
        }, 200);

    });

    $('#thumb-scroll-up').on("click", function () {


        var y = $("#thumb-container").scrollTop();
        $("#thumb-container").animate({
            scrollTop: y - 200
        }, 200);



    });









    var index = 1;







    $(document).on("click", '#next', function () {
        console.log('hi');

        var index_max = parseInt($("#vraag-totaal").text());


        $("#vraag-container").animate({
            scrollLeft: $("#vraag-container").scrollLeft() + $("#vraag-container").width()
        }, 200);
        if (index < index_max) {
            index++;
        }

        $("#vraag-huidig").html("Vraag " + index + " van " + index_max);
    });

    $(document).on("click", '#previous', function () {
        console.log('hi');

        var index_max = parseInt($("#vraag-totaal").text());


        $("#vraag-container").animate({
            scrollLeft: $("#vraag-container").scrollLeft() - $("#vraag-container").width()
        }, 200);
        if (index != 1) {

            index--;
        }


        $("#vraag-huidig").html("Vraag " + index + " van " + index_max);
    });




    $("#star-rating").on('rating.change', function (event, value, caption) {
        angular.element(document.getElementById('rating')).scope().select_rating(value);


        console.log("--home page-- --rating chenge-- stars given: ", value);
    })

    $('#rating').rating({
        emptyStar: "<i class='fa fa-star-o'></i>"
        , filledStar: "<i class='fa fa-star'></i>"
        , showClear: false
        , showCaption: false
    });







    $(document).on("click", '#thumbs', function () {

        var img = $(this).find("a.thumbnail img").clone();

        $('#edit-foto-big').html(img);
    });





    $("#project-fase").on("click", function () {
        console.log("hello");
        $("#project-fase").toggleClass("open-fase");
        $("#project-fase").toggleClass("closed-fase");

        $("#arrow-box-top i").toggleClass("fa-chevron-left");
        $("#arrow-box-top i").toggleClass("fa-chevron-right");


        $("#project-fase div.arrow-box-cell").each(function () {

            if (!$(this).find("div.arrow-box").hasClass("active")) {

                $(this).show();
                $("#arrow-box-bottom").hide();
            }
        });

    });




    $(document).on("mouseover", "#project-fase div.arrow-box-cell", function () {



        $(".arrow-box-cell .arrow-box-right").removeClass("active");
        $(this).find("div.arrow-box-right").addClass("show");



    });

    $(document).on("mouseout", "#project-fase div.arrow-box-cell", function () {



        $(".arrow-box-cell .arrow-box-right").removeClass("show");


        $("#project-fase div.arrow-box-cell").each(function () {

            if ($(this).find("div.arrow-box").hasClass("active")) {

                $(this).find("div.arrow-box-right").addClass("active");

            } else if ($(this).find("div.arrow-box").hasClass("first")) {

                $(this).find("div.arrow-box-right").addClass("active");
            }


        });




    });


    $("#projectContainer").scroll(function (e) {

        var scrolltop = $(this).scrollTop();
        console.log(scrolltop);
        if (scrolltop > 150) {

            $("#project-titel").removeClass("col-md-8");
            $("#project-titel").addClass("animate-scroll");
            $("#project-titel img").hide();
            e.stopPropagation();
            $("#project-titel-content").hide();
            $("#project-back-text").hide();

            $("#project-fase div.arrow-box-cell").each(function () {

                if (!$(this).find("div.arrow-box").hasClass("active")) {

                    $(this).hide();
                    $("#arrow-box-bottom").show();



                }
            });
            

        } else {

            $("#project-titel").addClass("col-md-8");
            $("#project-titel").removeClass("animate-scroll");
            $("#project-titel img").show();
            

            
            $("#project-titel-content").show();
            
            $("#project-back-text").show();

            $("#project-fase div.arrow-box-cell").each(function () {

                if (!$(this).find("div.arrow-box").hasClass("active")) {

                    $(this).show();
                    $("#arrow-box-bottom").hide();
                }
            });


        }



    });









});