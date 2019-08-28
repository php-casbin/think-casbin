<?php

use think\migration\Migrator;

class CasbinRule extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $table = $this->table(config('casbin.database.casbin_rules_name'));
        $table->addColumn('ptype', 'string', ['null' => true])
            ->addColumn('v0', 'string', ['null' => true])
            ->addColumn('v1', 'string', ['null' => true])
            ->addColumn('v2', 'string', ['null' => true])
            ->addColumn('v3', 'string', ['null' => true])
            ->addColumn('v4', 'string', ['null' => true])
            ->addColumn('v5', 'string', ['null' => true])
            ->create();
    }

    public function down()
    {
        $table = $this->table(config('casbin.database.casbin_rules_name'));
        $table->drop();
    }
}
