@extends('layouts.app')

@section('title', isset($subject) ? $subject->name : '试卷列表')

@section('content')

    <div class="row">
        <div class="col-lg-9 col-md-9 topic-list">
            @include('examinations._subject_select_area')
            <div class="panel panel-default">

                {{--<div class="panel-heading">--}}
                    {{--<ul class="nav nav-pills">--}}
                        {{--<li class="{{ active_class( ! if_query('order', 'recent') ) }}"><a href="{{ Request::url() }}?order=default">最新入库</a></li>--}}
                        {{--<li class="{{ active_class(if_query('order', 'recent')) }}"><a href="{{ Request::url() }}?order=recent">最后抽中时间</a></li>--}}
                    {{--</ul>--}}
                {{--</div>--}}

                <div class="panel-body">
                    {{-- 话题列表 --}}
                    @include('examinations._examination_list', ['examinations' => $examinations])
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 sidebar">
            @include('examinations._sidebar')
        </div>
    </div>

@endsection