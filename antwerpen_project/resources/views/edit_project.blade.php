@extends('layout') @section('header') @stop @section('editContent')






<div id="editContainer">

    <div ng-controller="edit_projectController" ng-init="initializetion({{$id}})">


        <div id="edit_project">
            <div class="row">

                <div id="edit_header">

                    <div id="edit-back" class="inline">
                        <a href="{{Request::root()}}">
                            <i class="fa fa-chevron-left inline" aria-hidden="true"></i>
                            <div id="" class="inline">TERUG</div>

                        </a>
                    </div>

                    <h1 class="inline">Project wijzigen</h1>

                </div>

                <div id="edit_content">






                    <div class="row">
                        <div class="col-md-6">
                            <div class="success-pop-up slide-down-fade" ng-show="toon_succes_melding('titel',project.id)">
                                <i class="fa fa-check" aria-hidden="true"></i> Opgeslagen!
                            </div>
                            <div id="edit-title" class="col-md-12 edit-white-box" data-toggle="tooltip" data-placement="top" title="Klik op de tekst om aan te passen">

                                <h4 class="title_red title-font">Titel <small>max 250 karakters</small></h4>


                                <p ng-class="{'invalid': toon_fout_melding('titel',project.id)}" class="no-padding col-md-12 project titel" ng-model="inhoud" data-update_status='init' data-titel='titel' data-tabel='projecten' data-id='{{$id}}' contenteditable='true'>@{{project.titel}}</p>
                                <!--ng-show="toon_succes_melding('titel',project.id)"-->

                                <div class="invalid" ng-show="toon_fout_melding('titel',project.id)">@{{ server_controle_fout[0] }}</div>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="success-pop-up slide-down-fade" ng-show="toon_succes_melding('begin_datum',project.id)">
                                <i class="fa fa-check" aria-hidden="true"></i> Opgeslagen!
                            </div>
                            <div id="datepicker" class="edit-white-box" data-toggle="tooltip" data-placement="top" title="Klik op het invoerveld om aan te passen">

                                <h4 class="title_red title-font">Begindatum</h4>
                                <input data-update_status='init' data-titel='begin_datum' data-tabel='projecten' data-id='{{$id}}' type="text" class="inline  begin_datum datum form-control text-center" name="start" ng-model="project.begin_datum" />

                                <div class="invalid" ng-show="toon_fout_melding('begin_datum',project.id)">@{{ server_controle_fout[0] }}
                                </div>

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="success-pop-up slide-down-fade" ng-show="toon_succes_melding('eind_datum',project.id)">
                                <i class="fa fa-check" aria-hidden="true"></i> Opgeslagen!
                            </div>
                            <div id="datepicker" class="edit-white-box" data-toggle="tooltip" data-placement="top" title="Klik op het invoerveld om aan te passen">

                                <h4 class="title_red title-font">Einddatum</h4>
                                <input data-update_status='init' data-titel='eind_datum' data-tabel='projecten' data-id='{{$id}}' type="text" class="inline  begin_datum datum form-control text-center" name="end" ng-model="project.eind_datum" />
                                <div class="invalid" ng-show="toon_fout_melding('eind_datum',project.id)">@{{ server_controle_fout[0] }}
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--einde row titel-->

                    <div class="row">



                        <div class="col-md-6" id="beschrijving">
                            <div class="success-pop-up slide-down-fade" ng-show="toon_succes_melding('beschrijving',project.id)">
                                <i class="fa fa-check" aria-hidden="true"></i> Opgeslagen!
                            </div>
                            <div id="edit-beschrijving" class="edit-white-box" data-toggle="tooltip" data-placement="top" title="Klik op de tekst om aan te passen">
                                <h4 class="title_red  title-font">Beschrijving <small>max 5000 karakters</small></h4>
                                <p ng-class="{'invalid': toon_fout_melding('beschrijving',project.id)}" class="no-padding col-md-12 project beschrijving" data-update_status='init' data-titel='beschrijving' data-tabel='projecten' data-id='{{$id}}' contenteditable='true'>@{{project.beschrijving}}</p>
                                <div class="col-md-12 invalid" ng-show="toon_fout_melding('beschrijving',project.id)">@{{ server_controle_fout[0] }}</div>
                            </div>
                        </div>



                        <div class="col-md-6" id="locatie">
                            <div class="edit-white-box" data-toggle="tooltip" data-placement="top" title="Klik op de kaart of zoek een adres">
                                <h4 class="title_red title-font">Locatie</h4>
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="title_red" ng-show="locations_errors">
                                            @{{ locations_errors }}
                                        </div>



                                        <div ng-show="$scope.locations_errors">@{{ $scope.locations_errors }}</div>
                                        <form ng-submit="add_location_on_enter(input_loc)">
                                            <div class="no-padding col-md-10">
                                                <input id="autocomplete" type="text" class="form-control " placeholder="Zoeken" ng-model="input_loc" googleplace/>
                                            </div>
                                            <div class="no-padding col-md-2">
                                                <button class="fa fa-plus form-control" type="submit"></button>
                                            </div>

                                        </form>


                                        <br>
                                        <div ng-repeat="location in locations">

                                            <br>
                                            <p class="inline" id="map-locatie">@{{ location.address }}</p>
                                            <a class="map_delete" href="" title="verwijder">
                                                <i class="fa fa-times inline" aria-hidden="true" ng-click="delete_elemets_on_edit_page_locatie(location.id,$index,'locations')"></i>
                                            </a>
                                            <br>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="" id="map-container-editpage" ng-init="map_initializetion({{$id}})">
                                            <ui-gmap-google-map center="map.center" zoom="map.zoom" draggable="true" events="map.events">
                                                <ui-gmap-markers models="locations" coords="'location'" idkey="'id'" events="map.marker_events">
                                                    <ui-gmap-windows show="'show'">
                                                        <p ng-non-bindable> @{{ address }}</p>
                                                    </ui-gmap-windows>

                                                </ui-gmap-markers>
                                            </ui-gmap-google-map>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- einde row beschrijving -->






                    <div class="row">

                        <div id="edit_foto" class="col-md-12">
                            <div class="edit-white-box" ng-controller="file_uplodController" ng-init="initializetion_foto({{$id}})">
                                <h4 class="title_red title-font">Foto's</h4>
                                <div class="alle_fotos col-md-6 no-padding">




                                    <div class="show_fotos" ng-repeat="foto in show_fotos">


                                        <div id="thumbs" class="col-xs-6 col-md-3">

                                            <a href="" id="foto-delete" data-toggle="tooltip" data-placement="top" title="Verwijder foto">
                                                <i class="fa fa-times" aria-hidden="true" ng-click="delete_elemets_on_edit_page_fotos(foto.id,$index,'foto','show_fotos')"></i>
                                            </a>
                                            <a href="" class="thumbnail">
                                                <img ng-src="{{Request::root()}}/img/project/@{{ foto.project_picture }}" alt="@{{ foto.project_picture }}" />
                                            </a>
                                        </div>
                                        <div ng-if="$last" class="edit_foto_add_button col-md-3 col-xs-6" ngf-select="uploadFiles($files, $invalidFiles)" multiple accept="image/*" ngf-max-height="1000" ngf-accept="'image/*'" ngf-max-size="1MB">
                                            <div class="glyphicon glyphicon-plus col-md-12"></div>
                                            <small class="edit_foto_add_button_small">Selecteer foto</small>
                                            <small class="edit_foto_add_button_small_maxsize">Max 1024x768 - 1MB</small>
                                        </div>

                                    </div>
                                    <!--end of foto galerij-->



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
                                <!--end of file_upload Conroller-->

                                <div class="col-md-6 show_fotos" id="edit-foto-big" ng-repeat="foto in show_fotos" ng-if="$first">

                                    <img ng-src="{{Request::root()}}/img/project/@{{ foto.project_picture }}" alt="@{{ foto.project_picture }}" />

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- einde row foto -->








                    {{ Form::open(array('url' => 'project_toevoegen/add','files' => true))}} {{ Form::close() }}



                    <div class="row">

                        <div class="col-md-6">
                            <div id="edit-vraag" class="edit-white-box" data-toggle="tooltip" data-placement="top" title="Klik op de vraag -en antwoordtekst om aan te passen">

                                <h4 class="title_red title-font">Vragen</h4>

                                <div class="col-md-12 no-padding" ng-repeat="vraag in alle_vragen">
                                    <div class="success-pop-up slide-down-fade" ng-show="toon_succes_melding('vraag',vraag.id)">
                                        <i class="fa fa-check" aria-hidden="true"></i> Opgeslagen!
                                    </div>
                                    <div class="success-pop-up slide-down-fade" ng-show="toon_succes_melding('mogelijke_antwoorden_1',vraag.id)">
                                        <i class="fa fa-check" aria-hidden="true"></i> Opgeslagen!
                                    </div>
                                    <div class="success-pop-up slide-down-fade" ng-show="toon_succes_melding('mogelijke_antwoorden_2',vraag.id)">
                                        <i class="fa fa-check" aria-hidden="true"></i> Opgeslagen!
                                    </div>
                                    <div class="success-pop-up slide-down-fade" ng-show="toon_succes_melding('mogelijke_antwoorden_3',vraag.id)">
                                        <i class="fa fa-check" aria-hidden="true"></i> Opgeslagen!
                                    </div>
                                    <div class="success-pop-up slide-down-fade" ng-show="toon_succes_melding('mogelijke_antwoorden_4',vraag.id)">
                                        <i class="fa fa-check" aria-hidden="true"></i> Opgeslagen!
                                    </div>
                                    <div id="edit-vraag-content" ng-show="vraag.choices == 'open vragen'">


                                        <h5 class="title_red title-font">Vraag @{{ $index+1 }}: @{{vraag.choices}} <small>max 1000 karakters per veld</small></h5>
                                        <a href="" title="verwijder">
                                            <i class="fa fa-times" aria-hidden="true" ng-click="delete_elemets_on_edit_page_vragen(vraag.id,$index,'vragen')"></i>
                                        </a>


                                        <p class='vraag project titel' ng-class="{'invalid': toon_fout_melding('vraag',vraag.id)}" data-update_status='init' data-titel='vraag' data-tabel='vragen' data-id='@{{vraag.id}}' contenteditable='true' placeholder="">@{{vraag.vraag}}</p>

                                        <!--feedback validatie-->
                                        <div class="invalid" ng-show="toon_fout_melding('vraag',vraag.id)">@{{ server_controle_fout[0] }}
                                        </div>
                                        <br>
                                        <!--end feedback-->




                                    </div>

                                    <div id="edit-vraag-content" ng-show="vraag.choices == 'meerkeuzevragen'">
                                        <h5 class="title_red title-font">Vraag @{{ $index+1 }}: @{{vraag.choices}} <small>max 1000 karakters per veld</small></h5>
                                        <a href="" title="verwijder">
                                            <i class="fa fa-times" aria-hidden="true" ng-click="delete_elemets_on_edit_page_vragen(vraag.id,$index,'vragen')"></i>
                                        </a>

                                        <p ng-class="{'invalid': toon_fout_melding('vraag',vraag.id)}" class='vraag project titel' data-update_status='init' data-titel='vraag' data-tabel='vragen' data-id='@{{vraag.id}}' contenteditable='true'>@{{vraag.vraag}}</p>

                                        <!--feedback validatie-->
                                        <div class="invalid" ng-show="toon_fout_melding('vraag',vraag.id)">@{{ server_controle_fout[0] }}
                                        </div>

                                        <!--end feedback-->



                                        <i class="fa fa-square-o inline"></i>
                                        <p class='vraag project titel inline' data-update_status='init' data-titel='mogelijke_antwoorden_1' data-tabel='vragen' data-id='@{{vraag.id}}' contenteditable='true'> @{{vraag.mogelijke_antwoorden_1}}</p>
                                        <br>
                                        <i class="fa fa-square-o inline"></i>
                                        <p class='vraag project titel inline' data-update_status='init' data-titel='mogelijke_antwoorden_2' data-tabel='vragen' data-id='@{{vraag.id}}' contenteditable='true'> @{{vraag.mogelijke_antwoorden_2}}</p>
                                        <br>
                                        <i class="fa fa-square-o inline"></i>
                                        <p class='vraag project titel inline' data-update_status='init' data-titel='mogelijke_antwoorden_3' data-tabel='vragen' data-id='@{{vraag.id}}' contenteditable='true'> @{{vraag.mogelijke_antwoorden_3}}</p>
                                        <br>
                                        <i class="fa fa-square-o inline"></i>
                                        <p class='vraag project titel inline' data-update_status='init' data-titel='mogelijke_antwoorden_4' data-tabel='vragen' data-id='@{{vraag.id}}' contenteditable='true'> @{{vraag.mogelijke_antwoorden_4}}</p>
                                    </div>
                                    <div id="edit-vraag-content" ng-show="vraag.choices == 'Gesloten vragen'">

                                        <h5 class="title_red title-font">Vraag @{{ $index+1 }}: @{{vraag.choices}} <small>max 1000 karakters per veld</small></h5>
                                        <a href="" title="verwijder">
                                            <i class="fa fa-times" aria-hidden="true" ng-click="delete_elemets_on_edit_page_vragen(vraag.id,$index,'vragen')"></i>
                                        </a>

                                        <p ng-class="{'invalid': toon_fout_melding('vraag',vraag.id)}" class='vraag project titel' data-update_status='init' data-titel='vraag' data-tabel='vragen' data-id='@{{vraag.id}}' contenteditable='true'>@{{vraag.vraag}}</p>
                                        <!--feedback validatie-->
                                        <div class="invalid" ng-show="toon_fout_melding('vraag',vraag.id)">@{{ server_controle_fout[0] }}
                                        </div>

                                        <!--end feedback-->



                                        <i class="fa fa-circle-thin inline"></i>
                                        <p class='vraag project titel inline' data-update_status='init' data-titel='mogelijke_antwoorden_1' data-tabel='vragen' data-id='@{{vraag.id}}' contenteditable='true'> @{{vraag.mogelijke_antwoorden_1}}</p>
                                        <br>
                                        <i class="fa fa-circle-thin inline"></i>
                                        <p class='vraag project titel inline' data-update_status='init' data-titel='mogelijke_antwoorden_2' data-tabel='vragen' data-id='@{{vraag.id}}' contenteditable='true'> @{{vraag.mogelijke_antwoorden_2}}</p>
                                    </div>
                                </div>


                                <div class="vraag_add_button">
                                    <h6>Voeg vraag toe:</h6>
                                    <div class="btn-group " role="group" aria-label="...">

                                        <button type="button" class="btn btn-default mybutton" ng-click="add_question('open vragen')">open vraag
                                        </button>


                                        <button type="button" class="btn btn-default" ng-click="add_question('meerkeuzevragen')">meerkeuzevraag
                                        </button>

                                        <button type="button" class="btn btn-default" ng-click="add_question('Gesloten vragen')">gesloten vraag
                                        </button>
                                    </div>
                                </div>

                            </div>
                            <!--end of vragen div-->
                        </div>






                        <div class="col-md-6">
                            <div id="edit-fase" class="edit-white-box" data-toggle="tooltip" data-placement="top" title="Klik op de tekst om aan te passen">


                                <h4 class="title_red title-font">Fases</h4>

                                <div class="all_fases" ng-controller="add_fase_and_filleController" ng-init="initializetion_fase({{$id}})">
                                    <div class="show_allfases">
                                        <div id="edit-fase-content" ng-repeat="fase in show_fases">

                                            <div id="fase-full" class="col-md-12 no-padding">
                                                <div class="success-pop-up slide-down-fade" ng-show="toon_succes_melding('fase_titel',fase.id)">
                                                    <i class="fa fa-check" aria-hidden="true"></i> Opgeslagen!
                                                </div>
                                                <div class="success-pop-up slide-down-fade" ng-show="toon_succes_melding('fase_beschrijving',fase.id)">
                                                    <i class="fa fa-check" aria-hidden="true"></i> Opgeslagen!
                                                </div>
                                                <div class="success-pop-up slide-down-fade" ng-show="type_fase_saved('fases',fase.id)">
                                                    <i class="fa fa-check" aria-hidden="true"></i> Opgeslagen!
                                                </div>
                                                <a href="" id="fase-del" title="Verwijder">
                                                    <i class="fa fa-times" aria-hidden="true" ng-click="delete_elemets_on_edit_page_fase(fase.id,$index,'fases')"></i>
                                                </a>
                                                <div class="col-md-6 no-padding">


                                                    <h5 class="title_red title-font">Fase @{{ $index+1 }} <small>max 250 karakters per veld</small></h5>




                                                    <p ng-class="{'invalid': toon_fout_melding('fase_titel',fase.id)}" class='project titel' data-update_status='init' data-titel='fase_titel' data-tabel='fases' data-id='@{{fase.id}}' contenteditable='true'>@{{ fase.fase_titel}}</p>
                                                    <p class="invalid" ng-show="toon_fout_melding('fase_titel',fase.id)">@{{ server_controle_fout[0] }}</p>

                                                    <p ng-class="{'invalid': toon_fout_melding('fase_beschrijving',fase.id)}" class='project titel' data-update_status='init' data-titel='fase_beschrijving' data-tabel='fases' data-id='@{{fase.id}}' contenteditable='true'>@{{ fase.fase_beschrijving}}</p>

                                                    <p class="invalid" ng-show="toon_fout_melding('fase_beschrijving',fase.id)">@{{ server_controle_fout[0] }}
                                                    </p>




                                                    <select class="form-control" ng-change="fase_update($index,fase.id);" ng-model="fase_choice[$index]">
                                                        <option selected="true" disabled>Status</option>
                                                        <option ng-selected="'open fase'=== show_fases[$index].fases" value="open fase">Open
                                                        </option>
                                                        <option ng-selected="'in progress' === show_fases[$index].fases" value="in progress">Bezig
                                                        </option>
                                                        <option ng-selected="'fase afgesloten' === show_fases[$index].fases" value="fase afgesloten">Afgesloten
                                                        </option>
                                                    </select>



                                                    <div class="invalid" ng-show="toon_fout_melding('fases',fase.id)">@{{ server_controle_fout[0] }}
                                                    </div>

                                                </div>



                                                <div id="fase-img" class="col-md-6">

                                                    <a href="" id="fase-img-del" title="Verwijder foto" ng-click="delete_elemets_on_edit_page_fotos(foto.id,$index,'foto','show_fotos')">
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    </a>
                                                    <img ng-click="get_fase_id($index)" ngf-select="uploadFiles($files, $invalidFiles, fase.id,$index )" accept="image/*" ngf-max-height="1000" ngf-accept="'image/*'" ngf-max-size="1MB" ng-src="{{Request::root()}}/img/fase/@{{ fase.fases_picture }}" alt="@{{ fase.fases_picture }}">

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



                                    <div id="fase-add-button" class="add_fase" ng-click="add_fase()">
                                        <div class="glyphicon glyphicon-plus col-md-12"></div>
                                        <small class="edit_foto_add_button_small">Voeg fase toe</small>
                                    </div>


                                </div>





                            </div>
                        </div>
                    </div>
                    <!-- end of vragen row -->
                </div>
            </div>
            <!-- END DIV EDIT_CONTENT -->
        </div>

    </div>
</div>
</div>

</div>
@stop