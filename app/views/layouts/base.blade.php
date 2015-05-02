<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>


    @section('head')

    <!-- Bootstrap Core CSS -->
    {{ HTML::style('css/bootstrap.min.css') }}
    <!-- Custom CSS -->
    {{ HTML::style('css/agency.css') }}

    <!-- LADDA CSS -->
    {{ HTML::style('css/ladda.css') }}

    <!-- Custom Fonts -->
    {{ HTML::style('font-awesome/css/font-awesome.min.css') }}
<!--    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>-->

@show
</head>
<body id="page-top" class="index">
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">Start Bootstrap</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#services">Services</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#portfolio">Portfolio</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#about">About</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#team">Team</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact">Contact</a>
                    </li>
                    @if ( Auth::id())
                    <li>
                        <a href="{{ url('logout') }}">LOGOUT</a>
                    </li>
                    @else
                     <li>
                        <a href="{{ url('login') }}">LOGIN</a>
                     </li>    
                    @endif
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>


	@yield('body')
</body>


	@section('all_script')

		    <!-- jQuery -->
    {{ HTML::script('js/jquery.js')}}

    <!-- Bootstrap Core JavaScript -->
    {{ HTML::script('js/bootstrap.min.js')}}

    <!-- Plugin JavaScript -->
    {{ HTML::script('js/juqery-easing.js')}}
    {{ HTML::script('js/classie.js')}}
    {{ HTML::script('js/cbpAnimatedHeader.js')}}

    <!-- Contact Form JavaScript -->
    {{ HTML::script('js/jqBootstrapValidation.js') }}

    <!-- Custom Theme JavaScript -->
    {{ HTML::script('js/agency.js')}}
    <!-- bootbox -->
    {{ HTML::script('js/bootbox.min.js')}}

    <!-- ladda -->
    {{ HTML::script('js/spin.min.js')}}
    <!-- bootbox -->
    {{ HTML::script('js/ladda.min.js')}}
   

	@show
</html>