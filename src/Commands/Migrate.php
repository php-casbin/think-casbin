<?php

namespace CasbinAdapter\Think\Commands;

use think\migration\command\migrate\Run as MigrateRun;

class Migrate extends MigrateRun
{
    use MigrateTrait;

    protected function configure()
    {
        parent::configure();
        $this->setName('casbin:migrate')->setDescription('Migrate the database for Casbin');
    }
}
