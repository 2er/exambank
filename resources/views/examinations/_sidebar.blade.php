<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">课程简介</h3>
    </div>
    <div class="panel-body">
        @if(isset($subject))
            {{ $subject->introduction }}
        @endif
    </div>
</div>