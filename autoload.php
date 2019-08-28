<?php

require_once __DIR__.'/vendor/autoload.php';

interface LoggerInterface
{
}
class_alias(\think\facade\Env::class, 'Env');
class_alias(\think\facade\Route::class, 'Route');
class_alias(LoggerInterface::class, 'think\LoggerInterface');
