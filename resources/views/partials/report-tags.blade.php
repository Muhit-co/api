@foreach($tags as $tag)
    <li>
        <a href="?tag={{ urlencode($tag->name) }}">
            <div class="u-floatright u-pl10">
                                    <span class="c-light">
                                        <i class="ion ion-lightbulb u-mr5"></i>
                                        {{ $tag->issueCount }}
                                    </span>
            </div>
            <span class="tag u-floatleft u-mr5" style="background-color: #{{ $tag->background }};">
                                    {!! $tag->name !!}
                                </span>
        </a>
    </li>
@endforeach
