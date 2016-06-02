<!DOCTYPE html>
<html lang="en" ng-app="antwerpen_project">

<head>
    <meta charset="utf-8">
    <title> foute pagina
    </title>


    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">

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
</style>
{{--<img  class="col-md-12" src="img/404-page/404 still.jpg">--}}
<div id="background">
    <img src="img/404-page/404 still.jpg" class="stretch" alt="" />
</div>
</body>

</html>