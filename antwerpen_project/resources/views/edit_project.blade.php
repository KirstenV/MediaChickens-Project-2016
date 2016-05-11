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
                                <h4 class="title_red">Titel</h4>
                                <div class="col-md-12">

                                    <p ng-class="{'invalid': toon_fout_melding('titel',project.id)}"
                                       class="col-md-11 project titel" data-toggle="tooltip" ng-model="inhoud"
                                       data-placement="left"
                                       title="Klik om aan te passen" data-update_status='init' data-titel='titel'
                                       data-tabel='projecten' data-id='{{$id}}'
                                       contenteditable='true'>@{{project.titel}}</p>

                                    <div class="col-md-1 pull-right glyphicon glyphicon-saved "
                                         ng-show="toon_succes_melding('titel',project.id)"></div>
                                    <div class="col-md-11 invalid"
                                         ng-show="toon_fout_melding('titel',project.id)">@{{ server_controle_fout[0] }}</div>
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
                                                   title="Verwijder foto"><i class="fa fa-times" aria-hidden="true" ng-click="delete_elemets_on_edit_page_fotos(foto.id,$index,'foto','show_fotos')"></i></a>
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
                                <h4 class="title_red">Beschrijving</h4>
                                <p ng-class="{'invalid': toon_fout_melding('beschrijving',project.id)}"
                                   data-toggle="tooltip" data-placement="left" title="Klik om aan te passen"
                                   class="col-md-11 project beschrijving" data-update_status='init'
                                   data-titel='beschrijving'
                                   data-tabel='projecten' data-id='{{$id}}'
                                   contenteditable='true'>@{{project.beschrijving}}</p>
                                <div class="col-md-1 pull-right glyphicon glyphicon-saved "
                                     ng-show="toon_succes_melding('beschrijving',project.id)"></div>
                                <div class="col-md-11 invalid"
                                     ng-show="toon_fout_melding('beschrijving',project.id)">@{{ server_controle_fout[0] }}</div>
                            </div>
                        </div><!--einde diw beschrijving-->
                        <hr>

                        <h4 class="title_red">Begin -en einddatum</h4>
                        <div id="datepicker">
                            
                            <span class="input-group-addon inline">van</span>
                                <input type="text" class="inline">
                            <span class="input-group-addon inline">tot</span>
                                <input type="text" class="inline">



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


                                <a href="" id="vragen-delete" data-toggle="tooltip" data-placement="top"
                                   title="Verwijder foto"><i class="fa fa-times" aria-hidden="true" ng-click="delete_elemets_on_edit_page_vragen(vraag.id,$index,'vragen')"></i></a>
                                <div>@{{ $index }}</div>
                                <h4 class="title_red">@{{vraag.choices}}</h4>
                                <h5 ng-class="{'invalid': toon_fout_melding('vraag',vraag.id)}" class='vraag project titel col-md-12' data-update_status='init'
                                    data-titel='vraag' data-tabel='Vragen' data-id='@{{vraag.id}}'
                                    contenteditable='true'>@{{vraag.vraag}}</h5>
                                <!--feedback validatie-->
                                <div class="col-md-1 pull-right glyphicon glyphicon-saved "
                                     ng-show="toon_succes_melding('vraag',vraag.id)">
                                </div>
                                <div class="col-md-11 invalid"
                                     ng-show="toon_fout_melding('vraag',vraag.id)">@{{ server_controle_fout[0] }}
                                </div><!--end feedback-->


                                <div ng-show="vraag.choices == 'meerkeuzevragen'">
                                    <h5 ng-class="{'invalid': toon_fout_melding('mogelijke_antwoorden_1',vraag.id)}" class='vraag project titel col-md-12' data-update_status='init'
                                        data-titel='mogelijke_antwoorden_1' data-tabel='Vragen'
                                        data-id='@{{vraag.id}}' contenteditable='true'><i
                                                class="fa fa-square-o"></i> @{{vraag.mogelijke_antwoorden_1}}</h5>
                                    <!--feedback validatie-->
                                    <div class="col-md-1 pull-right glyphicon glyphicon-saved "
                                         ng-show="toon_succes_melding('mogelijke_antwoorden_1',vraag.id)">
                                    </div>
                                    <div class="col-md-11 invalid"
                                         ng-show="toon_fout_melding('mogelijke_antwoorden_1',vraag.id)">@{{ server_controle_fout[0] }}
                                    </div><!--end feedback-->


                                    <h5 ng-class="{'invalid': toon_fout_melding('mogelijke_antwoorden_2',vraag.id)}" class='vraag project titel col-md-12' data-update_status='init'
                                        data-titel='mogelijke_antwoorden_2' data-tabel='Vragen'
                                        data-id='@{{vraag.id}}' contenteditable='true'><i
                                                class="fa fa-square-o"></i> @{{vraag.mogelijke_antwoorden_2}}</h5>
                                    <!--feedback validatie-->
                                    <div class="col-md-1 pull-right glyphicon glyphicon-saved "
                                         ng-show="toon_succes_melding('mogelijke_antwoorden_2',vraag.id)">
                                    </div>
                                    <div class="col-md-11 invalid"
                                         ng-show="toon_fout_melding('mogelijke_antwoorden_2',vraag.id)">@{{ server_controle_fout[0] }}
                                    </div><!--end feedback-->


                                    <h5 ng-class="{'invalid': toon_fout_melding('mogelijke_antwoorden_3',vraag.id)}" class='vraag project titel col-md-12' data-update_status='init'
                                        data-titel='mogelijke_antwoorden_3' data-tabel='Vragen'
                                        data-id='@{{vraag.id}}' contenteditable='true'><i
                                                class="fa fa-square-o"></i> @{{vraag.mogelijke_antwoorden_3}}</h5>
                                    <!--feedback validatie-->
                                    <div class="col-md-1 pull-right glyphicon glyphicon-saved "
                                         ng-show="toon_succes_melding('mogelijke_antwoorden_3',vraag.id)">
                                    </div>
                                    <div class="col-md-11 invalid"
                                         ng-show="toon_fout_melding('mogelijke_antwoorden_3',vraag.id)">@{{ server_controle_fout[0] }}
                                    </div><!--end feedback-->

                                    <h5 ng-class="{'invalid': toon_fout_melding('mogelijke_antwoorden_4',vraag.id)}" class='vraag project titel col-md-12' data-update_status='init'
                                        data-titel='mogelijke_antwoorden_4' data-tabel='Vragen'
                                        data-id='@{{vraag.id}}' contenteditable='true'><i
                                                class="fa fa-square-o"></i> @{{vraag.mogelijke_antwoorden_4}}</h5>
                                    <!--feedback validatie-->
                                    <div class="col-md-1 pull-right glyphicon glyphicon-saved "
                                         ng-show="toon_succes_melding('mogelijke_antwoorden_4',vraag.id)">
                                    </div>
                                    <div class="col-md-11 invalid"
                                         ng-show="toon_fout_melding('mogelijke_antwoorden_4',vraag.id)">@{{ server_controle_fout[0] }}
                                    </div><!--end feedback-->
                                </div>
                                <div ng-show="vraag.choices == 'Gesloten vragen'">
                                    <h5 ng-class="{'invalid': toon_fout_melding('mogelijke_antwoorden_1',vraag.id)}" class='vraag project titel col-md-12' data-update_status='init'
                                        data-titel='mogelijke_antwoorden_1' data-tabel='Vragen'
                                        data-id='@{{vraag.id}}' contenteditable='true'><i
                                                class="fa fa-circle-thin"></i> @{{vraag.mogelijke_antwoorden_1}}
                                    </h5>
                                    <!--feedback validatie-->
                                    <div class="col-md-1 pull-right glyphicon glyphicon-saved "
                                         ng-show="toon_succes_melding('mogelijke_antwoorden_1',vraag.id)">
                                    </div>
                                    <div class="col-md-11 invalid"
                                         ng-show="toon_fout_melding('mogelijke_antwoorden_1',vraag.id)">@{{ server_controle_fout[0] }}
                                    </div><!--end feedback-->


                                    <h5 ng-class="{'invalid': toon_fout_melding('mogelijke_antwoorden_2',vraag.id)}" class='vraag project titel col-md-12' data-update_status='init'
                                        data-titel='mogelijke_antwoorden_2' data-tabel='Vragen'
                                        data-id='@{{vraag.id}}' contenteditable='true'><i
                                                class="fa fa-circle-thin"></i> @{{vraag.mogelijke_antwoorden_2}}
                                    </h5>
                                    <!--feedback validatie-->
                                    <div class="col-md-1 pull-right glyphicon glyphicon-saved "
                                         ng-show="toon_succes_melding('mogelijke_antwoorden_2',vraag.id)">
                                    </div>
                                    <div class="col-md-11 invalid"
                                         ng-show="toon_fout_melding('mogelijke_antwoorden_2',vraag.id)">@{{ server_controle_fout[0] }}
                                    </div><!--end feedback-->
                                </div>

                        </div>

                    </div>
                        <!--end of vragen div-->
                    </div>

                    <div class="row">
                        <div class="all_fases" ng-controller="add_fase_and_filleController"
                             ng-init="initializetion_fase({{$id}})">
                            <div class="show_allfases">
                                <div ng-repeat="fase in show_fases">


                                    <div class="row">


                                        <a href="" id="vragen-delete" data-toggle="tooltip" data-placement="top"
                                           title="Verwijder foto"><i class="fa fa-times" aria-hidden="true" ng-click="delete_elemets_on_edit_page_fase(fase.id,$index,'fases')"></i></a>
                                        <div>@{{ $index }}</div>





                                        <div ng-class="{'invalid': toon_fout_melding('fase_titel',fase.id)}"
                                             class='col-md-11 project titel col-md-10' data-update_status='init'
                                             data-titel='fase_titel' data-tabel='fases' data-id='@{{fase.id}}'
                                             contenteditable='true'>@{{  fase.fase_titel}}</div>
                                        <div class="col-md-1 pull-right glyphicon glyphicon-saved "
                                             ng-show="toon_succes_melding('fase_titel',fase.id)"></div>
                                        <div class="col-md-11 invalid"
                                             ng-show="toon_fout_melding('fase_titel',fase.id)">@{{ server_controle_fout[0] }}</div>

                                        <div ng-class="{'invalid': toon_fout_melding('fase_beschrijving',fase.id)}"
                                             class='col-md-11 project titel col-md-10' data-update_status='init'
                                             data-titel='fase_beschrijving' data-tabel='fases' data-id='@{{fase.id}}'
                                             contenteditable='true'>@{{  fase.fase_beschrijving}}</div>

                                        <div class="col-md-1 pull-right glyphicon glyphicon-saved "
                                             ng-show="toon_succes_melding('fase_beschrijving',fase.id)">
                                        </div>
                                        <div class="col-md-11 invalid"
                                             ng-show="toon_fout_melding('fase_beschrijving',fase.id)">@{{ server_controle_fout[0] }}
                                        </div>
                                    </div>
                                    <br>
                                    </br>
                                    <div class="row">
                                        <div class="col-md-11">
                                            <p>status van de fase</p>
                                            <p>@{{ fase.fases }}</p>
                                            <select ng-change="fase_update($index,fase.id);" ng-model="fase_choice[$index]">
                                                <option ng-selected="'open fase'=== show_fases[$index].fases" value="open fase">Open</option>
                                                <option ng-selected="'in progress' === show_fases[$index].fases" value="in progress">Bezich</option>
                                                <option ng-selected="'fase afgesloten' === show_fases[$index].fases" value="fase afgesloten">Afgesloten</option>
                                            </select>
                                        </div>


                                        <div class="col-md-1 pull-right glyphicon glyphicon-saved "
                                             ng-show="type_fase_saved('fases',fase.id)">

                                        </div>
                                        <div class="col-md-11 invalid"
                                             ng-show="toon_fout_melding('fases',fase.id)">@{{ server_controle_fout[0] }}
                                        </div>

                                    </div>


                                    <div ng-click="get_fase_id($index)" class="glyphicon glyphicon-edit"
                                         ngf-select="uploadFiles($files, $invalidFiles, fase.id )"
                                         accept="image/*" ngf-max-height="1000" ngf-accept="'image/*'"
                                         ngf-max-size="1MB"><img
                                                ng-src="{{Request::root()}}/img/fase/@{{ fase.fases_picture }}"
                                                alt="@{{ fase.fases_picture }}">
                                    </div>
                                    <ul>
                                        <li ng-repeat="f in errFiles_fase" >
                                            @{{f.name}} @{{f.$error}} @{{f.$errorParam}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="add_fase">
                                <div class="glyphicon glyphicon-plus-sign"  ng-click="add_fase()"></div>
                            </div>
                        </div>
                    </div>

                <!-- END DIV EDIT_CONTENT -->
            </div>
        </div>
    </div>

    </div>
@stop