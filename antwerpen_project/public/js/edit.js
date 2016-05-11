$(document).ready(function () {

    $(document).on("focusout", ".project", function () {

        console.log("focus out");
        var token = $("input[name='_token']").val();
        var row_name = $(this).attr("data-titel");
        var row_content = $(this).text();
        var tabel = $(this).attr("data-tabel");
        var row_id = $(this).attr("data-id");
        angular.element(document.get)

        angular.element(document.getElementById('edit_project')).scope().edit_project(tabel, row_id, row_name, row_content, token);
        //UpdateProjecten(tabel, row_name, row_content, token);

    });

    $(document).on("change", ".datum", function () {

        console.log("focus out");
        var token = $("input[name='_token']").val();
        var row_name = $(this).attr("data-titel");
        var row_content = $(this).val();
        var tabel = $(this).attr("data-tabel");
        var row_id = $(this).attr("data-id");
        angular.element(document.get)

        angular.element(document.getElementById('edit_project')).scope().edit_project(tabel, row_id, row_name, row_content, token);
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