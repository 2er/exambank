@extends('layouts.app')
@section('title', '建军工程大学试卷题库')

@section('content')
    <div class="alert alert-danger" id="show_error_info" role="alert" style="display: none;"></div>
    <div class="row">
        <div class="col-md-12 root-title">
            <h1>建军工程大学试卷题库</h1>
        </div>
    </div>
    <div class="row root-select-area">
        <div class="col-md-6 col-md-offset-3">
            <div class="form-group">
                <select id="subject_id" name="subject_id" class="form-control" required>
                    <option value="0" hidden disabled selected>请选择分类</option>
                    @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->bn }}/{{ $subject->name }}/{{ $subject->subject_hour }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3"><button type="button" class="btn btn-primary" id="show_examinations_btn">抽题</button></div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        $(function(){
            $('#show_examinations_btn').on('click',function(){
                var subject_id = $('#subject_id').val();
                if (!subject_id) {
                    $('#show_error_info').append('注意：请先选择课程！').css('display','');
                    return false;
                }
                window.location.href = "{{ route('subjects.show') }}/" + subject_id;
            })
        });
    </script>
@stop