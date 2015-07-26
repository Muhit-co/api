<head>

    <title>{{ $pageTitle or '' }} MUHIT</title>

    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="L Daniel Swakman, www.ldaniel.eu" />
    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <?php $env = env('APP_ENV') ?>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,400italic" />

    <link rel="stylesheet" href="/css/app.css" />
    <script src="/js/all.js"></script>

    <link href="/images/favicon.ico" type="image/x-icon" rel="icon" />
    <link href="/images/favicon.ico" type="image/x-icon" rel="shortcut icon" />

    @include('partials.web-app-meta-tags')
    @include('partials.google-analytics')

    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?libraries=places">
    </script>

</head>
