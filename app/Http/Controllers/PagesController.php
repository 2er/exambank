<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['permissionDenied']]);
    }

    public function root()
    {
        return view('pages.root');
    }

    public function plan()
    {
        return view('pages.plan');
    }

    public function select(Department $department)
    {
        $departments = $department->with(['branches' => function ($query) {
            $query->with('subjects');
        }])->get();

        $departments_json = json_encode($departments->toArray());

        return view('pages.select',compact('departments','departments_json'));
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
