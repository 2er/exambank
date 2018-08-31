@extends('layouts.app')
@section('title', '建军工程大学试卷题库')

@section('content')
    <div class="row select-title">
        <div class="col-md-12">
            <h2>按筛选条件抽题</h2>
        </div>
    </div>
    <div class="row select-area">
        @include('common.error')
        <form class="form-horizontal" method="POST" action="{{ route('examinations.select') }}" accept-charset="UTF-8">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-md-12">
                <div class="col-md-3">
                    <select id="select-select-department" class="form-control" name="department_id">
                        <option value="0">请选择所属系</option>
                        @foreach($departments as $department)
                        <option value="{{$department->id}}">{{$department->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="select-select-branch" class="form-control" name="branch_id">
                        <option value="0">请选择所属教研室</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <select id="select-select-subject" class="form-control" name="subject_id">
                        <option value="0">请选择所属课程</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 btn-area">
                <button type="submit" class="btn btn-primary">点我抽题</button>
            </div>
        </form>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        var departments = JSON.parse('{!! $departments_json !!}');
        var branches = [];
        var subjects = [];

        $('#select-select-department').change(function () {
            branches = [];
            var department_id = $(this).val();
            for (var i=0;i<departments.length;i++) {
                var department = departments[i];
                if (department.id == department_id && department.branches.length > 0) {
                    branches = department.branches;
                    break;
                }
            }

            if (branches.length > 0) {
                var options = '<option value="0">请选择所属教研室</option>';
                for (var j=0;j<branches.length;j++) {
                    options += "<option value='"+branches[j].id+"'>"+branches[j].name+"</option>";
                }
                $('#select-select-branch').html(options)
                $('#select-select-subject').html('<option value="0">请选择所属课程</option>')
            }

        });

        $('#select-select-branch').change(function () {
            subjects = [];
            var branch_id = $(this).val();
            for (var i=0;i<branches.length;i++) {
                var branch = branches[i];
                if (branch.id == branch_id && branch.subjects.length > 0) {
                    subjects = branch.subjects;
                    break;
                }
            }

            if (subjects.length > 0) {
                var options = '<option value="0">请选择所属课程</option>';
                for (var j=0;j<subjects.length;j++) {
                    options += "<option value='"+subjects[j].id+"'>"+subjects[j].name+"</option>";
                }
                $('#select-select-subject').html(options)
            }

        });
    </script>
@stop