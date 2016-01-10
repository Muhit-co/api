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
                    <div class="badge badge-support badge-{{$issue_status['class']}} u-floatright u-mt10 u-pv5 u-ph10 u-ml5">
                        <i class="ion {{$issue_status['icon']}} u-mr5"></i>
                        <strong>{{(int) Redis::get('supporter_counter:'.$issue['id'])}}</strong>
                    </div>
                    <div class="u-ml55">
                        <strong>{{$issue['title']}}</strong>
                        <p>
                            @if(isset($issue['tags']) and !empty($issue['tags']))
                                @foreach($issue['tags'] as $tag)
                                    <span class="tag u-floatleft u-mv5 u-mr5" style="background-color: #{{$tag['background']}};">
                                        <span class="col-xs-hide">{{$tag['name']}}</span>
                                    </span>

                                @endforeach
                            @endif
                            <span class="date u-floatleft u-mr10"><?php echo strftime('%d %h %Y', strtotime($issue['created_at'])) ?></span>
                            @if($issue['is_anonymous'] == 0)
                            <span class="extended">
                                |<span class="user u-ml10">
                                    {{$issue['user']['first_name']}} {{$issue['user']['last_name']}} </span>
                            </span>
                            @endif
                        </p>
                    </div>
                </a>
            </li>
        @endforeach
        @if (count($issues) == 0)
            <div class="u-aligncenter u-pv20">

                <div class="c-medium">
                    <i class="ion ion-checkmark-circled ion-2x c-light"></i><br />
                    @if (isset($hood))
                        {!! trans('issues.no_ideas_found_for_hood', ['hood' => '<strong>'.$hood->name.'</strong>']) !!}
                    @else
                        {{ trans('issues.issues_cant_be_found') }}
                    @endif
                </div>

                @include('partials.add_idea_button', ['text' => trans('issues.add_first_idea_cap'), 'class' => 'btn btn-quaternary u-mt20'])

            </div>
        @endif
    </ul>
</div>
<div class="u-aligncenter u-mb40">
    {!! $issues->render() !!}
</div>
