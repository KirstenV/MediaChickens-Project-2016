@extends('layout') @section('header') @stop @section('editContent')


<div id="map-container-editpage">
    <div id="map"></div>
</div>



<div id="editContainer">

    <div ng-controller="edit_projectController" ng-init="initializetion({{$id}})">

        <div id="edit_project" class="container">
            <div class="row">

                <div id="edit_header">
                    <a href="{{Request::root()}}"><div id="div-inline" class="edit_header_icon_back"><i class="fa fa-caret-left" aria-hidden="true"></i>    Terug naar homepage</div></a>
                    <h1 id="div-inline">Project wijzigen</h1>
                    <div id="div-inline" class="edit_header_icon_pencil"><i class="fa fa-pencil-square" aria-hidden="true"></i></div>
                </div>

                <div id="edit_content">

                    <div class="alle_content">
                        <div class="row">
                            <h4 class="col-md-12 title_red">Titel</h4>
                            <div class="col-md-12 no-padding">

                                <p ng-class="{'invalid': toon_fout_melding('titel',project.id)}" class="col-md-11 project titel" data-toggle="tooltip" ng-model="inhoud" data-placement="left" title="Klik om aan te passen" data-update_status='init' data-titel='titel' data-tabel='projecten' data-id='{{$id}}' contenteditable='true'>@{{project.titel}}</p>

                                 <div class="col-md-1 pull-right glyphicon glyphicon-saved " ng-show="toon_succes_melding('titel',project.id)"></div>
                                <div class="col-md-11 invalid" ng-show="toon_fout_melding('titel',project.id)">@{{ server_controle_fout[0] }}</div>
                            </div>
                        </div>
                        <!--einde row titel-->
                        <hr>
                        <div id="edit_foto">
                            <div class="alle_fotos " class="row" ng-controller="file_uplodController" ng-init="initializetion_foto({{$id}})">


                                <div class="row">
                                    <h4 class="col-md-12 title_red">Foto's</h4>
                                    <div class="show_fotos" ng-repeat="foto in show_fotos">


                                        <div id="thumbs" class="col-xs-6 col-md-3">

                                            <a href="" id="foto-delete" data-toggle="tooltip" data-placement="top" title="Verwijder foto">
                                                <i class="fa fa-times" aria-hidden="true" ng-click="delete_elemets_on_edit_page_fotos(foto.id,$index,'foto','show_fotos')"></i>
                                            </a>
                                            <a href="#" class="thumbnail">
                                                <img ng-src="{{Request::root()}}/img/project/small_@{{ foto.project_picture }}" alt="@{{ foto.project_picture }}" />
                                            </a>
                                        </div>


                                    </div>
                                    <!--end of foto galerij-->

                                    <div class="edit_foto_add_button col-md-3 col-xs-6" ngf-select="uploadFiles($files, $invalidFiles)" multiple accept="image/*" ngf-max-height="1000" ngf-accept="'image/*'" ngf-max-size="1MB">
                                        <div class="glyphicon glyphicon-plus col-md-12"></div>
                                        <small class="edit_foto_add_button_small">Selecteer foto</small>
                                        <small class="edit_foto_add_button_small_maxsize">Max 1024x768 - 1MB</small>
                                    </div>

                                    <br>
                                    <br>
                                    <ul>
                                        <!-- START OF ERRORS -->
                                        <!--front end erors-->
                                        <li ng-repeat="f in errFiles_fase" style="font:smaller">
                                            @{{f.name}} @{{f.$error}} @{{f.$errorParam}}

                                        </li>
                                        <!--back end end erors -> deze moet nog goed testen zo dat er geen secuirity issius zijn-->
                                        <li ng-show="errorMsg">@{{errorMsg}}</li>
                                    </ul>
                                    <!-- END OF ERRORS -->
                                </div>
                                <!-- DIV END ROW -->


                            </div>
                            <!--end of file_upload Conroller-->
                        </div>
                        <hr>

                        <div class="row col-md-12 no-padding">
                            <h4 class="title_red  col-md-12">Beschrijving</h4>
                            <p ng-class="{'invalid': toon_fout_melding('beschrijving',project.id)}" data-toggle="tooltip" data-placement="left" title="Klik om aan te passen" class="col-md-11 project beschrijving" data-update_status='init' data-titel='beschrijving' data-tabel='projecten' data-id='{{$id}}' contenteditable='true'>@{{project.beschrijving}}</p>
                             <div class="col-md-1 pull-right glyphicon glyphicon-saved "  ng-show="toon_succes_melding('beschrijving',project.id)"></div>
                            <div class="col-md-11 invalid" ng-show="toon_fout_melding('beschrijving',project.id)">@{{ server_controle_fout[0] }}</div>
                        </div>
                    </div>
                    <!--einde diw beschrijving-->
                    <hr>

                    <h4 class="title_red">Begin -en einddatum</h4>

                    <div id="datepicker">

                        <span class="input-group-addon inline">van</span>
                        <input data-update_status='init' data-titel='begin_datum' data-tabel='projecten' data-id='{{$id}}' type="text" class="inline  begin_datum datum textbox" name="start" ng-model="project.begin_datum" />
                        <span class="input-group-addon inline">tot</span>
                        <input data-update_status='init' data-titel='eind_datum' data-tabel='projecten' data-id='{{$id}}' type="text" class="inline  begin_datum datum textbox" name="end" ng-model="project.eind_datum" />






                    </div>




                    <hr>

                    <div class="col-md-12 no-padding" id="locatie">
                        <h4 class="title_red">Locatie</h4>
                        <div ng-show="locations_errors">
                            @{{ locations_errors }}
                        </div>
                        <input id="autocomplete" type="text" class="textbox col-md-6" placeholder="Typ een adres of klik op de kaart">
                        <br>
                        <div ng-repeat="location in locations">
                            <div class="row col-md-12">
                                <br>
                                <p class="inline" id="map-locatie">@{{ location.straat_naam }}</p>
                                <a href="" style="text-decoration:none" title="verwijder">
                                    <i class="fa fa-times inline" aria-hidden="true" ng-click="delete_elemets_on_edit_page_locatie(location.id,$index,'locations')"></i>
                                </a>
                                <br>
                            </div>
                        </div>


                    </div>


                    {{ Form::open(array('url' => 'project_toevoegen/add','files' => true))}} {{ Form::close() }}


                    <hr>





                    <div class="col-md-12 no-padding">










                        <h4 class="title_red">Vragen</h4>
                        <br>
                        <div class="col-md-12 no-padding" ng-repeat="vraag in alle_vragen">
                            <div ng-show="vraag.choices == 'open vragen'">
                                <br>

                                <h5 class="title_red inline">Vraag @{{ $index }}: @{{vraag.choices}}</h5> <a href="" style="text-decoration:none" title="verwijder"><i class="fa fa-times inline" aria-hidden="true" ng-click="delete_elemets_on_edit_page_vragen(vraag.id,$index,'vragen')"></i></a>


                                <h5 ng-class="{'invalid': toon_fout_melding('vraag',vraag.id)}" class='vraag project titel col-md-12 no-padding title_red' data-update_status='init' data-titel='vraag' data-tabel='Vragen' data-id='@{{vraag.id}}' contenteditable='true'></h5>
                                <!--feedback validatie-->
                                <div class="col-md-1 pull-right glyphicon glyphicon-saved " ng-show="toon_succes_melding('vraag',vraag.id)">
                                </div>
                                <div class="col-md-11 invalid" ng-show="toon_fout_melding('vraag',vraag.id)">@{{ server_controle_fout[0] }}
                                </div>
                                <br>
                                <!--end feedback-->







                                <h5 class='vraag project titel' data-update_status='init' data-titel='vraag' data-tabel='Vragen' data-id='@{{vraag.id}}' contenteditable='true' placeholder="">@{{vraag.vraag}}</h5>

                            </div>
                            <br>
                            <div ng-show="vraag.choices == 'meerkeuzevragen'">
                                <h5 class="title_red inline">Vraag @{{ $index }}: @{{vraag.choices}}</h5> <a href="" style="text-decoration:none" title="verwijder"><i class="fa fa-times inline" aria-hidden="true" ng-click="delete_elemets_on_edit_page_vragen(vraag.id,$index,'vragen')"></i></a>



                                <h5 ng-class="{'invalid': toon_fout_melding('vraag',vraag.id)}" class='vraag project titel col-md-12 no-padding title_red' data-update_status='init' data-titel='vraag' data-tabel='Vragen' data-id='@{{vraag.id}}' contenteditable='true'></h5>
                                <!--feedback validatie-->
                                <div class="col-md-1 pull-right glyphicon glyphicon-saved " ng-show="toon_succes_melding('vraag',vraag.id)">
                                </div>
                                <div class="col-md-11 invalid" ng-show="toon_fout_melding('vraag',vraag.id)">@{{ server_controle_fout[0] }}
                                </div>
                                <br>
                                <!--end feedback-->




                                <h5 class='vraag project titel' data-update_status='init' data-titel='vraag' data-tabel='Vragen' data-id='@{{vraag.id}}' contenteditable='true'>@{{vraag.vraag}}</h5>
                                <br>
                                <i class="fa fa-square-o inline"></i>
                                <h5 class='vraag project titel inline' data-update_status='init' data-titel='mogelijke_antwoorden_1' data-tabel='Vragen' data-id='@{{vraag.id}}' contenteditable='true'> @{{vraag.mogelijke_antwoorden_1}}</h5>
                                <br>
                                <i class="fa fa-square-o inline"></i>
                                <h5 class='vraag project titel inline' data-update_status='init' data-titel='mogelijke_antwoorden_2' data-tabel='Vragen' data-id='@{{vraag.id}}' contenteditable='true'> @{{vraag.mogelijke_antwoorden_2}}</h5>
                                <br>
                                <i class="fa fa-square-o inline"></i>
                                <h5 class='vraag project titel inline' data-update_status='init' data-titel='mogelijke_antwoorden_3' data-tabel='Vragen' data-id='@{{vraag.id}}' contenteditable='true'> @{{vraag.mogelijke_antwoorden_3}}</h5>
                                <br>
                                <i class="fa fa-square-o inline"></i>
                                <h5 class='vraag project titel inline' data-update_status='init' data-titel='mogelijke_antwoorden_4' data-tabel='Vragen' data-id='@{{vraag.id}}' contenteditable='true'> @{{vraag.mogelijke_antwoorden_4}}</h5>
                            </div>
                            <div ng-show="vraag.choices == 'Gesloten vragen'">

                                <h5 class="title_red inline">Vraag @{{ $index }}: @{{vraag.choices}}</h5> <a href="" style="text-decoration:none" title="verwijder"><i class="fa fa-times inline" aria-hidden="true" ng-click="delete_elemets_on_edit_page_vragen(vraag.id,$index,'vragen')"></i></a>



                                <h5 ng-class="{'invalid': toon_fout_melding('vraag',vraag.id)}" class='vraag project titel col-md-12 no-padding title_red' data-update_status='init' data-titel='vraag' data-tabel='Vragen' data-id='@{{vraag.id}}' contenteditable='true'></h5>
                                <!--feedback validatie-->
                                <div class="col-md-1 pull-right glyphicon glyphicon-saved " ng-show="toon_succes_melding('vraag',vraag.id)">
                                </div>
                                <div class="col-md-11 invalid" ng-show="toon_fout_melding('vraag',vraag.id)">@{{ server_controle_fout[0] }}
                                </div>
                                <br>
                                <!--end feedback-->





                                <h5 class='vraag project titel' data-update_status='init' data-titel='vraag' data-tabel='Vragen' data-id='@{{vraag.id}}' contenteditable='true'>@{{vraag.vraag}}</h5>
                                <br>
                                <i class="fa fa-circle-thin inline"></i>
                                <h5 class='vraag project titel inline' data-update_status='init' data-titel='mogelijke_antwoorden_1' data-tabel='Vragen' data-id='@{{vraag.id}}' contenteditable='true'> @{{vraag.mogelijke_antwoorden_1}}</h5>
                                <br>
                                <i class="fa fa-circle-thin inline"></i>
                                <h5 class='vraag project titel inline' data-update_status='init' data-titel='mogelijke_antwoorden_2' data-tabel='Vragen' data-id='@{{vraag.id}}' contenteditable='true'> @{{vraag.mogelijke_antwoorden_2}}</h5>
                            </div>
                        </div>










                        <div class="vraag_add_button">
                            <h6>Voeg vraag toe:</h6>
                            <div class="btn-group " role="group" aria-label="...">

                                <button type="button" class="btn btn-default mybutton" ng-click="add_question('open vragen')">open vraag</button>


                                <button type="button" class="btn btn-default" ng-click="add_question('meerkeuzevragen')">meerkeuzevraag</button>

                                <button type="button" class="btn btn-default" ng-click="add_question('Gesloten vragen')">gesloten vraag</button>
                            </div>
                        </div>










                        <!--end of vragen div-->
                    </div>


                    <hr>


                    <div class="row col-md-12">
                        <h4 class="title_red">Fases</h4>
                        <br>
                        <div class="all_fases col-md-12 no-padding" ng-controller="add_fase_and_filleController" ng-init="initializetion_fase({{$id}})">
                            <div class="show_allfases">
                                <div ng-repeat="fase in show_fases">

                                    <div id="fase-full" class="col-md-12">
                                        <div class="row col-md-6 no-padding">

                                            <div class="col-md-12">
                                                <h5 class="title_red inline">Fase @{{ $index }}</h5>
                                                <a class="inline" style="text-decoration:none" href="" id="vragen-delete" data-toggle="tooltip" data-placement="top" title="Verwijder foto">
                                                    <i class="fa fa-times inline" aria-hidden="true" ng-click="delete_elemets_on_edit_page_fase(fase.id,$index,'fases')"></i>
                                                </a>
                                            </div>


                                            <div ng-class="{'invalid': toon_fout_melding('fase_titel',fase.id)}" class='col-md-11 project titel col-md-10' data-update_status='init' data-titel='fase_titel' data-tabel='fases' data-id='@{{fase.id}}' contenteditable='true'>@{{ fase.fase_titel}}</div>
                                            <div class="col-md-1 pull-right glyphicon glyphicon-saved " ng-show="toon_succes_melding('fase_titel',fase.id)"></div>
                                            <div class="col-md-11 invalid" ng-show="toon_fout_melding('fase_titel',fase.id)">@{{ server_controle_fout[0] }}</div>

                                            <div ng-class="{'invalid': toon_fout_melding('fase_beschrijving',fase.id)}" class='col-md-11 project titel col-md-10' data-update_status='init' data-titel='fase_beschrijving' data-tabel='fases' data-id='@{{fase.id}}' contenteditable='true'>@{{ fase.fase_beschrijving}}</div>

                                            <div class="col-md-1 pull-right glyphicon glyphicon-saved " ng-show="toon_succes_melding('fase_beschrijving',fase.id)">
                                            </div>
                                            <div class="col-md-11 invalid" ng-show="toon_fout_melding('fase_beschrijving',fase.id)">@{{ server_controle_fout[0] }}
                                            </div>

                                            <br>
                                            <br>
                                            <div class="col-md-12">
                                                <p>status van de fase</p>
                                                <select ng-change="fase_update($index,fase.id);" ng-model="fase_choice[$index]">
                                                    <option ng-selected="'open fase'=== show_fases[$index].fases" value="open fase">Open
                                                    </option>
                                                    <option ng-selected="'in progress' === show_fases[$index].fases" value="in progress">Bezig
                                                    </option>
                                                    <option ng-selected="'fase afgesloten' === show_fases[$index].fases" value="fase afgesloten">Afgesloten
                                                    </option>
                                                </select>
                                            </div>


                                            <div class="col-md-1 pull-right glyphicon glyphicon-saved " ng-show="type_fase_saved('fases',fase.id)">

                                            </div>
                                            <div class="col-md-11 invalid" ng-show="toon_fout_melding('fases',fase.id)">@{{ server_controle_fout[0] }}
                                            </div>

                                        </div>


                                        <div id="fase-img" ng-click="get_fase_id($index)" class="col-md-6 inline no-padding" ngf-select="uploadFiles($files, $invalidFiles, fase.id,$index )" accept="image/*" ngf-max-height="1000" ngf-accept="'image/*'" ngf-max-size="1MB">
                                            <div id="fase-img-del">
                                                <a href="" id="fase-delete" data-toggle="tooltip" data-placement="top" title="Verwijder foto">
                                                    <i class="fa fa-times" aria-hidden="true" ng-click="delete_elemets_on_edit_page_fotos(foto.id,$index,'foto','show_fotos')"></i>
                                                </a>
                                                <img ng-src="{{Request::root()}}/img/fase/@{{ fase.fases_picture }}" alt="@{{ fase.fases_picture }}">
                                            </div>
                                        </div>
                                    </div>

                                    <ul>
                                        <!--verander deze errors met  errors van boven het zijn twee verschilende conrollers-->
                                        <li ng-repeat="f in errFiles">
                                            @{{f.name}} @{{f.$error}} @{{f.$errorParam}}
                                        </li>
                                        <li ng-show="errorMsg">@{{errorMsg}}</li>
                                    </ul>
                                </div>
                            </div>
                            <div id="fase-add-button" class="add_fase col-md-12 no-padding" ng-click="add_fase()">
                                <div class="glyphicon glyphicon-plus col-md-12"></div>
                                <small class="edit_foto_add_button_small">Voeg fase toe</small>
                            </div>
                        </div>

                        <hr>


                    </div>
                </div>
            </div>
            <!-- END DIV EDIT_CONTENT -->
        </div>
    </div>
</div>

</div>
@stop