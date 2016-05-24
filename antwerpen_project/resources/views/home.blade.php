@extends('layout') @section('homeContent')


    <div id="homeContainer" class=" col-xs-12 col-md-6 width-transition"
         ng-class='whatClassIsIt(project, "col-md-8", "col-md-6")'>
        <div id="projectContainer" ng-controller="projectController">
            @if(Auth::check()) @if(Auth::user()->is_adm)
                <div id="editable" class="col-md-6 col-xs-12" ng-hide="project">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    <h4 id="add_project" data-toggle="tooltip" data-placement="right" data-title="Klik en typ een naam"
                        class="nieuw_project col-md-12 col-xs-12 inline" contenteditable='true'>Nieuw project</h4>
                </div>
                <!-- END DIV EDITABLE -->

            @else

                <div id="home-titel" ng-hide="project">
                    <h1 id="home-titel-content"><strong>Huidige projecten</strong></h1>
                </div>



            @endif @else
                <div id="home-titel" ng-hide="project">
                    <h1 id="home-titel-content"><strong>Huidige projecten</strong></h1>
                </div>

            @endif

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
                    <div id="project-titel" class="col-md-8 col-xs-12" ng-show="project">
                        <div id="project-back" class="vert-center div-left" ng-click="show_projects()"><i
                                    class="fa fa-chevron-right inline" aria-hidden="true"></i>
                            <div id="project-back-text" class="inline vert-center">TERUG</div>
                        </div>

                        <h1 id="project-titel-content"><strong>@{{ project.project.titel }}</strong></h1>

                    </div>
                    <div id="collapse1" class="panel-collapse collapse in" ng-hide="project">


                        @if(Auth::check()) @if(Auth::user()->is_adm)

                            <div class="panel-body" ng-repeat="project in projects"
                                 ng-class="is_tru_id(project.id,highlight_class)">
                                <a>
                                    <div id="div-project" ng-show="project.id" ng-click="show_project_info(project.id)">

                                        <h4 id="show-project" class="inline">
                                            <!--<a href="project/@{{project.id}}/view">-->
                                            @{{project.titel}}<!--</a>--></h4> @if(Auth::check()) @if(Auth::user()->is_adm)
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
                                                    <div id="div-inline" class="delete_home_page">
                                                        <!--ng-click="delete_project(project.id,$index)"-->
                                                        <a href="">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <!-- END DIV COL-MD-6 -->
                                            </div>
                                            <!-- END DIV PROJECT_ICONS -->
                                            @endif @endif
                                                    <!--		<br><small><div id="div-inline"  class="begien_datum_home_page"><strong>Begindatum: </strong>@{{project.begin_datum}}</a></div></small> -->
                                            <!--		<small><div id="div-inline"  class="eind_datum_home_page"><strong>Einddatum: </strong>@{{project.eind_datum}}</a></div></small> -->
                                            <!--		<br><div id="div-inline"  class="begien_datum_home_page"><strong>Beschrijving: </strong>@{{project.beschrijving}}</a></div> -->
                                            <hr ng-if="!$last">
                                    </div>
                                </a>

                            </div>
                        @else


                            <div class="panel-body" ng-repeat="project in projects_for_user"
                                 ng-class="is_tru_id(project.id,highlight_class)">
                                <a>
                                    <div id="div-project" ng-show="project.id" ng-click="show_project_info(project.id)">

                                        <h4 id="show-project" class="inline">
                                            <!--<a href="project/@{{project.id}}/view">-->
                                            @{{project.titel}}<!--</a>--></h4> @if(Auth::check()) @if(Auth::user()->is_adm)
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
                                                    <div id="div-inline" class="delete_home_page">
                                                        <!--ng-click="delete_project(project.id,$index)"-->
                                                        <a href="">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <!-- END DIV COL-MD-6 -->
                                            </div>
                                            <!-- END DIV PROJECT_ICONS -->
                                            @endif @endif
                                                    <!--		<br><small><div id="div-inline"  class="begien_datum_home_page"><strong>Begindatum: </strong>@{{project.begin_datum}}</a></div></small> -->
                                            <!--		<small><div id="div-inline"  class="eind_datum_home_page"><strong>Einddatum: </strong>@{{project.eind_datum}}</a></div></small> -->
                                            <!--		<br><div id="div-inline"  class="begien_datum_home_page"><strong>Beschrijving: </strong>@{{project.beschrijving}}</a></div> -->
                                            <hr ng-if="!$last">
                                    </div>
                                </a>


                            </div>




                        @endif @else




                            <div class="panel-body" ng-repeat="project in projects_for_user"
                                 ng-class="is_tru_id(project.id,highlight_class)">
                                <a>
                                    <div id="div-project" ng-show="project.id" ng-click="show_project_info(project.id)">

                                        <h4 id="show-project" class="inline">
                                            <!--<a href="project/@{{project.id}}/view">-->
                                            @{{project.titel}}<!--</a>--></h4> @if(Auth::check()) @if(Auth::user()->is_adm)
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
                                                    <div id="div-inline" class="delete_home_page">
                                                        <!--ng-click="delete_project(project.id,$index)"-->
                                                        <a href="">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <!-- END DIV COL-MD-6 -->
                                            </div>
                                            <!-- END DIV PROJECT_ICONS -->
                                            @endif @endif
                                                    <!--		<br><small><div id="div-inline"  class="begien_datum_home_page"><strong>Begindatum: </strong>@{{project.begin_datum}}</a></div></small> -->
                                            <!--		<small><div id="div-inline"  class="eind_datum_home_page"><strong>Einddatum: </strong>@{{project.eind_datum}}</a></div></small> -->
                                            <!--		<br><div id="div-inline"  class="begien_datum_home_page"><strong>Beschrijving: </strong>@{{project.beschrijving}}</a></div> -->
                                            <hr ng-if="!$last">
                                    </div>
                                </a>


                            </div>


                            @endif
                                    <!-- END DIV PANEL-BODY -->
                    </div>
                    <!-- END DIV COLLAPSE1 -->

                    <div class="hole_project" ng-show="project">


                        <div id="carousel-container" class="col-md-12 col-xs-12">

                            <div id="main-pic" ng-repeat="foto in project.fotos" ng-if="$first"
                                 class="col-md-10 col-xs-10">


                                <img ng-src="{{Request::root()}}/img/project/@{{ foto.project_picture }}">
                            </div>
                            <div id="thumb-container">
                                <div id="thumb-scroll-up" class="col-md-2 col-xs-2 no-padding">
                                    <i class="fa fa-caret-up" aria-hidden="true"></i>
                                </div>
                                <div id="thumb-pic" class="col-md-2 col-xs-2 no-padding"
                                     ng-repeat="foto in project.fotos">
                                    <img ng-src="{{Request::root()}}/img/project/@{{ foto.project_picture }}">
                                </div>
                                <div id="thumb-scroll-down" class="col-md-2 col-xs-2 no-padding">
                                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>


                        <div id="project-info-container" class="col-md-12 col-xs-12">
                            <div id="project-beschrijving-container" class="col-md-10 col-xs-10">
                                <div id="project-beschrijving" class="col-md-12 col-xs-12">
                                    <h4 class="title_red title-font">Wat?</h4>
                                    <p>@{{ project.project.beschrijving }}</p>
                                </div>


                            </div>
                            <div id="project-side-container" class="col-md-2 col-xs-2">
                                <div id="project-side-date" class="col-md-12 col-xs-12">
                                    <h4 class="title_red title-font">Wanneer?</h4>
                                    <strong>Van</strong>
                                    <br> @{{ project.project.begin_datum }}
                                    <br>
                                    <strong>Tot</strong>
                                    <br> @{{ project.project.eind_datum }}

                                </div>

                            </div>
                            <div id="project-side-container" class="col-md-2 col-xs-2">
                                <div id="project-side-location" class="col-md-12 col-xs-12">
                                    <h4 class="title_red title-font">Waar?</h4> Meir, 15, Antwerpen, Belgium


                                </div>

                            </div>


                        </div>

                        <div id="project-info-container" class="col-md-12 col-xs-12">
                            <div id="project-beschrijving-container" class="col-md-10 col-xs-10">
                                <div id="project-beschrijving" class="col-md-12 col-xs-12">
                                    <h4 class="title_red title-font">Vragen</h4>
                                    <form>
                                        <div id="previous">
                                            <i class="fa fa-caret-left" aria-hidden="true"></i>
                                        </div>
                                        <div id="vraag-container">

                                            <div id="project-vraag" ng-repeat="vraag in project.vragen">
                                                <div id="project-vraag-content">
                                                    <h5 class="text-center">Vraag @{{ $index+1  }}
                                                        : @{{ vraag.vraag}}</h5>
                                                    <div ng-show="vraag.choices == 'open vragen'">
                                                        <textarea class="form-control" rows="5"
                                                                  name="antwoord_@{{ $index }}"></textarea>
                                                    </div>

                                                    <div ng-show="vraag.choices == 'meerkeuzevragen'">
                                                        <label>
                                                            <input type="checkbox"
                                                                   name="antwoord_@{{ $index }}"> @{{ vraag.mogelijke_antwoorden_1}}
                                                        </label>
                                                        <br>
                                                        <label>
                                                            <input type="checkbox"
                                                                   name="antwoord_@{{ $index }}"> @{{ vraag.mogelijke_antwoorden_2}}
                                                        </label>
                                                        <br>
                                                        <label>
                                                            <input type="checkbox"
                                                                   name="antwoord_@{{ $index }}"> @{{ vraag.mogelijke_antwoorden_3}}
                                                        </label>
                                                        <br>
                                                        <label>
                                                            <input type="checkbox"
                                                                   name="antwoord_@{{ $index }}"> @{{ vraag.mogelijke_antwoorden_4}}
                                                        </label>
                                                    </div>

                                                    <div ng-show="vraag.choices == 'Gesloten vragen'">
                                                        <label>
                                                            <input type="radio"
                                                                   name="antwoord_@{{ $index }}">@{{ vraag.mogelijke_antwoorden_1}}
                                                        </label>
                                                        <br>
                                                        <label>
                                                            <input type="radio"
                                                                   name="antwoord_@{{ $index }}">@{{ vraag.mogelijke_antwoorden_2}}
                                                        </label>
                                                    </div>

                                                    <div id="vraag-btn-submit" ng-if="$last">
                                                        <button class="form-control"> Verzend</button>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div id="next">
                                            <i class="fa fa-caret-right" aria-hidden="true"></i>
                                        </div>
                                    </form>
                                </div>


                            </div>
                            <div id="project-side-container" class="col-md-2 col-xs-2">
                                <div id="project-side-date" class="col-md-12 col-xs-12"
                                     ng-repeat="vraag in project.vragen" ng-if="$last">
                                    <h4 class="title_red title-font">Vraag</h4>
                                    <p>1/@{{ $index+1 }}</p>
                                    <div class="hidden">@{{ $index+1 }}</div>
                                </div>

                            </div>


                        </div>


                        <div id="project-info-container" class=" col-md-12 col-xs-12">
                            <div id="project-beschrijving-container" class="col-md-12 col-xs-12 no-padding">
                                <div id="project-beschrijving" class=" col-md-12 col-xs-12">

                                    <h4 class="title_red title-font">Commentaar</h4>


                                    <div id="reactie-container" class="col-md-12 no-padding"
                                         ng-repeat="reaction in project.reactions">
                                        <div id="user-info" class="col-md-1 no-padding">
                                            <img id="user-pic" src="{{Request::root()}}/img/userpic.gif"
                                                 alt="user-pic"/>
                                        </div>

                                        <div id="user-reactie" class="col-md-11">
                                            @if(Auth::check()) @if(Auth::user()->is_adm)
                                                <strong ng-show="reaction.user.name"> @{{ reaction.user.name }}</strong> <strong ng-hide="reaction.user.name"> Bezoeker</strong>   zei: <a href=""><i
                                                            class="fa fa-times" aria-hidden="true"></i> verwijder</a>
                                            @endif
                                            @endif
                                            <p>@{{ reaction.reaction.reactie_masseg }}</p>
                                        </div>

                                    </div>


                                    <form  name="reviewForm" ng-submit="reviewForm.$valid && submit_reaction(<?php if(Auth::check()){echo Auth::user()->id;}else{echo "null";}?>)" novalidate>

                                        <div id="reactie-container" class="pad-left col-md-11 no-padding pull-right">

                                            <div class="col-md-12 inline no-padding">

                                                <textarea class="w100 form-control" rows="5" name="naam" ng-model="reaction_post.massage" required></textarea>
                                            </div>
                                            <div id="star-rating" class="col-md-9 no-padding">
                                                <input id="rating" class="rating" data-size="xs" data-min="0"
                                                       data-max="5" data-step="1" ng-model="reaction_post.rating">
                                            </div>

                                            <div id="reactie-submit" class="pull-right col-md-3">
                                                <button type="submit" class="form-control" name="submit">Verzend
                                                </button>
                                            </div>


                                            <!--hire we gat error maseg if there somting went wrong with reviewing-->
                                            <div ng-show="project.post_error">@{{ project.post_error }}</div>


                                        </div>

                                    </form>

                                </div>


                            </div>


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
        @stop @section("map")
            <div id="map-container" ng-class='whatClassIsIt(project, "opacity-lower", "opacity-higher")'
                 class="col-md-6 hidden-xs" ng-init="map_initializetion(<?php if (isset($id)) {
                echo $id;
            } else {
                echo 0;
            } ?>)">
                <ui-gmap-google-map center="map.center" zoom="map.zoom" draggable="true" events="map.events">
                    <ui-gmap-markers models="locations" coords="'location'" idkey="'id'" events="map.marker_events">
                        @if (isset($id))
                            <ui-gmap-windows show="'show'">
                                <p ng-non-bindable> @{{ address }}</p>
                            </ui-gmap-windows>
                        @else
                            <ui-gmap-windows show="'show'">

                                <div ng-non-bindable>
                                    <diV>
                                        <img src="img/project/small_@{{ image }}" width="64" height="64">
                                        <h4 class="title_red">@{{ titel}}...</h4>
                                        <h5>@{{ discription }}...</h5>
                                        <p>@{{address }}</p>
                                    </diV>
                                </div>
                            </ui-gmap-windows>
                        @endif
                    </ui-gmap-markers>
                </ui-gmap-google-map>
            </div>
            <!--    <div id="map-container-editpage">
         <ui-gmap-google-map center="map.center" zoom="map.zoom"  draggable="true" events="map.events">
            <ui-gmap-markers models="locations" coords="'location'" idkey="'id'"  events="map.marker_events">
                <ui-gmap-windows show="'show'">
                    <p ng-non-bindable> @{{ address }}</p>
                </ui-gmap-windows>

            </ui-gmap-markers>
        </ui-gmap-google-map>
    </div>-->


            <!--    <div id="map-container-editpage">
         <ui-gmap-google-map center="map.center" zoom="map.zoom"  draggable="true" events="map.events">
            <ui-gmap-markers models="locations" coords="'location'" idkey="'id'"  events="map.marker_events">
                <ui-gmap-windows show="'show'">
                    <p ng-non-bindable> @{{ address }}</p>
                </ui-gmap-windows>

            </ui-gmap-markers>
        </ui-gmap-google-map>
    </div>-->



            <!--    <div id="mapContainer" class="col-xs-0 col-md-6">

                <div id="map-container">
                    <div id="map"></div>
                </div>
            </div>-->
@stop