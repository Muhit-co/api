<head>

    <title>{{ $pageTitle or '' }} {{trans('intro.fb_meta_sitename') }}</title>

    <meta name="description" content="{{ trans('intro.meta_description') }}" />
    <meta name="keywords" content="{{ trans('intro.meta_keywords') }}" />
    <meta name="author" content="Muhit" />
    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <?php $env = env('APP_ENV') ?>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,400italic" />

    <link rel="stylesheet" href="/css/app.css" />
    <script src="/js/all.js"></script>

    <link href="/images/favicon.ico" type="image/x-icon" rel="icon" />
    <link href="/images/favicon.ico" type="image/x-icon" rel="shortcut icon" />

    <!-- Facebook post image -->
    <meta property="og:image" content="{{ asset('/images/fb-share-image.jpg') }}" />
    <meta property="og:title" content="{{ trans('intro.fb_meta_title') }}" />
    <meta property="og:site_name" content="{{ trans('intro.fb_meta_sitename') }}" />
    <meta property="og:description" content="{{ trans('intro.meta_description') }}" />

    @include('partials.web-app-meta-tags')
    @include('partials.google-analytics')

    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?libraries=places">
    </script>

</head>
