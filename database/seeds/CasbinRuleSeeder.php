<?php

use think\migration\Seeder;

class CasbinRuleSeeder extends Seeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $rules = [
            ['ptype' => 'p','v0' => 'alice','v1' => 'data1','v2' => 'read'],
            ['ptype' => 'p','v0' => 'alice','v1' => 'data2','v2' => 'read'],
            ['ptype' => 'p','v0' => 'alice','v1' => 'data2','v2' => 'write'],
            ['ptype' => 'p','v0' => 'bob','v1' => 'data1','v2' => 'read'],
            ['ptype' => 'p','v0' => 'bob','v1' => 'data2','v2' => 'write'],
        ];
        foreach($rules as $rule){
            $this->table(config('casbin.database.casbin_rules_name'))->insert($rule)->save();
        }
    }
}