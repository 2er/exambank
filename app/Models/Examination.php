<?php

namespace App\Models;
use App\Handlers\DocChangeHandler;
use Chumper\Zipper\Zipper;
use DB;

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

    public function createZipByExaminationIds($data)
    {
        if (!is_array($data)) {
            return false;
        }

        $examinations = $this->join('subjects', 'examinations.subject_id', '=', 'subjects.id')
            ->join('branches', 'subjects.branch_id', '=', 'branches.id')
            ->join('departments', 'branches.department_id', '=', 'departments.id')
            ->select('examinations.*', 'subjects.bn AS subject_bn', 'subjects.name AS subject_name', 'subjects.subject_hour', 'branches.name AS branch_name', 'departments.name AS department_name')
            ->whereIn('examinations.id',$data)
            ->get()->toArray();

        if (empty($examinations)) {
            return false;
        }

        $today = date('Ymd');
        $zip_path = public_path('/uploads/files/examinations/zip/');
        $examinations_path = public_path('/uploads/files/examinations/');

        if (!file_exists($zip_path.$today)) {
            if (!mkdir($zip_path.$today)) {
                return false;
            }
        }

        // 创建文件夹，复制试卷
        foreach ($examinations as $examination) {

            if (empty($examination['file_path']) || !file_exists($examinations_path.$examination['file_path'])) {
                continue;
            }

            $examination_path = $examinations_path.$examination['file_path'];

            $extension = pathinfo($examination_path,PATHINFO_EXTENSION);

            // 创建院系名称文件夹
            if ($examination['department_name']) {
                $department_path = $zip_path.'/'.$today.'/'.$examination['department_name'];
                if (!file_exists($department_path)) {
                    if (!mkdir($department_path)) {
                        return false;
                    }
                }
            }

            // 创建教研室名称文件夹
            if ($examination['branch_name']) {
                $branch_path = $zip_path.'/'.$today.'/'.$examination['department_name'].'/'.$examination['branch_name'];
                if (!file_exists($branch_path)) {
                    if (!mkdir($branch_path)) {
                        return false;
                    }
                }
            }

            // 创建教课程名称文件夹
            if ($examination['subject_name']) {
                $subject_path = $zip_path.'/'.$today.'/'.$examination['department_name'].'/'.$examination['branch_name'].'/'.$examination['subject_bn'].'_'.$examination['subject_name'].'_'.$examination['subject_hour'];
                if (!file_exists($subject_path)) {
                    if (!mkdir($subject_path)) {
                        return false;
                    }
                }
            }

            $target_path = $zip_path.'/'.$today.'/'.$examination['department_name'].'/'.$examination['branch_name'].'/'.$examination['subject_bn'].'_'.$examination['subject_name'].'_'.$examination['subject_hour'].'/'.$examination['title'].'.'.$extension;

            if (!copy($examination_path,$target_path)) {
                return false;
            }
        }

        // 打包

        $zip_filename = date('Ymd-H-i-s').'.zip';
        $zip_file_path = $zip_path.$zip_filename;

        $zipper = new Zipper;
        $files = glob($zip_path.$today.'/*');
        $zipper->make($zip_file_path)->add($files);
        $zipper->close();

        deldir($zip_path.$today);

        return config('app.url') . "/uploads/files/examinations/zip/" . $zip_filename;
    }

    public function updateExaminationsStatus($ids)
    {

        if (is_array($ids) || !empty($ids)) {
            DB::beginTransaction();

            $examinations = $this->with('subject')->whereIn('id',$ids)->get();

            foreach ($examinations as $examination) {
                $examination->hit_count = $examination->hit_count + 1;
                $examination_res = $examination->save();
                if (!$examination_res) {
                    DB::rollBack();
                    return false;
                }

                $left_count = Examination::where('subject_id',$examination->subject->id)
                    ->where('hit_count',0)
                    ->count();

                $used_count = Examination::where('subject_id',$examination->subject->id)
                    ->where('hit_count',1)
                    ->count();

                $subject = $examination->subject;
                $subject->left_count = $left_count;
                $subject->used_count = $used_count;
                $subject_res = $subject->save();
                if (!$subject_res) {
                    DB::rollBack();
                    return false;
                }
            }

            DB::commit();

            return true;
        }

        return false;

    }
}
