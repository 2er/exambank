@if (count($examinations))

    <ul class="media-list">
        @foreach ($examinations as $examination)
            <li class="media">
                <div class="media-body">
                    <a href="{{ route('examinations.show', [$examination->id]) }}" title="{{ $examination->title }}">
                        {{ $examination->title }}
                    </a>
                    <a class="pull-right btn btn-primary btn-sm" href="{{ route('examinations.show', [$examination->id]) }}" role="button" >
                        查看
                    </a>
                    <a style="margin-right: 10px;" class="pull-right btn btn-default btn-sm" href="{{ $examination->file_path }}" role="button" >
                        下载
                    </a>
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