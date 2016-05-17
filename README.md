# 基于 laravel 5.2.* 的性能分析器，调试用

## 简介

laravel中，没有类型symfony中debug工具，`laravel-debugbar` 界面过于丑陋，处女座的我表示不能忍，在 `github` 上找了很久，发现唯一一个合我意的 [daylerees/anbu](https://github.com/daylerees/anbu) ，但并不支持 `laravel 5.2` , mark 一下继续寻找，发现 [itsgoingd/clockwork](https://github.com/itsgoingd/clockwork) , 支持 `laravel 5.2` 但是没有界面，需要结合 Chrome 插件来使用，还是不合我意，于是有了将两者合一的念头，这个项目这样诞生了

## 安装

- 安装依赖包
``` bash
composer require jhasheng/purple
```

- 添加以下 `ServiceProvider` 到 `config/app.php` 
``` php
\Jhasheng\Purple\PurpleServiceProvider::class,
```

- 添加中间件到 `Kernel.php`
``` php
\Jhasheng\Purple\Middleware\Purple.php,
```

- 发布资源文件 参数 `force` 可选，意为强制覆盖已经存在的文件，第二次运行时使用
``` bash
php artisan vendor:publish --provider='\Jhasheng\Purple\PurpleServiceProvider' --force
```


## 特性

- 收集项
    - Request
    - Log
    - Event
    - Page Debug
    - DB Query
    - Route
    - PHP Info
    
- 存储方式
    - MySQL
    - Redis
    - Mongo
    - Other