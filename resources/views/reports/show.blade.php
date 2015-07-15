@extends('layouts.reports')
@section('content')

<section class="u-pv50">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="card">
                <div class="card-content u-clearfix">
                    <div class="col-sm-6 u-pv20">
                        <h1>
                            <i class="ion ion-clipboard u-mr15 c-light"></i>
                            <big>Beşiktaş</big>
                        </h1>
                        <div class="c-light u-mt20 u-ml50">
                            Kullanıcılar: 48<br />
                            Active since: 15 Aug 2015
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div id="donutchart" class="u-floatright">
                            <div class="chartloader">
                                <img src="/images/preloader.gif" alt="" class="u-valignmiddle u-ml50 u-mt5" />
                            </div>
                        </div>
                        <div class="chart-number u-floatright u-pa40 u-mr10">
                            <big class="u-mt10">184</big>
                            <label class="u-mt10 c-light">FİKİRLER</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-md-offset-1 col-md-push-5 col-sm-6 col-sm-push-6">
            <div class="list u-mv20">
                <div class="list-header">
                    <h4>En popüler fikerler</h4>
                </div>
                <ul class="list-content">
                    <li>
                        <a href="/">
                            <div class="u-floatright u-pl10">
                                <span class="c-blue">
                                    <i class="ion ion-thumbsup u-mr5"></i>
                                    <strong>217</strong>
                                </span>
                                <i class="ion ion-chevron-right u-ml10"></i>
                            </div>
                            <h4 class="title u-nowrap">
                                Sıraselviler daha yürünebilir bir cadde olsun.
                            </h4>
                        </a>
                    </li>
                    <li>
                        <a href="/">
                            <div class="u-floatright u-pl10">
                                <span class="c-inprogress">
                                    <i class="ion ion-wrench u-mr5"></i>
                                    <strong>89</strong>
                                </span>
                                <i class="ion ion-chevron-right u-ml10"></i>
                            </div>
                            <h4 class="title u-nowrap">
                                Besiktas Yildiz Sokagindaki kaldirimlar duzenlenmeli
                            </h4>
                        </a>
                    </li>
                    <li>
                        <a href="/">
                            <div class="u-floatright u-pl10">
                                <span class="c-solved">
                                    <i class="ion ion-thumbsup u-mr5"></i>
                                    <strong>48</strong>
                                </span>
                                <i class="ion ion-chevron-right u-ml10"></i>
                            </div>
                            <h4 class="title u-nowrap">
                                Daha çok Boğaz hattı vapur seferi olsun.
                            </h4>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-5 col-md-pull-5 col-sm-6 col-sm-pull-6">
            <div class="list u-mv20">
                <div class="list-header">
                    <h4>Mahalleleri <span class="u-ml10 c-light">7</span></h4>
                </div>
                <ul class="list-content">
                    <li>
                        <a href="/">
                            <div class="u-floatright u-pl10">
                                <span class="c-light">
                                    <i class="ion ion-lightbulb u-mr5"></i>
                                    45
                                </span>
                                <i class="ion ion-chevron-right u-ml20"></i>
                            </div>
                            <h4 class="title u-nowrap">
                                Etiler
                            </h4>
                        </a>
                    </li>
                    <li>
                        <a href="/">
                            <div class="u-floatright u-pl10">
                                <span class="c-light">
                                    <i class="ion ion-lightbulb u-mr5"></i>
                                    28
                                </span>
                                <i class="ion ion-chevron-right u-ml20"></i>
                            </div>
                            <h4 class="title u-nowrap">
                                Kuruçeşme
                            </h4>
                        </a>
                    </li>
                    <li>
                        <a href="/">
                            <div class="u-floatright u-pl10">
                                <span class="c-light">
                                    <i class="ion ion-lightbulb u-mr5"></i>
                                    19
                                </span>
                                <i class="ion ion-chevron-right u-ml20"></i>
                            </div>
                            <h4 class="title u-nowrap">
                                Gayrettepe
                            </h4>
                        </a>
                    </li>
                    <li>
                        <a href="/">
                            <div class="u-floatright u-pl10">
                                <span class="c-light">
                                    <i class="ion ion-lightbulb u-mr5"></i>
                                    15
                                </span>
                                <i class="ion ion-chevron-right u-ml20"></i>
                            </div>
                            <h4 class="title u-nowrap">
                                Bebek
                            </h4>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">

    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Fikir durumu', 'Meblağ'],
            ['Olusturuldu',     121],
            ['Gelişmekte',       48],
            ['Çözüldü',          15]
        ]);

        var options = {
            padding: 0,
            title: 'My Daily Activities',
            pieHole: 0.5,
            colors: ['#44a1e0', '#c678ea', '#27ae60'],
            legend: 'none',
            title: '',
            fontSize: 14,
            chartArea:{
                left:'5%',
                top:'5%',
                width:'90%',
                height:'90%'
            },
            pieSliceText:  'none',
            fontName: 'Source Sans Pro',
            tooltip:{
                text: 'value',
                textStyle: {
                    color: '#667',
                }
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
    }
</script>

@stop
