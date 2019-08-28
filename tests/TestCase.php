<?php

namespace CasbinAdapter\Think\Tests;

use think\App;
use think\Console;
use think\Db;
use PHPUnit\Framework\TestCase as BaseTestCase;
use CasbinAdapter\Think\Models\CasbinRule;

class TestCase extends BaseTestCase
{
    protected $app;

    protected $migrate = true;

    public function createApplication()
    {
        // 应用初始化
        $app = new App(__DIR__.'/../vendor/topthink/think/application/');

        $app->initialize();

        // 数据库配置初始化
        Db::init(array_merge($app->config->pull('database'), [
            'type' => $app->env->get('DATABASE_TYPE', 'mysql', false),
            'hostname' => $app->env->get('DATABASE_HOSTNAME', '127.0.0.1', false),
            'database' => $app->env->get('DATABASE_DATABASE', 'casbin', false),
            'username' => $app->env->get('DATABASE_USERNAME', 'root', false),
            'password' => $app->env->get('DATABASE_PASSWORD', '', false),
            'hostport' => $app->env->get('DATABASE_HOSTPORT', '3306', false),
        ]));

        $app->set('console', Console::init(false));

        $app->config->load(__DIR__.'/../config/casbin.php', 'casbin');

        $app->console->call('casbin:publish');

        return $app;
    }

    /**
     * 初始数据.
     */
    protected function initTable()
    {
        CasbinRule::where('1 = 1')->delete(true);
        CasbinRule::create(['ptype' => 'p', 'v0' => 'alice', 'v1' => 'data1', 'v2' => 'read']);
        CasbinRule::create(['ptype' => 'p', 'v0' => 'bob', 'v1' => 'data2', 'v2' => 'write']);
        CasbinRule::create(['ptype' => 'p', 'v0' => 'data2_admin', 'v1' => 'data2', 'v2' => 'read']);
        CasbinRule::create(['ptype' => 'p', 'v0' => 'data2_admin', 'v1' => 'data2', 'v2' => 'write']);
        CasbinRule::create(['ptype' => 'g', 'v0' => 'alice', 'v1' => 'data2_admin']);
    }

    /**
     * Refresh the application instance.
     */
    protected function refreshApplication()
    {
        $this->app = $this->createApplication();
    }

    /**
     * This method is called before each test.
     */
    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        if (!$this->app) {
            $this->refreshApplication();
        }

        $this->app->console->call('casbin:migrate');

        $this->initTable();
    }

    /**
     * This method is called after each test.
     */
    protected function tearDown()/* The :void return type declaration that should be here would cause a BC issue */
    {
        if ($this->migrate) {
            $this->app->console->call('casbin:rollback');
        }
    }
}
