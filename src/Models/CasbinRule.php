<?php

namespace CasbinAdapter\Think\Models;

use think\Model;

class CasbinRule extends Model
{
    public function __construct($data = [])
    {
        parent::__construct($data);

        //TODO:初始化内容
        $this->connection = config('casbin.database.connection') ?: '';

        $this->table = config('casbin.database.casbin_rules_table');
    }
}
