<!DOCTYPE html>
<html lang="en" ng-app="antwerpen_project">

<head>
    <meta charset="utf-8">
    <title> foute pagina
    </title>


    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{Request::root()}}/css/base.css">
</head>

<body ng-controller="GoogleMapsController">

<style>
    #background {
        width: 100%;
        height: 100%;
        position: fixed;
        left: 0px;
        top: 0px;
        z-index: -1; /* Ensure div tag stays behind content; -999 might work, too. */
    }

    .stretch {
        width:100%;
        height:100%;
    }
    .margin_top{
       position: absolute;
        top:60%;
    }
    .size{
        min-height: 15%;
        min-width: 25%;

    }
    #btn-sign-in-404{
        background-color: transparent;
        border-radius: 0px;
        border-color: #DA291C;
        color: #fff;
        opacity: 0.5;
        font-size: 1.5em;
    }

    #btn-sign-in-404:hover{
        background-color: #DA291C;
        color: white;
        opacity: 1;
    }
</style>
{{--<img  class="col-md-12" src="img/404-page/404 still.jpg">--}}
<div id="background">
    <img src="img/404-page/404 still.jpg" class="stretch" alt="" />
</div>
<div class="container">
    <a href="{{Request::root()}}"> <button class="margin_top size btn btn-primary" id="btn-sign-in-404" name="submit" type="submit">Terug naar de start pagina</button></a>

</div>

</body>

</html>