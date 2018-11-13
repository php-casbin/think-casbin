<?php

namespace CasbinAdapter\Think\Commands;

use think\console\Command;
use think\console\Input;
use think\console\Output;

class Publish extends Command
{
    protected function configure()
    {
        $this->setName('casbin:publish')->setDescription('Publish Casbin');
    }

    protected function execute(Input $input, Output $output)
    {
        if (!file_exists(env('config_path').'casbin-basic-model.conf')) {
            copy(__DIR__.'/../../config/casbin-basic-model.conf', env('config_path').'casbin-basic-model.conf');
        }

        if (!file_exists(env('config_path').'casbin.php')) {
            copy(__DIR__.'/../../config/casbin.php', env('config_path').'casbin.php');
        }
    }
}
