<?php

namespace CasbinAdapter\Think\Commands;

use Db;

trait MigrateTrait
{
    protected function getPath()
    {
        return __DIR__.'/../../database/migrations';
    }

    protected function getDbConfig()
    {
        $connection = config('casbin.database.connection') ?: config('database.default');

        if ($connection) {
            $config = Db::connect()->getConfig();
            $config = $config[$connection];
            $dbConfig = [
                'adapter' => $config['type'],
                'host' => $config['hostname'],
                'name' => $config['database'],
                'user' => $config['username'],
                'pass' => $config['password'],
                'port' => $config['hostport'],
                'charset' => $config['charset'],
                'table_prefix' => $config['prefix'],
            ];

            $dbConfig['default_migration_table'] = $this->getConfig('table', $dbConfig['table_prefix'].'migrations');

            return $dbConfig;
        }

        return parent::getDbConfig();
    }
}
