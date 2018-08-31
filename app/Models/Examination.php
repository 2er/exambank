<?php

namespace App\Models;
use App\Handlers\DocChangeHandler;

class Examination extends Model
{
    protected $fillable = ['title', 'file_path', 'subject_id', 'hit_count', 'last_hitted_at'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function scopeWithOrder($query, $order)
    {
        // 不同的排序，使用不同的数据读取逻辑
        switch ($order) {
            case 'recent':
                $query->recent();
                break;

            default:
                $query->recentHitted();
                break;
        }
        // 预加载防止 N+1 问题
        return $query->with('subject');
    }

    public function scopeRecentHitted($query)
    {
        // 当考卷抽中时，我们将编写逻辑来更新考卷模型的 hit_count 属性，
        // 此时会自动触发框架对数据模型 last_hit_at 时间戳的更新
        return $query->orderBy('last_hit_at', 'desc');
    }

    public function scopeRecent($query)
    {
        // 按照创建时间排序
        return $query->orderBy('created_at', 'desc');
    }

    public function setFilePathAttribute($path)
    {

        // 如果不是 `http` 子串开头，那就是从后台上传的，需要补全 URL
        if ( ! starts_with($path, 'http')) {
            // 生成pdf文件
            /*//
            $source_file = public_path('/uploads/files/examinations/'.$path);
            $change_obj = new DocChangeHandler();
            $change_obj->change($source_file,'HTML');
            //*/
            // 拼接完整的 URL
            $path = config('app.url') . "/uploads/files/examinations/$path";
        }

        $this->attributes['file_path'] = $path;
    }

    public function roundExaminationBySubjectId($subject_id)
    {
        $examination = [];

        $examinations_data = $this->where('subject_id', $subject_id)
            ->where('hit_count',0)
            ->get();

        if ($examinations_data->isNotEmpty()) {
            $examination = $examinations_data->random()->toArray();
        }

        return $examination;
    }

    public function getExaminationsByPlan($plan,&$msg)
    {

        if (empty($plan) || count($plan) <= 1) {
            $msg = '考试计划数据为空';
            return false;
        }

        array_shift($plan);

        $data = [];

        foreach ($plan as $plan_col) {

            $plan_item = [];

            $date_time = trim($plan_col['A']);
            $subject_name = trim($plan_col['B']);
            $subject_bn = trim($plan_col['C']);
            $subject_hour = intval($plan_col['D']);

            $plan_item['subject_id'] = 0;
            $plan_item['examination'] = [];
            $plan_item['bn'] = $subject_bn;
            $plan_item['name'] = $subject_name;
            $plan_item['subject_hour'] = $subject_hour;
            $plan_item['date_time'] = $date_time;

            $subject = Subject::where('name',$subject_name)
                ->where('bn', $subject_bn)
                ->where('subject_hour', $subject_hour)
                ->first();

            if ($subject) {
                $plan_item['subject_id'] = $subject->id;
                $plan_item['examination'] = $this->roundExaminationBySubjectId($subject->id);
            }

            $data[] = $plan_item;
        }

        return $data;
    }
}
