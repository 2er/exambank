@if (count($examinations))

    <ul class="media-list">
        @foreach ($examinations as $examination)
            <li class="media">
                <div class="media-body">

                    <div class="media-heading">
                        <a href="{{ route('examinations.show', [$examination->id]) }}" title="{{ $examination->title }}">
                            {{ $examination->title }}
                        </a>
                        <a class="pull-right" href="{{ route('examinations.show', [$examination->id]) }}" >
                            <span class="badge"> {{ $examination->hit_count }} </span>
                        </a>
                    </div>

                    <div class="media-body meta">

                        <a href="#" title="{{ $examination->subject->bn }}">
                            <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                            {{ $examination->subject->bn }}
                        </a>

                        <span> • </span>
                        <a href="#" title="{{ $examination->subject->name }}">
                            <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                            {{ $examination->subject->name }}
                        </a>
                        <span> • </span>
                        <a href="#" title="{{ $examination->subject->subject_hour }}">
                            <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                            {{ $examination->subject->subject_hour }}
                        </a>
                    </div>

                </div>
            </li>

            @if ( ! $loop->last)
                <hr>
            @endif

        @endforeach
    </ul>

@else
    <div class="empty-block">暂无试卷 ~_~ </div>
@endif