<?php

use App\Models\Branch;

return [
    'title'   => '教研室',
    'single'  => '教研室',
    'model'   => Branch::class,

    'columns' => [

        'id' => [
            'title' => 'ID',
        ],
        'name' => [
            'title'    => '名称',
            'sortable' => false,
        ],
        'department' => [
            'title'    => '院系',
            'sortable' => false,
            'output'   => function ($value, $model) {
                return model_admin_link($model->department->name, $model->department);
            },
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
            'title'    => '名称',
        ],
        'department' => [
            'title'              => '院系',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'search_fields'      => ["CONCAT(id, ' ', name)"],
            'options_sort_field' => 'id',
        ],
        'introduction' => [
            'title' => '简介',
            'type'  => 'textarea',
        ],
    ],
    'filters' => [
        'name' => [
            'title' => '名称',
        ],
        'department' => [
            'title'              => '所属院系',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'search_fields'      => array("CONCAT(id, ' ', name)"),
            'options_sort_field' => 'id',
        ],
    ],
    'rules'   => [
        'name' => 'required',
    ],
    'messages' => [
        'name.required' => '请填写教研室名称',
    ],
];