## 项目说明

模块插件:
该项目使用多模块插件进行开发,与原生laravel相比略作改变，

例如：php artisan module:make-controller PostsController Blog

其中Blog是模块的名称,该命令在Blog模块中创建了一个控制器。
其他各种命令使用工具请熟读文档。

1.插件源码地址:https://github.com/nWidart/laravel-modules

2.插件说明文档:https://nwidart.com/laravel-modules/v4/introduction

3.用户追踪插件:https://github.com/antonioribeiro/tracker

4.oss储存 :https://github.com/iiDestiny/laravel-filesystem-oss

5.验证码包: https://packagist.org/packages/mews/captcha

6.世界城市列表包: https://github.com/khsing/laravel-world

##前端脚手架:


##注意事项:
1.使用artisan如果出错 命令时需要在末尾指定对应env 例如：命令行 --env=local

##常用命令:
1.创建修改表的迁移文件 php artisan make:migration alter_TableName_table  --table=TableName
2.创建表 php artisan make:migration create_TableName_table
3.创建模型 php artisan make:model path/TableName
4.自动加载文件 composer dump-autoload
5.执行迁移 修改完迁移文件中的up 与 down方法后方可执行 php artisan migrate --env=local
6.第三方包发布配置:php artisan vendor:publish
7.回滚迁移 php artisan migrate:rollback  --env=local



##模块中命令:
1.模块中创建模型 php artisan module:make-model Name ModuleName
2.模块中创建控制器 hpp artisan module:make-controller Name ModuleName

