<!DOCTYPE HTML>

<html>
    <head>
        <title>@yield('title')</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        @yield('meta')
        <!--[if lte IE 8]><script src="{{url('/')}}/assets/js/ie/html5shiv.js"></script><![endif]-->
        <link rel="stylesheet" href="{{url('/')}}/assets/css/main.css" />
        <link rel="stylesheet" href="{{url('/')}}/assets/css/jquery-ui.min.css" />
        @yield('css')
    </head>
    <body class="dashboard">
    @include('flash::message')
        <div id="page-wrapper">
            <div id="loader">
                <div id="loader-filler"></div>
                <div id="loader-cover"></div>
            </div>
            <!-- Header -->
                <header id="header">
                    @yield('header')
                </header>

            <!-- Main -->
                <article id="main">
                    @yield('content')
                </article>

            

            <!-- Footer -->
                <footer id="footer">
                   <p>&copy; Copyright {{date('Y')}} Talal Trading & Contracting Co.
                </footer>
        </div>
         
    @yield('modal')
        <!-- Scripts -->
            <script src="{{url('/')}}/assets/js/jquery.min.js"></script>
            <script src="{{url('/')}}/assets/js/jquery-ui.min.js"></script>
            <script src="{{url('/')}}/assets/js/jquery.leanModal.min.js"></script>
            <script src="{{url('/')}}/assets/js/skel.min.js"></script>
            <script src="{{url('/')}}/assets/js/skel-layout.min.js"></script>
            <script src="{{url('/')}}/assets/js/util.js"></script>
            <!--[if lte IE 8]><script src="{{url('/')}}/assets/js/ie/respond.min.js"></script><![endif]-->
            <script src="{{url('/')}}/assets/js/main.js"></script>
            <script type="text/javascript">
                @yield('script')
            </script>
    </body>
</html>