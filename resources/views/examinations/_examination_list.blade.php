@if (count($examinations))
    <form id="examinations-export-form" class="form-horizontal" method="POST" action="{{ route('examinations.export') }}" accept-charset="UTF-8">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @foreach ($examinations as $examination)
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading">
                课程编号：{{$examination['bn']}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                名称：{{$examination['name']}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                课时：{{$examination['subject_hour']}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                @if($examination['date_time'])
                考试时间：{{$examination['date_time']}}
                @endif
            </div>
            @if($examination['subject_id'] == 0)
                <div class="panel-body">
                    <p>没有匹配到课程 ~_~</p>
                </div>
            @elseif(empty($examination['examination']))
                <div class="panel-body">
                    <p>该课程下没有未使用的试卷，请尽快上传 ~_~</p>
                </div>
            @else
                <table class="table">
                    <thead>
                    <tr>
                        <th>选择</th>
                        <th>试卷名称</th>
                        <th>入库时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row"><input type="checkbox" name="examinations[]" value="{{$examination['examination']['id']}}"></th>
                        <td>{{$examination['examination']['title']}}</td>
                        <td>{{$examination['examination']['created_at']}}</td>
                        <td class="del-btn-area"><a class="btn btn-primary btn-xs" target="_blank" href="{{route('examinations.show',$examination['examination']['id'])}}" data-id="{{$examination['examination']['id']}}">在线预览</a></td>
                    </tr>
                    </tbody>
                </table>
            @endif
        </div>
    @endforeach
        <div class="panel export-area">
            <button type="button" class="btn btn-primary btn-lg">导出选中试卷</button>
        </div>
    </form>
@else
    <div class="empty-block">暂无结果 ~_~ </div>
@endif