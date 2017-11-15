#composer安装以及使用

##1，composer简介
	
**1>Composer**

		主要就是管理和安装程序中使用到的PHP依赖库，与此同时提供自动加载机制,
	方便依赖库的使用。

		注意:Composer必须是在php5.3之后引入的，所以只有php5.3以后的版本才可以使用

**2>Composer的主要作用**

	依赖管理: 程序中使用的php库，交给composer管理
	自动加载: 依赖库中的类以及用户自定义的类，Composer可以提供自动加载

##2,winsows下安装composer

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

##3,composer用法以及实战
	