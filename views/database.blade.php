<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <style>
        body {
            padding-top: 60px;
            padding-bottom: 40px;
        }
        footer {
                height:100px;
                color: #666;
                background: #222;
                padding: 17px 0 18px 0;
        }
    </style>
    {{ Asset::container('bootstrapper')->styles() }}
    {{ Asset::container('juploader')->styles() }}
    {{ Asset::container('juploader-gallery')->styles() }}
    {{ HTML::script('js/modernizr-2.6.1-respond-1.1.0.min.js') }}
    
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('img/apple-touch-icon-144-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('img/apple-touch-icon-114-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('img/apple-touch-icon-72-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('img/apple-touch-icon-57-precomposed.png') }}">
</head>
<body>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
    <![endif]-->

    <!-- This code is taken from http://twitter.github.com/bootstrap/examples/hero.html -->
    
    <div class="wrapper">
    <div class="container">
        <div class="hero-unit">
            <h1>jUploader for Laravel</h1>
            <h2>Demos</h2>
            <p>Follow the links to play with the demo</p>
              <a href="/upload/demo/0" class="btn btn-primary">Simple Demo</a>
              <a href="/upload/demo/1" class="btn btn-primary">Demo 1</a>
              <a href="/upload/demo/2" class="btn btn-primary">Demo 2</a>
              <a href="/upload/demo/3" class="btn btn-primary">Demo 3</a>
              <a href="/upload/demo/4" class="btn btn-primary">Database Demo</a>
        </div>

        @yield('content')

    </div> <!-- /wrapper -->
    </div> <!-- /wrapper -->
    <div class="push"><!-- / / --></div> <!-- /push -->
    <footer>
        <p>&copy; pasqualevazzana@gmail.com</p>
    </footer> <!-- /footer -->
        
    <!-- begin javascript -->
    {{ Asset::container('bootstrapper')->scripts() }}
    {{ Asset::container('juploader')->scripts() }}
    {{ Asset::container('juploader-gallery')->scripts() }}
    {{ Uploader\Javascripter::with_option('url','/upload/dbupload')->with_option('formId','dbfileupload')->activate_uploader() }}
</body>
</html>