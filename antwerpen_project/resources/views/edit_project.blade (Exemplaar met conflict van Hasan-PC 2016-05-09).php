@extends('layout') @section('header') @stop @section('editContent')


    <div id="map-container-editpage">
        <div id="map"></div>
    </div>



    <div id="editContainer">

        <div ng-controller="edit_projectController" ng-init="initializetion({{$id}})">

            <div id="edit_project" class="container">
                <div class="row">

                    <div id="edit_header">
                        <h1 id="div-inline">Project wijzigen</h1>
                        <div id="div-inline" class="edit_header_icon_pencil"><i class="fa fa-pencil-square"
                                                                                aria-hidden="true"></i></div>
                    </div>

                    <div id="edit_content">

                        <div class="alle_content">
                            <div class="row">
                                <h4 class="col-md-12 title_red">Titel</h4>
                                <div class="col-md-12">

                                    <p ng-class="{'invalid': toon_fout_melding('titel')}" class="col-md-11 project titel" data-toggle="tooltip" ng-model="inhoud" data-placement="left"
                                       title="Klik om aan te passen" data-update_status='init' data-titel='titel'
                                       data-tabel='projecten' data-id='{{$id}}'
                                       contenteditable='true'>@{{project.titel}}</p>
                                    <div class="col-md-1 pull-right glyphicon glyphicon-saved "
                                         ng-show="toon_succes_melding('titel')"></div>
                                    <div class="col-md-11 invalid" ng-show="toon_fout_melding('titel')">@{{ server_controle_fout[0] }}</div>
                                </div>
                            </div><!--einde row titel-->
                            <hr>
                            <div id="edit_foto">
                                <div class="alle_fotos " class="row" ng-controller="file_uplodController"
                                     ng-init="initializetion_foto({{$id}})">


                                    <div class="row">
                                        <h4 class="col-md-12 title_red">Foto's</h4>
                                        <div class="show_fotos" ng-repeat="foto in show_fotos">


                                            <div id="thumbs" class="col-xs-6 col-md-3">

                                                <a href="" id="foto-delete" data-toggle="tooltip" data-placement="top"
                                                   title="Verwijder foto"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                <a href="#" class="thumbnail">
                                                    <img ng-src="{{Request::root()}}/img/project/small_@{{ foto.project_picture }}"
                                                         alt="@{{ foto.project_picture }}"/>
                                                </a>
                                            </div>


                                        </div>
                                        <!--end of foto galerij-->

                                        <div class="edit_foto_add_button col-md-3 col-xs-6"
                                             ngf-select="uploadFiles($files, $invalidFiles)" multiple accept="image/*"
                                             ngf-max-height="1000" ngf-accept="'image/*'" ngf-max-size="1MB">
                                            <div class="glyphicon glyphicon-plus col-md-12"></div>
                                            <small class="edit_foto_add_button_small">Selecteer foto</small>
                                            <small class="edit_foto_add_button_small_maxsize">Max 1024x768 - 1MB</small>
                                        </div>

                                        <br>
                                        <br>
                                        <ul>
                                            <li ng-repeat="f in errFiles" style="font:smaller">
                                                @{{f.name}} @{{f.$error}} @{{f.$errorParam}}
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- DIV END ROW -->


                                    <!--@{{errorMsg}}-->

                                </div>
                                <!--end of file_upload Conroller-->
                            </div>
                            <hr>

                            <div class="row">
                            <h4 class=" col-md-12 title_red">Beschrijving</h4>
                            <p ng-class="{'invalid': toon_fout_melding('beschrijving')}" data-toggle="tooltip" data-placement="left" title="Klik om aan te passen"
                               class="col-md-11 project beschrijving" data-update_status='init' data-titel='beschrijving'
                               data-tabel='projecten' data-id='{{$id}}'
                               contenteditable='true'>@{{project.beschrijving}}</p>
                            <div class="col-md-1 pull-right glyphicon glyphicon-saved "
                                 ng-show="toon_succes_melding('beschrijving')"></div>
                            <div class="col-md-11 invalid" ng-show="toon_fout_melding('beschrijving')">@{{ server_controle_fout[0] }}</div>
                        </div>
                        </div><!--einde diw beschrijving-->
                            <hr>

                            <h4 class="title_red">Begin -en einddatum</h4>
                            <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon">van</span>
                                <input type="text" class="input-sm form-control" name="start"/>
                                <span class="input-group-addon">tot</span>
                                <input type="text" class="input-sm form-control" name="end"/>
                            </div>


                        </div>

                        <hr>

                        <div id="locatie">
                            <h4 class="title_red">Locatie</h4>
                            <input id="autocomplete" type="text" class="textbox"
                                   placeholder="Typ een adres of klik op de kaart">
                            <br>
                            <p id="map-locatie"></p>

                        </div>


                        {{ Form::open(array('url' => 'project_toevoegen/add','files' => true))}} {{ Form::close() }}


                        <hr>

                        <div class="row">
                            <div class="alle_fases">
                            </div>
                        </div>

                        <div class="row">


                            <div class="col-md-12">
                                <div class="btn-group " role="group" aria-label="...">
                                    <div class="btn-group " role="group">
                                        <button type="button" class="btn btn-default"
                                                ng-click="add_question('open vragen')">open vragen
                                        </button>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-default"
                                                ng-click="add_question('meerkeuzevragen')">meerkeuzevragen
                                        </button>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-default"
                                                ng-click="add_question('Gesloten vragen')">Gesloten vragen
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-4" ng-repeat="vraag in alle_vragen">
                                    <div ng-show="vraag.choices == 'open vragen'">
                                        <div>@{{ $index }}</div>
                                        <h4 class="title_red">@{{vraag.choices}}</h4>
                                        <h5 class='vraag project titel col-md-12' data-update_status='init'
                                            data-titel='vraag' data-tabel='Vragen' data-id='@{{vraag.id}}'
                                            contenteditable='true'>@{{vraag.vraag}}</h5>
                                    </div>
                                    <div ng-show="vraag.choices == 'meerkeuzevragen'">
                                        <div>@{{ $index }}</div>
                                        <h4 class="title_red">@{{vraag.choices}}</h4>
                                        <h5 class='vraag project titel col-md-12' data-update_status='init'
                                            data-titel='vraag' data-tabel='Vragen' data-id='@{{vraag.id}}'
                                            contenteditable='true'>@{{vraag.vraag}}</h5>
                                        <h5 class='vraag project titel col-md-12' data-update_status='init'
                                            data-titel='mogelijke_antwoorden_1' data-tabel='Vragen'
                                            data-id='@{{vraag.id}}' contenteditable='true'><i
                                                    class="fa fa-square-o"></i> @{{vraag.mogelijke_antwoorden_1}}</h5>
                                        <h5 class='vraag project titel col-md-12' data-update_status='init'
                                            data-titel='mogelijke_antwoorden_2' data-tabel='Vragen'
                                            data-id='@{{vraag.id}}' contenteditable='true'><i
                                                    class="fa fa-square-o"></i> @{{vraag.mogelijke_antwoorden_2}}</h5>
                                        <h5 class='vraag project titel col-md-12' data-update_status='init'
                                            data-titel='mogelijke_antwoorden_3' data-tabel='Vragen'
                                            data-id='@{{vraag.id}}' contenteditable='true'><i
                                                    class="fa fa-square-o"></i> @{{vraag.mogelijke_antwoorden_3}}</h5>
                                        <h5 class='vraag project titel col-md-12' data-update_status='init'
                                            data-titel='mogelijke_antwoorden_4' data-tabel='Vragen'
                                            data-id='@{{vraag.id}}' contenteditable='true'><i
                                                    class="fa fa-square-o"></i> @{{vraag.mogelijke_antwoorden_4}}</h5>
                                    </div>
                                    <div ng-show="vraag.choices == 'Gesloten vragen'">
                                        <div>@{{ $index }}</div>
                                        <h4 class="title_red">@{{vraag.choices}}</h4>
                                        <h5 class='vraag project titel col-md-12' data-update_status='init'
                                            data-titel='vraag' data-tabel='Vragen' data-id='@{{vraag.id}}'
                                            contenteditable='true'>@{{vraag.vraag}}</h5>
                                        <h5 class='vraag project titel col-md-12' data-update_status='init'
                                            data-titel='mogelijke_antwoorden_1' data-tabel='Vragen'
                                            data-id='@{{vraag.id}}' contenteditable='true'><i
                                                    class="fa fa-circle-thin"></i> @{{vraag.mogelijke_antwoorden_1}}
                                        </h5>
                                        <h5 class='vraag project titel col-md-12' data-update_status='init'
                                            data-titel='mogelijke_antwoorden_2' data-tabel='Vragen'
                                            data-id='@{{vraag.id}}' contenteditable='true'><i
                                                    class="fa fa-circle-thin"></i> @{{vraag.mogelijke_antwoorden_2}}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <!--end of vragen div-->
                        </div>
                    </div>
                    <!-- END DIV EDIT_CONTENT -->
                </div>
            </div>
        </div>

    </div>
@stop