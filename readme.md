##帮助文档

先执行 `composer install` 安装

###更改数据库信息

***app/config/database.php***

-----

###安装命令，初始化数据库:

	php artisan migrate
	php artisan db:seed

-----

###初始化类：（git更新后请执行）

	php artisan dump-autoload

-----

###更改文件夹权限.

    chmod -R 775 app/storage

不能执行、尝试：

    chmod -R 777 app/storage

-----

####前台账号：

	邮箱 : demo@demo.com
	密码 : demo

####后台账号 :

    账号：admin
    密码：admin

##MIT license




