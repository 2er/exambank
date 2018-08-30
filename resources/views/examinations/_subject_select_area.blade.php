<div class="row root-select-area">
    <form class="form-horizontal" method="POST" action="{{ route('examinations.index') }}">
        {{ csrf_field() }}
        <div class="col-md-6 col-md-offset-3">
            <div class="form-group">
                <select id="subject_id" name="subject_id" class="form-control" required>
                    @if (!isset($subject))
                        <option value="0" hidden disabled selected>请选择分类</option>
                    @endif
                    @foreach($subjects as $subject_item)
                        @if(isset($subject) && $subject->id == $subject_item->id)
                            <option value="{{ $subject_item->id }}" selected>
                        @else
                            <option value="{{ $subject_item->id }}">
                        @endif
                            {{ $subject_item->bn }}/{{ $subject_item->name }}/{{ $subject_item->subject_hour }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3"><button type="submit" class="btn btn-primary" id="show_examinations_btn">抽题</button></div>
    </form>
</div>