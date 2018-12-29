<?php

return [
    /*
     * Model 设置
     */
    'model' => [
        // 可选值: "file", "text"
        'config_type' => 'file',

        'config_file_path' => env('config_path').'casbin-basic-model.conf',

        'config_text' => '',
    ],

    // 适配器 .
    'adapter' => CasbinAdapter\Think\Adapter::class,

    /*
     * 数据库设置.
     */
    'database' => [
        // 数据库连接名称，不填为默认配置.
        'connection' => '',

        // 策略表名（不含表前缀）
        'casbin_rules_name' => 'casbin_rule',

        // 策略表完整名称.
        'casbin_rules_table' => null,
    ],
];
