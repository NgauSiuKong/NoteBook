##php获取客户端ip地址

###简介

	最近做的项目需要php获取网站客户端访问的ip地址,其实原理很简单，从
	php的$_SERVER全局数组中直接获取即可。不过有的时候服务器不同或者
	代理服务器等等问题,索性全部总结一遍，基本各种情况都考虑到了，直接
	使用即可

###代码

	<?php

	function real_ip()
	{
	    //静态变量只存在于函数作用域内，也就是说，静态变量只存活在栈中。一般的函数内变量在函数结束后会释放，比如局部变量，但是静态变量却不会
	    static $realip = NULL;
	    if ($realip !== NULL)
	    {
	        return $realip;
	    }
	    //可获取到$_SERVER的情况下
	    if(isset($_SERVER)){
	        //如果客户端用了代理ip
	        if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
	            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
	            /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
	            foreach ($arr AS $ip){
	                $ip = trim($ip);
	                if ($ip != 'unknown'){
	                    $realip = $ip;
	                    break;
	                }
	            }
	        //代理ip
	        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])){
	            $realip = $_SERVER['HTTP_CLIENT_IP'];
	        //握手ip，有代理则是代理ip，没有代理则是真实ip
	        }else{
	            if (isset($_SERVER['REMOTE_ADDR'])){
	                $realip = $_SERVER['REMOTE_ADDR'];
	            }else{
	                $realip = '0.0.0.0';
	            }
	        }
	    //获取不到$_SERVER的情况下
	    }else{
	        if (getenv('HTTP_X_FORWARDED_FOR')){
	            $realip = getenv('HTTP_X_FORWARDED_FOR');
	        }elseif (getenv('HTTP_CLIENT_IP')){
	            $realip = getenv('HTTP_CLIENT_IP');
	        }else{
	            $realip = getenv('REMOTE_ADDR');
	        }
	    }
	    //最后正则过滤ip地址
	    preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
	    $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';
	    return $realip;
	}
	echo real_ip();
	
