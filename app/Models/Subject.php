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
}
