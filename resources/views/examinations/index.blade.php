@extends('layouts.app')

@section('title', isset($subject) ? $subject->name : '试卷列表')

@section('content')

    <div class="row">
        <div class="col-lg-9 col-md-9 topic-list">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <ul class="nav nav-pills">
                        <li role="presentation" class="active"><a href="#">最新入库</a></li>
                        <li role="presentation"><a href="#">最后抽中时间</a></li>
                    </ul>
                </div>

                <div class="panel-body">
                    {{-- 话题列表 --}}
                    @include('examinations._examination_list', ['examinations' => $examinations])
                    {{-- 分页 --}}
                    {!! $examinations->appends(Request::except('page'))->render() !!}
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 sidebar">
            @include('examinations._sidebar')
        </div>
    </div>

@endsection