<?php

namespace App\Observers;

use App\Models\Examination;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ExaminationObserver
{
    public function created(Examination $examination)
    {
        $left_count = Examination::where('subject_id',$examination->subject->id)
            ->where('hit_count',0)
            ->count();
        $subject = $examination->subject;
        $subject->left_count = $left_count;
        $subject->save();
    }

    public function deleted(Examination $examination)
    {
        $left_count = Examination::where('subject_id',$examination->subject->id)
            ->where('hit_count',0)
            ->count();
        $subject = $examination->subject;
        $subject->left_count = $left_count;
        $subject->save();
    }
}