@if(isset($district))
    <em class="u-block u-pa5 u-mt10 u-truncate"><small>
        <a href="fikirler/all" class="u-floatright">
            {{ trans('issues.show_all_ideas') }}
        </a>
        {!! trans('issues.n_ideas_found_in', ['district' => $district->name, 'number' => $issues->count()] ) !!}
    </small></em>
@endif

<div class="list list-expanded list_block u-mt10 u-mb20">
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
                            <img src="{{ getImageURL($issue['images'][0]['image'], '50x50') }}" alt="{{$issue['title']}}" />
                        @else
                            <img src="{{ getImageURL('placeholders/issue.jpg', '50x50') }}" alt="{{$issue['title']}}" />
                        @endif
                    </div>
                    <div class="badge badge-support badge-{{$issue_status['class']}} u-floatright u-mt10 u-pv5 u-ph10 u-ml10">
                        <i class="ion {{$issue_status['icon']}} u-mr5"></i>
                        <strong>{{$issue_supporters}}</strong>
                    </div>
                    @if(isset($issue['comments']) and count($issue['comments']) > 0)
                        <div class="badge badge-comments hasTooltip u-floatright u-mt10 u-pv5 u-ph10 u-ml10">
                            <i class="ion ion-ios-chatbubble-outline u-mr5"></i>
                            <strong>{{count($issue['comments'])}}</strong>
                        </div>
                    @endif
                    <div class="u-ml55">
                        <strong>{{$issue['title']}}</strong>
                        <p>
                            @if(isset($issue['tags']) and !empty($issue['tags']))
                                @foreach($issue['tags'] as $key => $tag)
                                    @if($key < 5)
                                        <span class="tag u-floatleft u-mv5 u-mr5" style="background-color: #{{$tag['background']}};">
                                            <span class="col-xs-hide">{{$tag['name']}}</span>
                                        </span>
                                    @endif
                                    @if($key == 5)
                                        <span class="tag u-floatleft u-mv5 u-mr5 bg-lightest">
                                            <span class="col-xs-hide c-light">...</span>
                                        </span>
                                    @endif
                                @endforeach
                            @endif
                            <span class="date u-floatleft u-mr10"><?php echo strftime('%d %h %Y', strtotime($issue['created_at'])) ?></span>
                            @if(!isset($hood))
                                <span class="extended">
                                    |<span title="{{$issue['location']}}" class="u-ml10">{{ explode(', ', $issue['location'])[0] }}</span>
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
    {!! $issues->appends(['sort' =>  Input::get('sort')])->render() !!}
</div>
