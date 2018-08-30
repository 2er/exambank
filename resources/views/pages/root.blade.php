@extends('layouts.app')
@section('title', '建军工程大学试卷题库')

@section('content')
    <div class="alert alert-danger" id="show_error_info" role="alert" style="display: none;"></div>
    <div class="row">
        <div class="col-md-12 root-title">
            <h1>建军工程大学试卷题库</h1>
        </div>
    </div>
    @include('examinations._subject_select_area')
@stop