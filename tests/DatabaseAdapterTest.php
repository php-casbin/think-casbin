<?php

namespace CasbinAdapter\Think\Tests;

use CasbinAdapter\Think\Facades\Casbin;

class DatabaseAdapterTest extends TestCase
{
    public function testEnforce()
    {
        $this->assertTrue(Casbin::enforce('alice', 'data1', 'read'));

        $this->assertFalse(Casbin::enforce('bob', 'data1', 'read'));
        $this->assertTrue(Casbin::enforce('bob', 'data2', 'write'));

        $this->assertTrue(Casbin::enforce('alice', 'data2', 'read'));
        $this->assertTrue(Casbin::enforce('alice', 'data2', 'write'));
    }

    public function testAddPolicy()
    {
        $this->assertFalse(Casbin::enforce('eve', 'data3', 'read'));
        Casbin::addPermissionForUser('eve', 'data3', 'read');
        $this->assertTrue(Casbin::enforce('eve', 'data3', 'read'));
    }

    public function testSavePolicy()
    {
        $this->assertFalse(Casbin::enforce('alice', 'data4', 'read'));

        $model = Casbin::getModel();
        $model->clearPolicy();
        $model->addPolicy('p', 'p', ['alice', 'data4', 'read']);

        $adapter = Casbin::getAdapter();
        $adapter->savePolicy($model);
        $this->assertTrue(Casbin::enforce('alice', 'data4', 'read'));
    }

    public function testRemovePolicy()
    {
        $this->assertFalse(Casbin::enforce('alice', 'data5', 'read'));

        Casbin::addPermissionForUser('alice', 'data5', 'read');
        $this->assertTrue(Casbin::enforce('alice', 'data5', 'read'));

        Casbin::deletePermissionForUser('alice', 'data5', 'read');
        $this->assertFalse(Casbin::enforce('alice', 'data5', 'read'));
    }

    public function testRemoveFilteredPolicy()
    {
        $this->assertTrue(Casbin::enforce('alice', 'data1', 'read'));
        Casbin::removeFilteredPolicy(1, 'data1');
        $this->assertFalse(Casbin::enforce('alice', 'data1', 'read'));
        $this->assertTrue(Casbin::enforce('bob', 'data2', 'write'));
        $this->assertTrue(Casbin::enforce('alice', 'data2', 'read'));
        $this->assertTrue(Casbin::enforce('alice', 'data2', 'write'));
        Casbin::removeFilteredPolicy(1, 'data2', 'read');
        $this->assertTrue(Casbin::enforce('bob', 'data2', 'write'));
        $this->assertFalse(Casbin::enforce('alice', 'data2', 'read'));
        $this->assertTrue(Casbin::enforce('alice', 'data2', 'write'));
        Casbin::removeFilteredPolicy(2, 'write');
        $this->assertFalse(Casbin::enforce('bob', 'data2', 'write'));
        $this->assertFalse(Casbin::enforce('alice', 'data2', 'write'));
    }
}
