<div class="list list-small list-transp u-mt10">

	<div class="list-header u-pb0">
		<h4 class="u-mb10 c-light">EN SON İLERLEMELER</h4>
	</div>

	<ul class="list-content">
		@foreach($latestUpdatedIssues as $key=>$issue)

			<?php $issue_status = getIssueStatus($issue->status, 5); ?>

			<li>
				<a href="/issues/view/{{$issue->id}}">
					<div class="badge badge-circle badge-support-outline badge-{{ $issue_status['class'] }} u-floatleft u-mr10 u-mt5">
						<i class="ion {{ $issue_status['icon'] }}"></i>
					</div>
					<div class="u-ml55 u-lineheight20">
						<small>
							<div class="u-mb5">
								<div class="u-floatright u-opacity75 hasTooltip">
									<span id="relativeTimeSpan_{{$key}}"></span>
                                    <div id="relativeTimeTooltip_{{$key}}" name="relativeTimeTooltip" class="tooltip tooltip-compact tooltip-alignright" style="width: auto; white-space: nowrap;">
                                    	{{ strftime('%d.%m.%Y %H:%M:%S', strtotime($issue->updated_at)) }}
                                    </div>
								</div>
								FİKİR GÜNCELLENDİ
							</div>
							<h4>{{ $issue->title }}</h4>
							<strong class="c-medium u-opacity75"><i class="ion ion-chatbox u-mr5"></i> {{ $issue->commenter }}</strong>
						</small>
					</div>
				</a>
			</li>

		@endforeach
	</ul>
</div>

<script type="text/javascript">
    var issueIds = [
		@foreach($latestUpdatedIssues as $issue)
         {{ $issue->id }},
		@endforeach
    ];

	moment.locale('{{App::getLocale()}}');
    $.each( issueIds, function( key, value ) {
        var time = $('#relativeTimeTooltip_'+key).text();
        var relativeTime = moment(time, "DD.MM.YYYY hh:mm:ss").fromNow()
		$('#relativeTimeSpan_'+key).text(relativeTime);

    });
</script>