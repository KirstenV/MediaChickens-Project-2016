@extends('layout') @section('homeContent')


<div id="homeContainer" class=" col-xs-12 col-sm-6 col-md-6 width-transition no-padding" ng-class='whatClassIsIt(project, "col-md-8", "col-md-6")'>


    <div ng-controller="projectController">
        <div id="project-fase" class="text-center closed-fase" ng-show="project">

            <div id="arrow-box-top" ng-repeat="fase in project.fases" ng-if="$first">
                
                <i class="fa fa-chevron-left" aria-hidden="true"></i>

            </div>


            <div class="arrow-box-cell" ng-repeat="fase in project.fases">
                <div ng-class="fase_classes(fase.fases)" class="arrow-box first" ng-if="$first">

                    <p>fase</p>
                    <p class="lrg"><strong>@{{$index+1}}</strong></p>
                </div>

                <div ng-class="fase_classes(fase.fases)" class="arrow-box" ng-if="!$first">

                    <p>fase</p>
                    <p class="lrg"><strong>@{{$index+1}}</strong></p>
                </div>


                <div class="arrow-box-right" ng-class="fase_classes(fase.fases)">


                    <h4 class="title-font title_red">@{{fase.fase_titel}}</h4>


                    <img ng-if="fase.fases_picture != 'fases_picture_default.jpg'" ng-src="{{Request::root()}}/img/fase/@{{fase.fases_picture}}" />


                    <p>@{{fase.fase_beschrijving}} </p>
                </div>

            </div>

            <div id="arrow-box-bottom" hidden="true">
                <i class="fa fa-chevron-down" aria-hidden="true"></i>

            </div>



        </div>

    </div>



    <div id="project-titel" class="col-md-12 col-xs-12" ng-show="project">
        <div id="project-back" class="vert-center div-left" ng-click="show_projects()"><i class="fa fa-chevron-right inline vert-center" aria-hidden="true"></i>
            <div id="project-back-text" class="inline vert-center">TERUG</div>
        </div>

        <h1 id="project-titel-content">
                        <strong>@{{ project.project.titel }}</strong>
                    
                    </h1>
        <img ng-if="project.review_rating_sum" ng-src="{{Request::root()}}/img/project/@{{ project.review_rating_sum | number : 0 }}-rating-total.png" />

    </div>




    <div id="projectContainer" ng-controller="projectController">




        @if(Auth::check()) @if(Auth::user()->is_adm)
        <div id="editable" class="col-md-6 col-xs-12 col-sm-6" ng-hide="project">
            <div class="row">
                <i class="fa fa-plus col-md-12" aria-hidden="true"></i>
            </div>
            <div class="row">
                <h4 id="add_project" data-toggle="tooltip" data-placement="right" data-title="Klik en typ een naam" class="nieuw_project col-md-12 col-xs-12 inline" contenteditable='true'>Nieuw project toevoegen</h4>
            </div>
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
            <div class="">

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


                    @if(Auth::check()) @if(Auth::user()->is_adm)

                    <div class="panel-body no-padding" ng-repeat="project in projects" ng-class="is_tru_id(project.id,highlight_class)">
                        <a href="">
                            <div id="panel-body-text" class="col-md-10 col-xs-9 col-sm-10" ng-show="project.id" ng-click="show_project_info(project.id)">

                                <h4 id="show-project" class="inline">
                                            <!--<a href="project/@{{project.id}}/view">-->
                                            @{{project.titel}}<!--</a>--></h4>



                            </div>
                        </a>
                        <div id="panel-body-icons" class="col-md-2 col-xs-3 col-sm-2 text-center no-padding">
                            <a href="project/@{{project.id}}/edit" title="wijzig project">
                                <div class="edit_home_page col-md-6 col-sm-6 col-xs-6 no-padding">

                                    <i class="fa fa-pencil" aria-hidden="true"></i>

                                </div>
                            </a>
                            <!-- END DIV COL-MD-6 -->
                            <a href="" ng-click="delete_project(project.id,$index)">
                                <div class="delete_home_page col-md-6 col-xs-6 col-sm-6 no-padding">
                                    <!--ng-click="delete_project(project.id,$index)"-->

                                    <i class="fa fa-trash" aria-hidden="true"></i>

                                </div>
                            </a>
                            <!-- END DIV COL-MD-6 -->
                        </div>
                        <!-- END DIV PROJECT_ICONS -->

                    </div>
                    @else


                    <div class="panel-body no-padding" ng-repeat="project in projects_for_user" ng-class="is_tru_id(project.id,highlight_class)">
                        <a href="">
                            <div id="panel-body-text" class="col-md-12 col-xs-12 col-sm-12" ng-show="project.id" ng-click="show_project_info(project.id)">

                                <h4 id="show-project" class="inline">
                                            <!--<a href="project/@{{project.id}}/view">-->
                                            @{{project.titel}}<!--</a>--></h4>



                            </div>
                        </a>


                    </div>




                    @endif @else




                    <div class="panel-body no-padding" ng-repeat="project in projects_for_user" ng-class="is_tru_id(project.id,highlight_class)">
                        <a href="">
                            <div id="panel-body-text" class="col-md-12 col-xs-12 col-sm-12" ng-show="project.id" ng-click="show_project_info(project.id)">

                                <h4 id="show-project" class="inline">
                                            <!--<a href="project/@{{project.id}}/view">-->
                                            @{{project.titel}}<!--</a>--></h4>



                            </div>
                        </a>


                    </div>


                    @endif
                    <!-- END DIV PANEL-BODY -->
                </div>
                <!-- END DIV COLLAPSE1 -->

                <div class="hole_project" ng-show="project">


                    <div id="carousel-container" class="col-md-12 col-xs-12">

                        <div id="main-pic" ng-repeat="foto in project.fotos" ng-if="$first" class="col-md-10 col-xs-10">


                            <img ng-src="{{Request::root()}}/img/project/@{{ foto.project_picture }}">

                        </div>
                        <div id="main-pic" ng-show="!project.fotos.length" class="col-md-10 col-xs-10">
                            <img src="{{Request::root()}}/img/project/default-project-img.png">
                        </div>


                        <div id="thumb-container">
                            <div id="thumb-scroll-up" class="col-md-2 col-xs-2 no-padding">
                                <i class="fa fa-caret-up" aria-hidden="true"></i>
                            </div>
                            <div id="thumb-pic" class="col-md-2 col-xs-2 no-padding" ng-repeat="foto in project.fotos">
                                <img ng-src="{{Request::root()}}/img/project/@{{ foto.project_picture }}">
                            </div>
                            <div id="thumb-scroll-down" class="col-md-2 col-xs-2 no-padding">
                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>


                    <div id="project-info-container" class="col-md-12 col-xs-12 project-wat">
                        <div id="project-beschrijving-container" class="col-md-10 col-xs-12 mobile project-wat">
                            <div id="project-beschrijving" class="col-md-12 col-xs-12">
                                <h4 class="title_red title-font">Wat?</h4>
                                <p>@{{ project.project.beschrijving }}</p>
                            </div>


                        </div>
                        <div class="col-md-2 no-padding">
                            <div id="project-side-container" class="col-md-12 col-xs-12 project-wanneer">
                                <div id="project-side-date" class="col-md-12 col-xs-12">
                                    <h4 class="title_red title-font">Wanneer?</h4>
                                    <strong>Van</strong>
                                    <br> @{{ project.project.begin_datum }}
                                    <br>
                                    <strong>Tot</strong>
                                    <br> @{{ project.project.eind_datum }}

                                </div>

                            </div>
                            <div id="project-side-container" class="col-md-12 col-xs-12">
                                <div id="project-side-location" class="col-md-12 col-xs-12">
                                    <h4 class="title_red title-font">Waar?</h4>

                                    <div ng-repeat="locatie in project.locaties">
                                        <p> @{{ locatie.straat_naam }}
                                            <hr ng-if="!$last">
                                        </p>
                                    </div>




                                </div>

                            </div>
                        </div>

                    </div>

                    <div id="project-info-container" class="col-md-12 col-xs-12" ng-show="answer_post_succes">
                        <div id="project-beschrijving-container" class="col-md-12 col-xs-12 no-padding">
                            <div id="project-beschrijving" class="col-md-12 col-xs-12 vraag-success text-center">
                                @{{ answer_post_succes }}
                            </div>
                        </div>
                    </div>


                    <div ng-show="project.vragen.length" id="project-info-container" class="col-md-12 col-xs-12" ng-hide="answer_post_succes">
                        <div id="project-beschrijving-container" class="col-md-12 col-xs-12 no-padding">
                            <div id="project-beschrijving" class="col-md-12 col-xs-12 vraag-cont">


                                <div class="pull-right" ng-repeat="vraag in project.vragen" ng-if="$last">
                                    <p id="vraag-huidig">Vraag 1 van @{{ $index+1 }}</p>

                                    <div id="vraag-totaal" class="hidden">@{{ $index+1 }}</div>
                                </div>



                                <h4 class="title_red title-font">Vragen</h4>




                                <form name="answerFrom" ng-submit="answers_post(project.vragen)">
                                    <div id="previous">
                                        <i class="fa fa-caret-left" aria-hidden="true"></i>
                                    </div>
                                    <div id="vraag-container">

                                        <div id="project-vraag" ng-repeat="vraag in project.vragen">
                                            <div id="project-vraag-content">
                                                <h5 class="text-center">Vraag @{{ $index+1  }}
                                                        : @{{ vraag.vraag}}</h5>
                                                <div ng-show="vraag.choices == 'open vragen'">
                                                    <textarea class="form-control" rows="5" name="antwoord_@{{ $index }}" ng-model="questions_answer[vraag.id].answer[0]"></textarea>
                                                </div>

                                                <div ng-show="vraag.choices == 'meerkeuzevragen'">
                                                    <label>
                                                        <input type="checkbox" name="antwoord_@{{ $index }}" ng-model="questions_answer[vraag.id].answer[vraag.mogelijke_antwoorden_1]" ng-value=""> @{{ vraag.mogelijke_antwoorden_1}}
                                                    </label>
                                                    <br>
                                                    <label>
                                                        <input type="checkbox" name="antwoord_@{{ $index }}" ng-model="questions_answer[vraag.id].answer[vraag.mogelijke_antwoorden_2]" ng-value="vraag.mogelijke_antwoorden_2"> @{{ vraag.mogelijke_antwoorden_2}}
                                                    </label>
                                                    <br>
                                                    <label>
                                                        <input type="checkbox" name="antwoord_@{{ $index }}" ng-model="questions_answer[vraag.id].answer[vraag.mogelijke_antwoorden_3]" ng-value="vraag.mogelijke_antwoorden_3"> @{{ vraag.mogelijke_antwoorden_3}}
                                                    </label>
                                                    <br>
                                                    <label>
                                                        <input type="checkbox" name="antwoord_@{{ $index }}" ng-model="questions_answer[vraag.id].answer[vraag.mogelijke_antwoorden_4]" ng-value="vraag.mogelijke_antwoorden_4"> @{{ vraag.mogelijke_antwoorden_4}}
                                                    </label>
                                                </div>

                                                <div ng-show="vraag.choices == 'Gesloten vragen'">
                                                    <label>
                                                        <input type="radio" name="antwoord_@{{ $index }}" ng-model="questions_answer[vraag.id].answer[0]" ng-value="vraag.mogelijke_antwoorden_1">@{{ vraag.mogelijke_antwoorden_1}}
                                                    </label>
                                                    <br>
                                                    <label>
                                                        <input type="radio" name="antwoord_@{{ $index }}" ng-model="questions_answer[vraag.id].answer[0]" ng-value="vraag.mogelijke_antwoorden_2">@{{ vraag.mogelijke_antwoorden_2}}
                                                    </label>
                                                </div>

                                                <div id="vraag-btn-submit" ng-if="$last">
                                                    <button class="form-control"> Verzend</button>
                                                </div>
                                            </div>
                                            <div ng-show="answer_post_error">@{{ answer_post_error }}</div>
                                        </div>

                                    </div>
                                    <div id="next">
                                        <i class="fa fa-caret-right" aria-hidden="true"></i>
                                    </div>
                                </form>
                            </div>


                        </div>



                    </div>


                    <div id="project-info-container" class=" col-md-12 col-xs-12">
                        <div id="project-beschrijving-container" class="col-md-12 col-xs-12 no-padding marg-bottom">
                            <div id="project-beschrijving" class=" col-md-12 col-xs-12">

                                <h4 class="title_red title-font">Commentaar</h4>
                                <form name="reviewForm" ng-submit="reviewForm.$valid && submit_reaction(<?php if (Auth::check()) {
                                              echo Auth::user()->id;
                                          } else {
                                              echo " null ";
                                          }?>)" data-toggle="validator">

                                    <div id="reactie-container" class="col-md-11 col-xs-11 no-padding pull-right">

                                        <div class="col-md-12 col-xs-12 inline no-padding">

                                            <textarea class="w100 form-control" rows="5" name="naam" ng-model="reaction_post.massage" required></textarea>
                                        </div>
                                        <div id="star-rating" class="col-md-9 col-xs-9 no-padding">
                                            <input id="rating" class="rating" data-size="xs" data-min="0" data-max="5" data-step="1">
                                        </div>

                                        <div id="reactie-submit" class="pull-right col-md-3 col-xs-3">
                                            <button type="submit" class="form-control" name="submit">Verzend
                                            </button>
                                        </div>


                                        <!--hire we gat error maseg if there somting went wrong with reviewing-->
                                        <div class="error-message" ng-show="project.post_error">@{{ project.post_error }}</div>


                                    </div>

                                </form>

                                <div id="reactie-container" class="col-md-12 col-xs-12 no-padding" ng-repeat="reaction in project.reactions">
                                    <div id="user-info" class="col-md-1 col-xs-1">
                                        <img id="user-pic" src="{{Request::root()}}/img/userpic.gif" alt="user-pic" />
                                    </div>

                                    <div id="user-reactie" class="col-md-11 col-xs-11">
                                        <div class="arrow"> </div>
                                        @if(Auth::check()) @if(Auth::user()->is_adm)
                                        <a href="" ng-click="delete_review(reaction.reaction.id,$index)"><i
                                                            class="fa fa-times" aria-hidden="true"></i> verwijder</a> @endif @endif
                                        <div class="pull-right">
                                            <img ng-src="{{Request::root()}}/img/project/@{{ reaction.reaction.rating }}-rating.png" />
                                        </div>
                                        <strong ng-show="reaction.user.name"> @{{ reaction.user.name }}</strong>
                                        <strong ng-hide="reaction.user.name"> Anoniem</strong>
                                        <p>"@{{ reaction.reaction.reactie_masseg }}"</p>
                                    </div>


                                </div>
                                <div class="row text-center">
                                    <div id="toon-reactie" class="text-center" ng-click="get_more_reviews()" ng-hide="get_mor_reviews">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Laad meer reacties
                                    </div>
                                </div>


                            </div>


                        </div>


                    </div>




                </div>
                <!--end div evreting obout project-->







            </div>
            <!-- END DIV PANEL PANEL-DEFAULT -->



        </div>
        <!-- END DIV ACCORDION -->





        <div id="footer" ng-show="project">
            <p>© 2016 Mediachickens™. Alle rechten voorbehouden</p>
            <p><a href="">Download de app!</a></p>

        </div>

    </div>
    @stop @section("map")
    <div id="map-container" ng-class='whatClassIsIt(project, "opacity-lower", "opacity-higher")' class="col-md-6 col-sm-6 hidden-xs" ng-init="map_initializetion(<?php if (isset($id)) {
                echo $id;
            } else {
                echo 0;
            } ?>)">
        <ui-gmap-google-map center="map.center" zoom="map.zoom" draggable="true" events="map.events">
            <ui-gmap-markers models="locations" coords="'location'" options="map.options" idkey="'id'" events="map.marker_events">
                @if (isset($id))
                <ui-gmap-windows show="'show'">
                    <p ng-non-bindable> @{{ address }}</p>
                </ui-gmap-windows>
                @else
                <ui-gmap-windows show="'show'">

                    <div id="maps-infowindow" ng-non-bindable>
                        <div class="row text-center" id="maps-infowindow-title">
                            <div class="col-md-12">
                                <h4 class="title-font">@{{ titel}}...</h4>
                            </div>


                        </div>
                        <div class="row">
                            <diV class="col-md-6">


                                <p><strong>@{{address }}</strong></p>

                                <p>@{{ discription }}...</p>

                            </diV>
                            <div class="col-md-6">
                                <img src="img/project/small_@{{ image }}" width="200px">
                            </div>
                        </div>
                    </div>
                </ui-gmap-windows>
                @endif
            </ui-gmap-markers>
        </ui-gmap-google-map>
    </div>

    @stop