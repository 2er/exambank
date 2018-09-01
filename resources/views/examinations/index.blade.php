@extends('layouts.app')

@section('content')
    <div class="row examinations-error"></div>
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

        var error_area = $('.examinations-error');

        var error_html = '<div class="alert alert-danger alert-dismissible" role="alert">\n' +
            '        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n' +
            '        <strong>警告！</strong><span class="error-content"></span>\n' +
            '    </div>';

        $('.examinations-content .export-area button').click(function (e) {

            if ($(this).hasClass('btn-success')) {
                $("#examinations-export-form input").prop('checked',true);
            }

            if ($("#examinations-export-form input:checked").length === 0) {
                error_area.html('');
                $(error_html).appendTo(error_area).find('.error-content').text('请选择要导出的试卷');
                return false;
            }
            var post_data = $('#examinations-export-form').serialize();

            var post = $.post("{{ route('examinations.export') }}", post_data, function(resp) {
                if (resp.status == '1') {
                    window.location.href = resp.url;
                } else {
                    error_area.html('');
                    $(error_html).appendTo(error_area).find('.error-content').text(resp.msg);
                    return false;
                }
            }).fail(function(error) {
                error_area.html('');
                $(error_html).appendTo(error_area).find('.error-content').text('出错啦');
                return false;
            })
        });
    </script>
@stop