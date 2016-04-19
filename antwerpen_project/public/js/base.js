$(document).ready(function () {
	$(".toegevoegde_vragen_header").hide();
	$vraag_nummer = 1;


	$("<div class='vragen_opbouw'></div>").appendTo($('.vragen_content'));
	$htmlDiv_vraag_aanmaken = $(".vragen_opbouw");
	$("#selected_vraag").change(function () {



		$type_vraag = $("#selected_vraag option:selected").text();

		$label_info = "Vul vraag in";


		$htmlDiv_vraag_aanmaken.empty();


		$('<input type="hidden" name="vraag[' + $vraag_nummer + '][type_vraag][]" type="text" id="vraag" class="form-control " value="' + $type_vraag + '">').appendTo($htmlDiv_vraag_aanmaken);
		$basic_question = $('<label for="vraag[' + $vraag_nummer + '][vraag][]" class="control-label ">Vul vraag in:</label><input name="vraag[' + $vraag_nummer + '][vraag][]" type="text" id="vraag" class="form-control  vragen">').appendTo($htmlDiv_vraag_aanmaken);

		switch ($type_vraag) {
		case "open vragen":
			$basic_question;
			$("<p>gebruiker krijgt mogelijkheid om vragen schriftelijk te beantwoorden</p>").appendTo($htmlDiv_vraag_aanmaken);
			break;
		case "meerkeuzevragen":
			$basic_question;
			$("<p>gebruiker krijgt meerdere selectie mogelijkheden</p>").appendTo($htmlDiv_vraag_aanmaken);
			$("<div class='col-md-offset-1 mogelijk_antwoord'></div>").appendTo($htmlDiv_vraag_aanmaken);


			for (var i = 1; i < 5; i++) {
				$('<label for="vraag[' + $vraag_nummer + '][antwoord][]" class="control-label ">antwoord mogelijkheid ' + i + ':</label>').appendTo($(".vragen_content .mogelijk_antwoord"))
				$('<input name="vraag[' + $vraag_nummer + '][antwoord][]" type="text"  class="form-control ">').appendTo($(".vragen_content .mogelijk_antwoord"));
			}
			break;
		case "Gesloten vragen":
			$basic_question;
			$("<p>gebruiker krijgt alleen mogelijkheid om ja of nee te antwoorden</p>").appendTo($htmlDiv_vraag_aanmaken);
			break;
		case "Suggestieve vragen":
			$basic_question;
			$("<p>gebruiker krijgt alleen mogelijkheid alleen om gegevenen mogelijkheden te antworden</p>").appendTo($htmlDiv_vraag_aanmaken);
			$("<div class='col-md-offset-1 mogelijk_antwoord'></div>").appendTo($htmlDiv_vraag_aanmaken);

			for (var i = 1; i < 3; i++) {
				$('<label for="vraag[' + $vraag_nummer + '][antwoord][]" class="control-label ">antwoord mogelijkheid ' + i + ':</label>').appendTo($(".vragen_content .mogelijk_antwoord"))
				$('<input name="vraag[' + $vraag_nummer + '][antwoord][]" type="text"  class="form-control ">').appendTo($(".vragen_content.vragen_content .mogelijk_antwoord"));
			}



			break;
		default:
			$htmlDiv_vraag_aanmaken.empty();
		}


	});


	console.log($("#myselect option:selected").text());


	$("#voeg_vraag_toe").click(function () {


		$('.vragen_content *').filter(':input').each(function (value, data) {
			$content = $(this).val();
			if ($content == "") {
				$(this).addClass("invalid");
			} else {
				$(this).removeClass("invalid");
			}
		});

		if ($("#selected_vraag option:selected").text() != "kies een soort vraag...") {

			if (!$("input").hasClass("invalid")) {
				$("#vragen_string").empty();
				$(".toegevoegde_vragen_header").show();

				$htmlDiv_vraag_aanmaken.clone().appendTo("#toegevoegde_vragen");

				$("#toegevoegde_vragen .vragen_opbouw").hide();

				$htmlDiv_vraag_aanmaken.empty();

				$vraag_nummer++;


				$('#selected_vraag option[selected="selected"]').each(
					function () {
						$(this).removeAttr('selected');
					}
				);
				$("#selected_vraag option:first").attr('selected', 'selected');


				$("#toegevoegde_vragen .vragen").each(function (index, data) {
					$("<div class='vragen_div_id_"+index +"'><p class='col-md-offset-1'>" + $(this).val() + "<a href='#'><i id_input='" + index + "' class='pull-right delete'>verwijder</i></a></p></div>").appendTo($("#vragen_string"));
					console.log("index van eeste each"+index);
				});



			}
			console.log($("#toegevoegde_vragen .vragen"));
		}

		$(".delete").click(function (event) {
			event.preventDefault();
			
			$index = $(this).attr('id_input');
			console.log($index);
			$("#toegevoegde_vragen .vragen:eq("+$index+")").parent().hide().remove();
			$(".vragen_div_id_"+$index+"").hide().remove();
			
			
		});
	});




});