<div class="list list-expanded list_block u-mt20 u-mb20">
    <!-- <div class="list-header">
    </div> -->
    <ul class="list-content">
        @foreach($issues as $issue)

            <?php
                $issue = $issue->toArray();
                $issue_supporters = (int) Redis::get('supporter_counter:'.$issue['id']);
                $issue_status = getIssueStatus($issue['status'], $issue_supporters);
            ?>

            <li>
                <a href="/issues/view/{{$issue['id']}}">
                    <div class="badge badge-image u-floatleft u-mr15">
                        @if(isset($issue['images']) and !empty($issue['images']))
                            <img src="//d1vwk06lzcci1w.cloudfront.net/50x50/{{$issue['images'][0]['image']}}" alt="{{$issue['title']}}" />
                        @else
                            <img src="//d1vwk06lzcci1w.cloudfront.net/50x50/placeholders/issue.jpg" alt="{{$issue['title']}}" />
                        @endif
                    </div>
                    <div class="badge badge-support badge-{{$issue_status['class']}} u-floatright u-mt10 u-pv5 u-ph10">
                        <i class="ion {{$issue_status['icon']}} u-mr5"></i>
                        <strong>{{(int) Redis::get('supporter_counter:'.$issue['id'])}}</strong>
                    </div>
                    <strong>{{$issue['title']}}</strong>
                    <p>
                        @if(isset($issue['tags']) and !empty($issue['tags']))
                            @foreach($issue['tags'] as $tag)
                                <span class="tag u-mv5 u-mr5" style="background-color: #{{$tag['background']}};">
                                    {{$tag['name']}}
                                </span>

                            @endforeach
                        @endif
                        <span class="date u-mr10"><?php echo date('j M Y', strtotime($issue['created_at'])) ?></span>
                        <span class="extended">
                            |<span class="user u-ml10">
                            {{$issue['user']['first_name']}} {{$issue['user']['last_name']}} </span>
                        </span>
                    </p>
                </a>
            </li>
        @endforeach
        @if (count($issues) == 0)
            <li class="u-aligncenter u-pt20">
                <span class="c-light">
                    <i class="ion ion-checkmark-circled ion-2x"></i><br />
                    <strong>{{ trans('issues.issues_cant_be_found') }}</strong>
                </span>
            </li>
        @endif
    </ul>
</div>
<div class="u-aligncenter u-mb40">
    {!! $issues->render() !!}
</div>
