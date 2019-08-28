<?php

namespace CasbinAdapter\Think\Commands;

use think\migration\command\migrate\Rollback as MigrateRollback;

class Rollback extends MigrateRollback
{
    use MigrateTrait;

    protected function configure()
    {
        parent::configure();
        $this->setName('casbin:rollback')->setDescription('Rollback the last or to a specific migration for Casbin');
    }
}
