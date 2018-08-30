<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectsController extends Controller
{
    public function show(Subject $subject, Request $request, Examination $examination)
    {
        $subject_ids = $request->subject_ids;
        dd($subject_ids);
        $subjects = $subject->all();
        // 读取课程 ID 关联的考卷，并按每 20 条分页
        $examinations = $examination->withOrder($request->order)->where('subject_id', $subject->id)->paginate(20);
        // 传参变量考卷和课程到模板中
        return view('examinations.index', compact('examinations', 'subject', 'subjects'));
    }
}
