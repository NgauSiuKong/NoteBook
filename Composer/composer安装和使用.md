##composer安装以及使用

###1，composer简介
	
**1>Composer**

		主要就是管理和安装程序中使用到的PHP依赖库，与此同时提供自动加载机制,
	方便依赖库的使用。

		注意:Composer必须是在php5.3之后引入的，所以只有php5.3以后的版本才可以使用

**2>Composer的主要作用**

	依赖管理: 程序中使用的php库，交给composer管理
	自动加载: 依赖库中的类以及用户自定义的类，Composer可以提供自动加载

###2,winsows下安装composer

	1，开启open_ssl服务
			在php.ini文件中，把注释的extension:extension=php_openssl.dll打开
		如果没有，直接添加进去即可。
			php文件夹下的： php_openssl.dll， ssleay32.dll， libeay32.dll 
		3个文件拷贝到 WINDOWS\system32\文件夹下
			重启服务器(apache)即可开启open_ssl服务
	
		注意:检查是否开启，用phpinfo查看即可

	2下载windows下composer的安装包(https://getcomposer.org/Composer-Setup.exe)
		下载完成后点击安装，下一步，下一步，下一步……。值得注意的是composer的安装目要指定在已安装的php.exe文件，
		如果集成环境，必须是当前版本。

	3，绑定环境变量,也就是当前php.exe的同级目录

	4，在cmd命令行中检查是否安装成功(composer -V)

	5,由于composer类库大部分部署在国外,需要配置中国镜像(加速),具体方法见https://pkg.phpcomposer.com/
		简而言之就是命令行下执行composer config -g repo.packagist composer https://packagist.phpcomposer.com
		命令即可,如果没有报错,安装成功

###3,composer用法以及实战
	
**下载第三方扩展库**

	搜索地址:https://packagist.org/
	进入页面之后可执行搜索需要的扩展库,点击进入之后可看到此库的说明以及下载
	在项目目录中执行下载语句可加载到此项目中

	注:下载的composer的扩展库都在vendor的目录下	

	composer.json	composer的配置文件，当前程序关于composer的配置信息

	安装方法:
		1,直接在命令行输入composer require [类库]的方式下载
		2,在composer.json的require中直接写入需要下载的类库,执行composer update即可

**常用命令**

	composer require [需要下载的类库]
		例如:composer require appbolaget/dd
			 composer require nesbot/carbon
	composer update
		需要提前在composer.json中定义，可下载可删除
			{
    			"require": {
       				"appbolaget/dd": "^1.1",
        			"nesbot/carbon": "^1.22"
    			}
			}
	composer install
		直接安装composer.json中定义的条件进行下载类库
		

**简单示例**

	<?php
    header('content-type:text/html;charset=utf-8');
    ini_set("display_errors",1);
    //使用dd扩展库 This package will add the helper functions dd and dump to your application.
    //引入composer加载文件
    require_once "./vendor/autoload.php";
    //使用dd友好方式输出并die掉程序函数和dump，友好方式输出函数
    $str = "hello word";
    $str1 = "NiuShao";
    $str2 = array(
        '1'=>'a',
        '2'=>'b',
        '3'=>'c',
    );
    /*
    echo $str;
    var_dump($str2);
    dump($str);
    dump($str1);
    dump($str2);
    dd($str2);
    dd($str2);
    */
    //使用carbon库,注意命名空间
    /*
    dump( Carbon\Carbon::now() );
    dd( Carbon\Carbon::now()->toDateTimeString());
    */

###自动加载

**简介**

	自动加载分三种情况
		基于PSR-4规范的自动加载
		基于类目录的自动加载
		基于函数库文件的自动加载

	自动加载使用流程：
		composer.json中定于自动加载规则
		使用命令composer dump-autoload生成自动加载文件
		程序中引入自动加载规则,适用自定义类

**实例说明**

	"autoload":{ 
    "psr-4":{ 
        "App\\":"app/"
    },
    "classmap":[ 
        "app/libs"
    ],
    "files":[ 
        "app/functions/fun.php"
    ]
	}

	psr-4，是psr-4规则自动加载,引入composer导入文件之后,开启
	命名空间,实例化此类的时候即可自动加载
	classmap:基于类目录自动加载,一般用户没有命名空间的类,实例
	化此目录下类的时候,可自动加载
	files,基于函数库文件的自动加载,一般对一些函数库的辅助函数,
	使用此函数的时候,配置完成即可自动加载

**代码实例**

	git clone https://github.com/NgauSiuKong/NoteBook.git
	下载即可



	