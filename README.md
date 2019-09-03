Think-Casbin
====

[![Build Status](https://travis-ci.org/php-casbin/think-casbin.svg?branch=master)](https://travis-ci.org/php-casbin/think-casbin)
[![Coverage Status](https://coveralls.io/repos/github/php-casbin/think-casbin/badge.svg)](https://coveralls.io/github/php-casbin/think-casbin)
[![Latest Stable Version](https://poser.pugx.org/casbin/think-adapter/v/stable)](https://packagist.org/packages/casbin/think-adapter)
[![Total Downloads](https://poser.pugx.org/casbin/think-adapter/downloads)](https://packagist.org/packages/casbin/think-adapter)
[![License](https://poser.pugx.org/casbin/think-adapter/license)](https://packagist.org/packages/casbin/think-adapter)

[PHP-Casbin](https://github.com/php-casbin/php-casbin) 是一个强大的、高效的开源访问控制框架，它支持基于各种访问控制模型的权限管理。

[Think-Casbin](https://github.com/php-casbin/think-casbin) 是一个专为ThinkPHP5.1定制的Casbin的扩展包，使开发者更便捷的在thinkphp项目中使用Casbin。

> 针对 ThinkPHP6.0 现在推出了更加强大的扩展 [ThinkPHP 6.0 Authorization](https://github.com/php-casbin/think-authz).

### 知识储备

+ 熟练使用`Composer`包管理工具
+ 掌握ThinkPHP框架各个功能，例如：门面（Facade）、模型、数据库迁移工具等
+ 熟悉PHP命令行、ThinkPHP命令行的使用
+ 了解`Casbin`工作原理及用法

### 安装

1. 创建thinkphp项目（**如果没有**）：

```
composer create-project topthink/think=5.1.* tp5
```

2. 在`ThinkPHP`项目里，安装`Think-Casbin`扩展：

```
composer require casbin/think-adapter
```

3. 发布资源:

```
php think casbin:publish
```

这将自动创建model配置文件`config/casbin-basic-model.conf`，和Casbin的配置文件`config/casbin.php`。

4. 数据迁移:

由于Think-Casbin默认将Casbin的策略（Policy）存储在数据库中，所以需要初始化数据库表信息。

执行前，请**确保数据库连接信息配置正确**，如需单独修改`Casbin`的数据库连接信息或表名，可以修改`config/casbin.php`里的配置。

```
php think casbin:migrate
```

这将会自动创建Casbin的策略（Policy）表`casbin_rule`。

### 用法

#### 为用户分配权限

```php
use Casbin;

// 给用户alice赋予对data1的read权限
Casbin::addPolicy('alice', 'data1', 'read');
```

#### 判断是权限策略是否存在

```php
Casbin::hasPolicy('alice', 'data1', 'read'); // true
```

#### 移除权限

```php
Casbin::removePolicy('alice', 'data1', 'read');
```

#### 使用决策器，验证权限

```php

use Casbin;

$sub = 'alice'; // the user that wants to access a resource.
$obj = 'data1'; // the resource that is going to be accessed.
$act = 'read'; // the operation that the user performs on the resource.

if (true === Casbin::enforce($sub, $obj, $act)) {
    // permit alice to read data1
    echo 'permit alice to read data1';
} else {
    // deny the request, show an error
}
```

#### 自定义配置

`config/casbin-basic-model.conf`为Casbin的model文件

`config/casbin.php`为Casbin的adapter、db配置信息

#### 更多API参考

- [Management API](https://casbin.org/docs/en/management-api)
- [RBAC API](https://casbin.org/docs/en/rbac-api)

### 关于

**Think-Casbin**：

+ 实现基于Think-ORM的Adapter存储（将Policy存储在数据库中）
+ 实现Casbin的门面（think\Facade）调用，使用`\Casbin::`可以静态调用`PHP-Casbin`里`Enforcer`的所有方法。
+ 使用配置文件对Casbin的Model、Adapter的可配置化

通过Casbin官网 (https://casbin.org )查看更多用法。
