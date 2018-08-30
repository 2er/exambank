<?php

use App\Models\Examination;

return [
    'title'   => '试卷',
    'single'  => '试卷',
    'model'   => Examination::class,

    'columns' => [

        'id' => [
            'title' => 'ID',
        ],
        'title' => [
            'title'    => '试卷标题',
            'sortable' => false,
            'output'   => function ($value, $model) {
                return '<div style="max-width:260px">' . model_link($value, $model) . '</div>';
            },
        ],
        'subject' => [
            'title'    => '课程',
            'sortable' => false,
            'output'   => function ($value, $model) {
                return model_admin_link($model->subject->name, $model->subject);
            },
        ],
        'hit_count' => [
            'title'    => '抽中次数',
        ],
        'operation' => [
            'title'  => '管理',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'subject' => [
            'title'              => '课程',
            'type'               => 'relationship',
            'name_field'         => 'full_subject_name',
            'search_fields'      => ["CONCAT(id, ' ', name)"],
            'options_sort_field' => 'id',
        ],
        'title' => [
            'title'    => '标题',
        ],
        'file_path' => [
            'title' => '试卷文件',
            'type' => 'file',
            'location' => public_path() . '/uploads/files/examinations/',
            'naming' => 'keep',
            'length' => 20,
            'size_limit' => 2,
            'display_raw_value' => false,
            'mimes' => 'doc,docx',
        ],
    ],
    'filters' => [
        'title' => [
            'title' => '试卷标题',
        ],
        'subject' => [
            'title'              => '所属课程',
            'type'               => 'relationship',
            'name_field'         => 'full_subject_name',
            'search_fields'      => array("CONCAT(id, ' ', name)"),
            'options_sort_field' => 'id',
        ],
    ],
    'rules'   => [
        'title' => 'required',
        'file_path' => 'required',
    ],
    'messages' => [
        'title.required' => '请填写试卷标题',
        'file_path.required' => '请选择试卷文件',
    ],
];