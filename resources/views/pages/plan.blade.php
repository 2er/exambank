@extends('layouts.app')
@section('title', '建军工程大学试卷题库')

@section('content')
    <div class="row select-title">
        <div class="col-md-12">
            <h2>按考试计划抽题</h2>
        </div>
    </div>
    <div class="row select-area">
        @include('common.error')
        <form class="form-horizontal" method="POST" action="{{ route('examinations.plan') }}" enctype="multipart/form-data" accept-charset="UTF-8">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-md-12">
                <div class="col-md-6 col-md-offset-3">
                    <div class="form-group">
                        <label for="plan-file">请选择考试计划文件</label>
                        <input type="file" id="plan-file" name="plan">
                        <p class="help-block">仅支持Excel文件</p>
                    </div>
                </div>
                <div class="col-md-3 btn-area">
                    <button type="submit" class="btn btn-primary" id="select-examinations-btn">点我抽题</button>
                </div>
            </div>
        </form>
    </div>
@stop