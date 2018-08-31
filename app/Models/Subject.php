<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Examination;

class Subject extends Model
{
    protected $fillable = ['bn', 'name', 'subject_hour', 'introduction'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function roundExaminationsGroupBySubjectIds($subject_ids)
    {
        $examinations = [];
        foreach ($subject_ids as $subject_id) {
            $examinations_data = Examination::with('subject')
                ->where('subject_id', $subject_id)
                ->where('hit_count',0)
                ->get();

            if ($examinations_data->isNotEmpty()) {
                $examinations[] = $examinations_data->random();
            }
        }

        return $examinations;
    }

    public function getFullSubjectNameAttribute()
    {
        return "{$this->bn}/{$this->name}/{$this->subject_hour}";
    }

    public function getExaminationsBySelect($param,&$msg)
    {
        $subject_id = isset($param['subject_id']) ? intval($param['subject_id']) : 0;
        $branch_id = isset($param['branch_id']) ? intval($param['branch_id']) : 0;
        $department_id = isset($param['department_id']) ? intval($param['department_id']) : 0;

        if ($subject_id > 0) {
            $subject_data = $this->where('id',$subject_id)->get()->toArray();
        } elseif ($branch_id > 0) {
            $subject_data = $this->where('branch_id',$branch_id)->get()->toArray();
        } elseif ($department_id > 0) {
            $department = Department::with('subjects')
                ->where('id',$department_id)
                ->first();
            $subject_data = $department->subjects->toArray();
        } else {
            $subject_data = $this->all()->toArray();
        }

        $data = [];
        $examination_model = new Examination();

        foreach ($subject_data as $subject_value) {

            $subject_item = [];

            $subject_item['subject_id'] = $subject_value['id'];
            $subject_item['examination'] = $examination_model->roundExaminationBySubjectId($subject_value['id']);
            $subject_item['bn'] = $subject_value['bn'];
            $subject_item['name'] = $subject_value['name'];
            $subject_item['subject_hour'] = $subject_value['subject_hour'];
            $subject_item['date_time'] = '';

            $data[] = $subject_item;
        }

        return $data;
    }
}
