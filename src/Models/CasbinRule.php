<?php

namespace CasbinAdapter\Think\Models;

use think\Model;

class CasbinRule extends Model
{
    public function __construct($data = [])
    {
        $this->connection = config('casbin.database.connection') ?: '';

        $this->table = config('casbin.database.casbin_rules_table');

        $this->name = config('casbin.database.casbin_rules_name');

        parent::__construct($data);
    }
}
