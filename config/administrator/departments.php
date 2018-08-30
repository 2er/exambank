<?php

use App\Models\Department;

return [
    'title'   => '院系',
    'single'  => '院系',
    'model'   => Department::class,

    // 对 CRUD 动作的单独权限控制，其他动作不指定默认为通过
    'action_permissions' => [
        // 删除权限控制
        'delete' => function () {
            // 只有站长才能删除
            return Auth::user()->hasRole('超级管理员');
        },
    ],

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'name' => [
            'title'    => '名称',
            'sortable' => false,
        ],
        'introduction' => [
            'title'    => '简介',
            'sortable' => false,
        ],
        'operation' => [
            'title'  => '管理',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'name' => [
            'title' => '名称',
        ],
        'introduction' => [
            'title' => '简介',
            'type'  => 'textarea',
        ],
    ],
    'filters' => [
        'id' => [
            'title' => '院系 ID',
        ],
        'name' => [
            'title' => '名称',
        ],
    ],
    'rules'   => [
        'name' => 'required|min:1',
    ],
    'messages' => [
        'name.required' => '请填写院系名称'
    ],
];