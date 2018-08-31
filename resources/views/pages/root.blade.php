@extends('layouts.app')
@section('title', '建军工程大学试卷题库')

@section('content')
    <div class="row select-method-area">
        <div class="col-md-12 root-buttons">
            <div class="col-md-6"><button type="button" class="btn btn-primary btn-lg" data-method="plan">按考试计划抽题</button></div>
            <div class="col-md-6"><button type="button" class="btn btn-info btn-lg" data-method="select">按筛选条件抽题</button></div>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        $('.root-page .select-method-area .root-buttons button').click(function () {
            var method = $(this).data('method');
            if (method === 'plan') {
                window.location.href = "{{route('select.plan')}}";
            }
            if (method === 'select') {
                window.location.href = "{{route('select.select')}}";
            }
        });
    </script>
@stop