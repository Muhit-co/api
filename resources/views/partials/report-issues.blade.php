
    @foreach($popularIssues as $issue)

        <?php
        $issue = $issue->toArray();
        $issue_status = getIssueStatus($issue['status'], $issue['supporter_count']);
        ?>

        <li>
            <a href="/issues/view/{{$issue['id']}}">
                <div class="u-floatright u-pl10">
                                    <span class="c-{{$issue_status['class']}}">
                                        <i class="ion {{$issue_status['icon']}} u-mr5"></i>
                                        <strong>{{$issue['supporter_count']}}</strong>
                                    </span>
                    <i class="ion ion-chevron-right u-ml10"></i>
                </div>
                <span class="title">{{$issue['title']}}</span>
            </a>
        </li>

    @endforeach

    @if(count($popularIssues) > 2)
        <li>
            <a href="javascript:alert('Go to filtered idea list page')">
                <div class="u-floatright u-pl10 c-light">
                    <i class="ion ion-chevron-right u-ml20"></i>
                </div>
                <h4 class="title c-light u-nowrap">
                    {{ trans('issues.show_all_ideas') }}
                </h4>
            </a>
        </li>
    @endif

