<?php

if ('cli' === PHP_SAPI || 'phpdbg' === PHP_SAPI) {
    \think\Console::addDefaultCommands([
        'casbin:publish' => \CasbinAdapter\Think\Commands\Publish::class,
        'casbin:migrate' => \CasbinAdapter\Think\Commands\Migrate::class,
        'casbin:rollback' => \CasbinAdapter\Think\Commands\Rollback::class,
    ]);
}

\think\Loader::addClassAlias([
    'Casbin' => \CasbinAdapter\Think\Facades\Casbin::class,
]);
