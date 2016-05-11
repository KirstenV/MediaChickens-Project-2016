@extends('layout') @section('homeContent')


<div id="homeContainer" class="col-md-6">
    <div id="projectContainer" ng-controller="projectController">
        @if(Auth::check()) @if(Auth::user()->is_adm)
        <div id="editable" ng-hide="project">
            <h4 id="add_project" class="nieuw_project" contenteditable='true'>Pas mij aan om een nieuw project aan
                    te maken</h4>
        </div>
        <!-- END DIV EDITABLE -->
        @endif @endif




        <div class="alle_projecten">
            <div class="project">
            </div>
            <!-- END DIV PROJECT -->
            {{ Form::open(array('url' => 'projecten/add'))}} {{ Form::close() }}
        </div>
        <!-- END DIV ALLE_PROJECTEN -->



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

                <div id="collapse1" class="panel-collapse collapse in" ng-hide="project">
                    <div class="panel-body" ng-repeat="project in projects" ng-class="is_tru_id(project.id,highlight_class)">
                        <div ng-show="project.id">
                            <h4 id="div-inline" ng-click="show_project_info(project.id)"><!--<a href="project/@{{project.id}}/view">-->@{{project.titel}}<!--</a>--></h4>
                            @if(Auth::check()) 
                                @if(Auth::user()->is_adm)
                                    <div id="div-inline" class="project_icons">
                                        <div class="col-md-6">
                                            <div id="div-inline" class="edit_home_page">
                                                <a href="project/@{{project.id}}/edit" title="wijzig project">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <!-- END DIV COL-MD-6 -->
                                        <div class="col-md-6">
                                            <div id="div-inline" class="delete_home_page" > <!--ng-click="delete_project(project.id,$index)"-->
                                                <a href="">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <!-- END DIV COL-MD-6 -->
                                    </div>
                                    <!-- END DIV PROJECT_ICONS -->
                                @endif 
                            @endif
                            <!--		<br><small><div id="div-inline"  class="begien_datum_home_page"><strong>Begindatum: </strong>@{{project.begin_datum}}</a></div></small> -->
                            <!--		<small><div id="div-inline"  class="eind_datum_home_page"><strong>Einddatum: </strong>@{{project.eind_datum}}</a></div></small> -->
                            <!--		<br><div id="div-inline"  class="begien_datum_home_page"><strong>Beschrijving: </strong>@{{project.beschrijving}}</a></div> -->
                            <hr>
                        </div>
                        
                        
                        <div class="panel-body-child col-md-12">
                        
                            <p class="col-md-8">Weet je zeker dat je project "@{{project.titel}}" wilt verwijderen? </p>
                            
                                <button class="btn btn-default col-md-2 cancel-btn">Annuleer</button>
                                <button class="btn btn-danger col-md-2 delete-btn">Verwijder</button>
                            
                        </div>
                        
                        
                        
                        
                        
                    </div>
                    <!-- END DIV PANEL-BODY -->
                </div>
                <!-- END DIV COLLAPSE1 -->

                <div class="hole_project" ng-show="project">
                    <div ng-click="show_projects()">terug naar overzicht van projecten</div>
                    @{{ project.project.id }} @{{ project.project.begin_datum }} @{{ project.project.eind_datum }} @{{ project.project.beschrijving }}

                    <div ng-repeat="foto in project.fotos">
                        <div>@{{ $index }}</div>
                        <img ng-src="{{Request::root()}}/img/project/small_@{{ foto.project_picture }}">
                    </div>

                    <div ng-repeat="vraag in project.vragen">
                        <div>@{{ $index }}</div>
                        <div>@{{ vraag}}</div>
                    </div>

                    <div ng-repeat="vraag in project.vragen">
                        <div>@{{ $index }}</div>
                        <div>@{{ vraag}}</div>
                    </div>

                </div>
                <!--end div evreting obout project-->


            </div>
            <!-- END DIV PANEL PANEL-DEFAULT -->
            <!--
                  <div class="panel panel-default">

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

                </div>
                -->


        </div>
        <!-- END DIV ACCORDION -->

    </div>
    @stop @section('map')
    <div class="col-md-6">

        <div id="map-container">
            <div id="map"></div>
        </div>
    </div>
    @stop