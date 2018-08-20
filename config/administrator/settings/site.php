<?php

return [
    'title' => '应用设置',

    // 访问权限判断
    'permission'=> function()
    {
        // 只允许站长管理站点配置
        return Auth::user()->hasRole('Founder');
    },

    // 站点配置的表单
    'edit_fields' => [
        'site_name' => [
            // 表单标题
            'title' => '应用名称',

            // 表单条目类型
            'type' => 'text',

            // 字数限制
            'limit' => 50,
        ]
    ],

    // 表单验证规则
    'rules' => [
        'site_name' => 'required|max:50'
    ],

    'messages' => [
        'site_name.required' => '请填写应用名称。',
    ],

    // 数据即将保持的触发的钩子，可以对用户提交的数据做修改
    'before_save' => function(&$data)
    {

    },

    // 你可以自定义多个动作，每一个动作为设置页面底部的『其他操作』区块
    'actions' => [

        // 清空缓存
        'clear_cache' => [
            'title' => '更新系统缓存',

            // 不同状态时页面的提醒
            'messages' => [
                'active' => '正在清空缓存...',
                'success' => '缓存已清空！',
                'error' => '清空缓存时出错！',
            ],

            // 动作执行代码，注意你可以通过修改 $data 参数更改配置信息
            'action' => function(&$data)
            {
                \Artisan::call('cache:clear');
                return true;
            }
        ],
    ],
];