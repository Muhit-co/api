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

        <dialog id="dialog_newidea">
            <a href="javascript:void(0)" id="closeDialog"><i class="ion ion-ios-close-empty ion-3x u-floatright u-pinned-topright u-mr30 u-mt15"></i></a>
            <div class="dialog-content">
                    <h2>
                        You need to do something before you can continue.
                    </h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eleifend at tellus eget tristique.</p>

                    <div class="form-group form-fullwidth">
                        <label>Adınız</label>
                        <input type="text" class="form-input" value="" placeholder="Yazin..." />
                    </div>

                    <hr>

                    <div class="u-alignright">
                        <a href="javascript:void(0)" id="closeDialog" class="btn btn-tertiary u-mr10">VAZGEÇ</a>
                        <a href="javascript:void(0)" class="btn btn-secondary">KAYDET</a>
                    </div>

            </div>
        </dialog>

        <main>

            <header id="top">
            <div class="row u-pt40 u-pb60">
              <div class="col-md-4 col-sm-6">

                <!-- search issues -->
                <div class="form-group form-fullwidth">
                  <input type="text" class="form-input" value="" placeholder="Ara..." />
                  <a class="form-appendRight"><i class="ion ion-search ion-15x u-pa10"></i></a>
                </div>

                <!-- change mahalle -->
                <div class="form-group form-autosuggest form-fullwidth hasDropdown">
                  <input type="text" class="form-input" value="Erenköy, Kadıköy" />
                  <a class="form-appendRight"><i class="ion ion-chevron-down u-pa15"></i></a>
                  <div class="dropdown u-fullWidth">
                  <ul>
                    <li><a href="#"><b>Alt</b>ınşehir, Başakşehir</a></li>
                    <li><a href="#">Kart<b>alt</b>epe, Bakırköy</a></li>
                    <li><a href="#"><b>Alt</b>ıntepsi, Bayrampaşa</a></li>
                    <li><a href="#">Kart<b>alt</b>epe, Küçükçekmece</a></li>
                    <li><a href="#"><b>Alt</b>ayçeşme, M<b>alt</b>epe</a></li>
                    <li><a href="#"><b>Alt</b>ıntepe, M<b>alt</b>epe</a></li>
                    <li><a href="#" class="light">Daha yukle...</a></li>
                  </ul>
                  </div>
                </div>

              </div>
              <div class="col-md-8 col-sm-6">

                <div class="u-alignright">
                  <a href="javascript:void(0)" class="btn btn-primary" data-dialog="dialog_newidea"><i class="ion ion-plus u-mr5"></i> FİKİR EKLE</a>
                </div>

                <h1>Muhit</h1>

              </div>
            </div>
            </header>

            <section>
                <div class="row u-pv20">
                    <div class="col-md-4">
                        <div class="list list_block">
                            <div class="list-header"></div>
                            <ul>
                                <li><a href="javascript:void(0)">
                                    <p class="u-floatright"><small>1 Apr</small></p>
                                    Item 1
                                    <p>secondary info</p>
                                </a></li>
                                <li><a href="javascript:void(0)">
                                    <p class="u-floatright"><small>31 Mar</small></p>
                                    Item 2
                                    <p>secondary info</p>
                                </a></li>
                                <li><a href="javascript:void(0)">
                                    <p class="u-floatright"><small>30 Mar</small></p>
                                    Item 3
                                    <p>secondary info</p>
                                </a></li>
                                <li><a href="javascript:void(0)">
                                    <p class="u-floatright"><small>29 Mar</small></p>
                                    Item 4
                                    <p>secondary info</p>
                                </a></li>
                                <li><a href="javascript:void(0)">
                                    <p class="u-floatright"><small>28 Mar</small></p>
                                    Item 5
                                    <p>secondary info</p>
                                </a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-8">

                        <div class="flash flash-warning u-mb20">
                            <a href="javascript:void(0)"><i class="ion ion-android-close ion-15x u-floatright u-ml10 u-mb10"></i></a>
                            <i class="ion ion-information-circled ion-15x u-floatleft u-mr10 u-mb10"></i>
                            This idea is currently being moderated; therefore it is not possible to support or change its status.
                        </div>

                        <h1>Heading 1</h1>
                        <h2>Heading 2</h2>
                        <h3>Heading 3</h3>
                        <h4>Heading 4</h4>
                        <h5>Heading 5</h5>

                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eleifend at tellus eget tristique. Nullam scelerisque euismod mi, vel suscipit risus efficitur id. Aenean sit amet nisi vel ipsum volutpat porttitor sed eget urna. Morbi dictum ac purus nec imperdiet. Etiam ac tempus nisl. Pellentesque arcu justo, <a href="http://www.muhit.co" target="_blank">Inline text link</a> auctor ac odio ornare, dapibus congue ante. Phasellus tristique orci a fermentum ultricies. Maecenas faucibus bibendum magna. Pellentesque quis ornare quam.</p>

                        <a href="http://www.muhit.co" target="_blank">Muhit web</a><br /><br />

                        <a href="javascript:void(0)" class="btn btn-primary u-mr10"><i class="ion ion-plus"></i> FİKİR EKLE</a>
                        <a href="javascript:void(0)" class="btn btn-secondary u-mr10" data-dialog="dialog_newidea">FİKİR EKLE <i class="ion ion-android-open"></i></a>
                        <div class="hasDropdown u-inlineblock">
                            <a href="javascript:void(0)" class="btn u-mr10">HAREKETE GEÇ <i class="ion ion-chevron-down"></i></a>
                            <div class="dropdown">
                                <ul>
                                    <li><a href="#">Çayımı iç</a></li>
                                    <li><a href="#">Gelişmekte</a></li>
                                    <li><a href="#">Çözüldü</a></li>
                                    <li><a href="#">Yorum yaz</a></li>
                                </ul>
                            </div>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-tertiary u-mr10">VAZGEÇ</a>

                        <br /><br />

                        <div class="form-group">
                            <label>Adınız</label>
                            <input type="text" class="form-input" value="" placeholder="Yazin..." />
                        </div>

                        <div class="form-group">
                            <label>Adınız</label>
                            <input type="text" class="form-input" value="" placeholder="Yazin..." />
                        </div>

                        <div class="form-group">
                            <input type="checkbox" name="vehicle" value="agree" class="u-floatleft u-mr20">
                            <label for="checkbox">I agree with the <a href="javascript:void(0)">Terms of service</a>.</label>
                        </div>

                    </div>
                </div>
            </section>

        </main>

        <footer>
            <div class="row">
                <div class="col-sm-4">
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-4">
                </div>
            </div>
        </footer>

    </body>

</html>


