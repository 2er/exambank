<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['permissionDenied']]);
    }

    public function root(Subject $subject)
    {
        $subjects = $subject->all();
        return view('pages.root', compact('subjects'));
    }

    public function permissionDenied()
    {
        // 如果当前用户有权限访问后台，直接跳转访问
        if (config('administrator.permission')()) {
            return redirect(url(config('administrator.uri')), 302);
        }
        // 否则使用视图
        return view('pages.permission_denied');
    }
}
