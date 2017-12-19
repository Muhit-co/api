@foreach($tags as $tag)
    <li data-id="{!! $tag->id !!}">
        <a href="javascript:filterReportIdeasByStatusAndTag('all', {!! $tag->id !!});">
            <div class="u-floatright u-pl10">
                <span class="c-light">
                    <i class="ion ion-lightbulb u-mr5"></i>
                    {{ $tag->issueCount }}
                </span>
            </div>
            <span class="tag tag-uncollapsible u-floatleft u-mr5" style="background-color: #{{ $tag->background }};">
                {!! $tag->name !!}
            </span>
        </a>
    </li>
@endforeach
