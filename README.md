# 基于 laravel 5 的性能分析器

![image](https://github.com/jhasehng/purple/raw/master/screenShots/purple.jpg)

## 由来

- 无类似 `Symfony` 中 `debug` 工具
- `laravel-debugbar` 界面过于丑陋，处女座的我表示不能忍
- [daylerees/anbu](https://github.com/daylerees/anbu) ，但并不支持 `laravel 5` , mark 一下
- [itsgoingd/clockwork](https://github.com/itsgoingd/clockwork) , 支持 `laravel 5` 但是没有界面，需要结合 Chrome 插件来使用
- 还是不合我意，于是有了将两者合一的念头

## 安装

- 安装依赖包
``` bash
composer require jhasheng/purple
```

- 添加以下 **ServiceProvider** 到 **config/app.php** 
``` php
Purple\ServiceProvider\PurpleServiceProvider::class,
```

- 添加中间件到 **Kernel.php**
``` php
\Purple\Middleware\Purple::class,
```

- 发布资源文件 参数 **force** 可选，意为强制覆盖已经存在的文件，第二次运行时使用，中括号内为可选参数，**tag** 参数为发布指定类型文件（配置，静态资源，数据库文件）
``` bash
php artisan vendor:publish --provider='Purple\ServiceProvider\PurpleServiceProvider' [--force] [--tag="purple.config|purple.assets|purple.sql"]
```

- 安装数据库
``` bash
composer dump-autoload
php artisan migration
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
