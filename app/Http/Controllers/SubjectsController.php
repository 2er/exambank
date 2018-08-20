<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectsController extends Controller
{
    public function show(Subject $subject)
    {
        // 读取课程 ID 关联的考卷，并按每 20 条分页
        $examinations = Examination::where('subject_id', $subject->id)->paginate(20);
        // 传参变量考卷和课程到模板中
        return view('examinations.index', compact('examinations', 'subject'));
    }
}
