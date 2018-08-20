@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Examination / Show #{{ $examination->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('examinations.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('examinations.edit', $examination->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>Title</label>
<p>
	{{ $examination->title }}
</p> <label>File_path</label>
<p>
	{{ $examination->file_path }}
</p> <label>Subject_id</label>
<p>
	{{ $examination->subject_id }}
</p> <label>Hit_count</label>
<p>
	{{ $examination->hit_count }}
</p> <label>Last_hitted_at</label>
<p>
	{{ $examination->last_hitted_at }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection
