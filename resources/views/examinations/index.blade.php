@extends('layouts.app')

@section('content')
    <div class="row examinations-title">
        <div class="col-md-12">
            <h2>抽卷结果列表</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 topic-list">
            <div class="panel panel-default">

                {{--<div class="panel-heading">--}}
                    {{--<ul class="nav nav-pills">--}}
                        {{--<li class="{{ active_class( ! if_query('order', 'recent') ) }}"><a href="{{ Request::url() }}?order=default">最新入库</a></li>--}}
                        {{--<li class="{{ active_class(if_query('order', 'recent')) }}"><a href="{{ Request::url() }}?order=recent">最后抽中时间</a></li>--}}
                    {{--</ul>--}}
                {{--</div>--}}

                <div class="panel-body examinations-content">
                    @include('examinations._examination_list', ['examinations' => $examinations])
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('.examinations-content .export-area button').click(function (e) {
            if ($('#examinations-export-form').serialize() == '') {
                e.preventDefault();
            }
        });
    </script>
@stop