@extends('layouts.reports')
@section('content')


<?php 
// NB. TEMPORARY! Data should come from controller
// Format: array of tags used in ideas in municipality/neighbourhood, sorted by issue count
$tags = [
    [
        'name' => 'Trafik',
        'background' => 'ea6e4b',
        'issue_count' => 118
    ],
    [
        'name' => 'Toplu Taşıma',
        'background' => '8865a8',
        'issue_count' => 72
    ],
    [
        'name' => 'Ağaçlandırma',
        'background' => 'a6cb80',
        'issue_count' => 71
    ],
    [
        'name' => 'Aydınlatma',
        'background' => 'efdc34',
        'issue_count' => 48
    ],
    [
        'name' => 'Geri dönüşüm',
        'background' => 'b6d782',
        'issue_count' => 32
    ],
    [
        'name' => 'Eğitim',
        'background' => '6b8fc9',
        'issue_count' => 30
    ],
];
?>

<section class="u-pv20">
    <div class="row">
        <div class="col-xs-12">
            <div class="card u-mb20" style="overflow: visible;">
                <div class="card-content u-ph5 u-clearfix">
                    <div class="col-xs-12 col-sm-7">
                        <i class="ion ion-clipboard ion-15x u-mr15 c-light u-floatleft"></i>
                        <div class="u-ml30">
                            <h4 class="u-lineheight30 c-light">{{ trans('reports.municipality_report_cap') }}</h4>
                            <div class="u-flex">
                                <h1 class="h--light u-mt5 c-bluedark"><big>{{$district->name}}</big></h1>
                                <big class="u-block c-bluedark u-mt15 u-ml15">{{$district->city->name}}</big>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-5 u-flex">

                        <div class="form-group hasIconRight u-relative u-mr10">
                            <select class="form-input form-outline u-pr20">
                                <option selected>{{ trans('issues.all') }}</option>
                                {{-- // NB. TEMPORARY! Should be last 12 months  --}}
                                <option>{{strftime('%B %Y', strtotime("10/01/2017"))}}</option>
                                <option>{{strftime('%B %Y', strtotime("09/01/2017"))}}</option>
                                <option>{{strftime('%B %Y', strtotime("08/01/2017"))}}</option>
                                <option>{{strftime('%B %Y', strtotime("07/01/2017"))}}</option>
                                <option>{{strftime('%B %Y', strtotime("06/01/2017"))}}</option>
                                <option>{{strftime('%B %Y', strtotime("05/01/2017"))}}</option>
                                <option>{{strftime('%B %Y', strtotime("04/01/2017"))}}</option>
                                <option>{{strftime('%B %Y', strtotime("03/01/2017"))}}</option>
                                <option>{{strftime('%B %Y', strtotime("02/01/2017"))}}</option>
                                <option>{{strftime('%B %Y', strtotime("01/01/2017"))}}</option>
                                <option>{{strftime('%B %Y', strtotime("12/01/2016"))}}</option>
                                <option>{{strftime('%B %Y', strtotime("11/01/2016"))}}</option>
                            </select>
                            <div class="form-appendRight u-aligncenter u-width30 u-pr15 u-mt5">
                                <i class="ion ion-chevron-down"></i>
                            </div>
                        </div>

                        @include('partials.report-actions', array('district' => $district))

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <div class="card-content u-pa0 u-clearfix">
                    <div class="col-xs-12 col-sm-5 u-pv20 c-light">

                        <div class="u-flex">
                            <div style="display: flex; flex-basis: 50%; flex-direction: column; justify-content: center;">
                                <h4 class="chart-number h--light u-aligncenter c-light u-mb5">
                                    {!! trans('issues.n_ideas_cap', ['number' => sizeof($popularIssues)]) !!}
                                </h4>
                                {{-- // @aniluyg TODO: Click on section to filter idea list & map --}}
                                <div id="chart_ideas">
                                    <div class="chartloader">
                                        <img src="/images/preloader.gif" alt="" class="u-valignmiddle u-ml50" />
                                    </div>
                                </div>
                            </div>
                            <div style="display: flex; flex-basis: 50%; flex-direction: column; justify-content: center;">
                                <h4 class="chart-number h--light u-aligncenter c-light u-mb5">
                                    {{ trans('reports.categories_cap') }}
                                </h4>
                                {{-- // @aniluyg TODO: Click on section to filter idea list & map --}}
                                <div id="chart_categories">
                                    <div class="chartloader">
                                        <img src="/images/preloader.gif" alt="" class="u-valignmiddle u-ml50" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row row-nopadding u-mt20 u-lineheight30">
                            <div class="col-xs-7">
                                <i class="ion ion-ios-people ion-15x c-light u-width40 u-aligncenter u-floatleft u-mr10"></i>
                                {{ trans('issues.users') }}
                            </div>
                            <div class="col-xs-5">
                                <strong class="c-blue">222</strong>
                            </div>

                            <div class="col-xs-7">
                                <i class="ion ion-ios-person ion-15x c-light u-width40 u-aligncenter u-floatleft u-mr10"></i>
                                {{ trans('reports.admins') }}
                            </div>
                            <div class="col-xs-5">
                                <strong class="c-blue">3</strong>
                            </div>

                            <div class="col-xs-7">
                                <i class="ion ion-ios-clock-outline ion-15x c-light u-width40 u-aligncenter u-floatleft u-mr10"></i>
                                {{ trans('reports.active_since') }}
                            </div>
                            <div class="col-xs-5">
                                <strong class="c-blue">15 Ağu 2015</strong>
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-12 col-sm-7" style="background-size: cover; background-position: center; background-image: url('/images/mockup-map-kadikoy.jpg'); min-height: 40vh;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-xs-12 col-md-4">
            <div class="list list-small u-mv20">
                <div class="list-header">

                    <div class="form-group u-floatright hasIconRight u-relative" style="width: 105px; min-width: 0; margin-top: -7px;">
                        {{-- // @aniluyg TODO: On select, filter idea list & map --}}
                        <select id="issueTypeOption" class="form-input form-small form-outline u-mt5 u-pr20">
                            <option value="all" selected>{{ trans('issues.all') }}</option>
                            <option value="new">{{ trans('issues.created') }}</option>
                            <option value="in-progress">{{ trans('issues.in_progress') }}</option>
                            <option value="solved">{{ trans('issues.solved') }}</option>
                        </select>
                        <div class="form-appendRight u-aligncenter u-width30 u-pr10 c-light" style="margin-top: 7px;">
                            <i class="ion ion-chevron-down"></i>
                        </div>
                    </div>

                    <h4>{{ trans('issues.ideas') }}</h4>

                </div>

                <ul class="list-content" id="issueListContainer">
                    @include('partials.report-issues', ['popularIssues' => $popularIssues])
                </ul>

            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="list list-small u-mv20">
                <div class="list-header">
                    <h4>{{ trans('reports.categories') }}</h4>
                </div>
                <ul class="list-content">

                    @foreach($tags as $tag)
                        <li>
                            <a href="?tag={{ urlencode($tag['name']) }}">
                                <div class="u-floatright u-pl10">
                                    <span class="c-light">
                                        <i class="ion ion-lightbulb u-mr5"></i>
                                        {{ $tag['issue_count'] }}
                                    </span>
                                </div>
                                <span class="tag u-floatleft u-mr5" style="background-color: #{{ $tag['background'] }};">
                                    {!! $tag['name'] !!}
                                </span>
                            </a>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="list list-small u-mv20">
                <div class="list-header">
                    <h4>{{ trans('reports.neighbourhoods') }} <span class="u-ml10 c-light">{{sizeof($hoods)}}</span></h4>
                </div>
                <ul class="list-content">

                    @foreach($hoods as $hood)
                        <li>
                            <a href="/report/hood/{{ $hood['id'] }}">
                                <div class="u-floatright u-pl10">
                                <span class="c-light">
                                    <i class="ion ion-lightbulb u-mr5"></i>
                                    {{$hood['issueCount']}}
                                </span>
                                    <i class="ion ion-chevron-right u-ml20"></i>
                                </div>
                                <h4 class="title u-nowrap">
                                    {{$hood['name']}}
                                </h4>
                            </a>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
    </div>
</section>

<!--Load the AJAX API-->
<script type="text/javascript" src="//www.google.com/jsapi"></script>
<script type="text/javascript">

    google.load("visualization", "1", {packages:["corechart"]});

    function drawChart(target, source_data, custom_options) {
        var data = google.visualization.arrayToDataTable(source_data);

        var options = {
            padding: 0,
            pieHole: 0.5,
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
            },
        };

        for (var key in custom_options) {
            if (custom_options.hasOwnProperty(key)) {
                options[key] = custom_options[key];
            }
        }

        var chart = new google.visualization.PieChart(document.getElementById(target));

        // Adding click handler
        google.visualization.events.addListener(chart, 'select', function() {
            selectedItem = chart.getSelection()[0];
            if(selectedItem) {
                selectedStatus = source_data[selectedItem.row + 1][2];
                filterReportIdeasBy( selectedStatus );
            }
        });

        chart.draw(data, options);
    }


    idea_chart_options = {
        colors: ['#c678ea', '#44a1e0', '#27ae60'],
    };

    category_chart_data = [
        ['Kategori', 'Meblağ'],
        @foreach($tags as $tag)
            ['{!! $tag['name'] !!}',{{ $tag['issue_count'] }}],
        @endforeach
    ];
    category_chart_options = {
        colors: [
        @foreach($tags as $tag)
            '{{ $tag['background'] }}',
        @endforeach
        ],
    };

    var ideaChartData = <?php echo json_encode($ideaChartData) ?>;
    google.setOnLoadCallback(function() {
        drawChart('chart_ideas', ideaChartData, idea_chart_options);
        drawChart('chart_categories', category_chart_data, category_chart_options);
    });

    $districtId = '{{ $district->id }}';

    $("#issueTypeOption").change(function() {
        filterReportIdeasBy( $(this).val() );
    });
    function filterReportIdeasBy(value) {
        
        $container = $("#issueListContainer");
        $container.addClass('isLoading');

        $.ajax({
            url: '/report/district/' + $districtId + '/issues',
            method: 'post',
            data: 'issueStatus=' + value,
            success: function(r){
                $container.html(r);
                $container.removeClass('isLoading');
                $('#issueTypeOption').val(value);
            },
            error: function() {
                $container.removeClass('isLoading');
            }
        });
    }
</script>

@stop
