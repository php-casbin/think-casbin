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
        
        $this->table = $this->connection ? config('database.'.config('casbin.database.connection').'.prefix') : config('database.prefix');

        $this->table = config('casbin.database.casbin_rules_table');
    }
}
