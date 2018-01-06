<div class="list list-small list-transp u-mt10">

	<div class="list-header u-pb0">
		<h4 class="u-mb10 c-light">EN SON İLERLEMELER</h4>
	</div>

	<ul class="list-content">
		@foreach($latestUpdatedIssues as $issue)

			<?php $issue_status = getIssueStatus($issue->status, 0); ?>

			<li>
				<a href="/issues/view/{{$issue->id}}">
					<div class="badge badge-circle-small badge-support-outline badge-{{ $issue_status['class'] }} u-floatleft u-mr10 u-mt5">
						<i class="ion {{ $issue_status['icon'] }}"></i>
					</div>
					<div class="u-ml55 u-lineheight20">
						<small>
							<div class="u-opacity75 u-mb5 c-medium">
								<div class="u-floatright u-opacity75">
                                    <?php echo strftime('%d %h %Y %H:%M:%S', strtotime($issue->updated_at)) ?>
								</div>
								FİKİR GÜNCELLENDİ
							</div>
							<h4>{{ $issue->title }}</h4>
							<strong class="c-light"><i class="ion ion-chatbox u-mr5"></i> {{ $issue->commenter }}</strong>
						</small>
					</div>
				</a>
			</li>

		@endforeach
	</ul>
</div>