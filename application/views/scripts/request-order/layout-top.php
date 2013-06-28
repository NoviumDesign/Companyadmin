<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?= $this->business ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="/css/jqueryui/jquery-ui-1.10.3.min.css">
        <link rel="stylesheet" href="/css/jqueryui/jquery-timepicker.css">
        <script src="/js/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <div class="navbar navbar-fixed-top" style="background-color:#<?= $this->color; ?>">
          <div class="container">
            <ul class="nav navbar-nav">
              <li><a href="http://<?= $this->companySite; ?>"><span class="glyphicon glyphicon-arrow-left"></span> Tillbaka till sajten</a></li>
            </ul>
            <a class="navbar-brand" href="#"><?= $this->business ?></a>
          </div>
        </div>

        <div class="container">