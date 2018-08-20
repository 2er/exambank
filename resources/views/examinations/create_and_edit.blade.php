@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> Examination /
                    @if($examination->id)
                        Edit #{{$examination->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($examination->id)
                    <form action="{{ route('examinations.update', $examination->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('examinations.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                	<label for="title-field">Title</label>
                	<input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $examination->title ) }}" />
                </div> 
                <div class="form-group">
                	<label for="file_path-field">File_path</label>
                	<input class="form-control" type="text" name="file_path" id="file_path-field" value="{{ old('file_path', $examination->file_path ) }}" />
                </div> 
                <div class="form-group">
                    <label for="subject_id-field">Subject_id</label>
                    <input class="form-control" type="text" name="subject_id" id="subject_id-field" value="{{ old('subject_id', $examination->subject_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="hit_count-field">Hit_count</label>
                    <input class="form-control" type="text" name="hit_count" id="hit_count-field" value="{{ old('hit_count', $examination->hit_count ) }}" />
                </div> 
                <div class="form-group">
                    <label for="last_hitted_at-field">Last_hitted_at</label>
                    <input class="form-control" type="text" name="last_hitted_at" id="last_hitted_at-field" value="{{ old('last_hitted_at', $examination->last_hitted_at ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('examinations.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection