CTYPE html>

<html lang="en">

    <head>

        <title>Muhit UI kit</title>

        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="author" content="L Daniel Swakman, www.ldaniel.eu" />
        <meta charset="utf-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

        <!-- CSS dependencies -->
        <!-- <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" /> -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,400italic" />

        <!-- CSS files -->
        <link rel="stylesheet" href="/css/app.css" />

        <!-- JS dependencies -->
        <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-smooth-scroll/1.5.4/jquery.smooth-scroll.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.2/fastclick.min.js"></script>

        <!-- JS files -->
        <script src="/js/all.js"></script>

        <link href="/favicon.ico" type="image/x-icon" rel="icon" />
        <link href="/favicon.ico" type="image/x-icon" rel="shortcut icon" />

    </head>

    <body>

        <nav>
            <div class="row">
                <div class="col-xs-12 u-aligncenter">

                    <div class="userinfo hasDropdown u-floatright">
                        <a href="javascript:void(0)" id="userinfo" class="u-inlineblock">
                            <span class="badge badge-circle badge-user u-floatright u-ml10">
                                <i class="ion ion-person ion-2x"></i>
                            </span>
                            <span class="text">John Doe</span>
                        </a>
                        <div class="dropdown">
                            <ul>
                                <li><a href="#"><i class="ion ion-plus u-mr5"></i> Fikir ekle</a></li>
                                <li><a href="#"><i class="ion ion-person u-mr5"></i> Profilim</a></li>
                                <li><a href="#" id="logout"><i class="ion ion-log-out u-mr5"></i> Çıkış</a></li>
                            </ul>
                        </div>
                    </div>

                    <a href="#top" id="nav_logo" class="u-floatleft"><img src="/images/logo.png" height="60px" alt="" /></a>

                    <a href="#top" id="navbutton"><i class="ion ion-navicon ion-2x"></i></a>

                    <ul id="menu">
                        <li class="active"><a href=""><i class="ion ion-android-home ion-15x"></i>TÜMÜ</a></li>
                        <li><a href=""><i class="ion ion-thumbsup ion-15x"></i>DESTEKLEDİKLERİM</a></li>
                        <li><a href=""><i class="ion ion-lightbulb ion-15x"></i>FİKİRLERİM</a></li>
                        <li><a href=""><i class="ion ion-speakerphone ion-15x"></i>DUYURULAR</a></li>
                        <li><a href=""><i class="ion ion-information-circled ion-15x"></i>MUHTARIM</a></li>
                    </ul>

                </div>
            </div>
        </nav>

        <a href="javascript:void(0)" id="dialog_mask"></a>

        @include('dialogs.newidea')


        <main>

            @include('partials.header')


            @yield('content')
        </main>

        @include('partials.footer')
    </body>

</html>


