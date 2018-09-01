<?php

use App\Models\Subject;

return [
    'title'   => '课程',
    'single'  => '课程',
    'model'   => Subject::class,

    // 对 CRUD 动作的单独权限控制，其他动作不指定默认为通过
    'action_permissions' => [
        // 删除权限控制
        'delete' => function () {
            // 只有站长才能删除话题分类
            return Auth::user()->hasRole('超级管理员');
        },
    ],

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'bn' => [
            'title'    => '编号',
            'sortable' => false,
        ],
        'name' => [
            'title'    => '名称',
            'sortable' => false,
        ],
        'branch' => [
            'title'    => '科室',
            'sortable' => false,
            'output'   => function ($value, $model) {
                return model_admin_link($model->branch->name, $model->branch);
            },
        ],
        'subject_hour' => [
            'title'    => '课时',
            'sortable' => false,
        ],
        'left_count' => [
            'title'    => '未抽中套数',
            'sortable' => false,
        ],
        'operation' => [
            'title'  => '管理',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'bn' => [
            'title' => '编号',
        ],
        'name' => [
            'title' => '名称',
        ],
        'branch' => [
            'title'              => '科室',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'search_fields'      => ["CONCAT(id, ' ', name)"],
            'options_sort_field' => 'id',
        ],
        'subject_hour' => [
            'title' => '课时',
        ],
        'introduction' => [
            'title' => '简介',
            'type'  => 'textarea',
        ],
    ],
    'filters' => [
        'id' => [
            'title' => '分类 ID',
        ],
        'bn' => [
            'title' => '编号',
        ],
        'name' => [
            'title' => '名称',
        ],
        'branch' => [
            'title'              => '所属科室',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'search_fields'      => array("CONCAT(id, ' ', name)"),
            'options_sort_field' => 'id',
        ],
        'subject_hour' => [
            'title' => '课时',
        ],
        'left_count' => [
            'title' => '未抽中套数',
            'type' => 'number'
        ],
    ],
    'rules'   => [
        'bn' => 'required|min:1',
        'name' => 'required|min:1',
        'subject_hour' => 'required|min:1',
    ],
    'messages' => [
        'bn.required' => '请填写课程编号',
        'name.required' => '请填写课程名称',
        'subject_hour.required' => '请填写课程课时',
    ]
];