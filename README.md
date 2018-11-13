# ThinkPHP-Casbin

一个专为ThinkPHP5.1定制的Casbin的扩展包（ https://github.com/php-casbin/think-casbin )。

### 安装

在你的thinkphp项目里，通过`composer`安装这个扩展

```
composer require casbin/think-adapter
```

发布资源:

```
php think casbin:publish
```

这将自动创建model配置文件`config/casbin-basic-model.conf`，和Casbin的配置文件`config/casbin.php`

数据迁移:

执行前，请确保数据库连接信息配置正确，如需修改数据库连接信息或表名，可以修改`config/casbin.php`里的配置

```
php think casbin:migrate
```

这将会自动创建Casbin的策略表`casbin_rule`

### 用法

```php

use Casbin;

$sub = 'alice'; // the user that wants to access a resource.
$obj = 'data1'; // the resource that is going to be accessed.
$act = 'read'; // the operation that the user performs on the resource.

if (true === Casbin::enforce($sub, $obj, $act)) {
    // permit alice to read data1x
    echo 'permit alice to read data1';
} else {
    // deny the request, show an error
}
```

### 自定义配置

`config/casbin-basic-model.conf`为Casbin的model文件

`config/casbin.php`为Casbin的adapter、db配置信息


### 关于Casbin

Casbin官网文档 (https://casbin.org )查看更多用法。