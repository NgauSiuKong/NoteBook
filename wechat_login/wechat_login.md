#微信二维码扫描登录

		最近做了微信二维码扫描登录的工作。实则非常简单。
		其实就是各种接口互相调用，收取参数跳页的过程。不过不熟练
	的情况下，会比较麻烦，无从下手。从查阅开发文档到工作的完成，现
	在总结以下步骤。


###原理步骤
	1,展示微信用户需要扫描的二维码
	2,微信用户扫码，以及确认登录(分两种情况，一种已经注册，另一种没有注册)
	3,通过确认登录的过程，验证密匙，接受数据，处理数据(可分辨出是否注册)
		1>用户已注册:
			查询用户详细信息，然后加入session直接登录
		2>用户未注册:
			将接收到的用户详细信息插入数据表,存如session,直接登
			录 ( 注意:意义不大，通常是跳到用户微信绑定页面，获取
			用户电话号码等详细信息 ) 
		
			附带激活页面:（绑定手机等）
				如果跳到了激活页面，输入用户信息，提交注册即可。
	
			
###准备工作

	在微信开放平台(open.weixin.qq.com)申请appid和appsecret.

###代码实现
	
**1，展示二维码**
		
		有两种方式可供选择:
		1，点击微信登录，跳页展示二维码。
			配合自己申请的参数跳如下链接即可：
				https://open.weixin.qq.com/connect/qrconnect?
				appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&
				scope=SCOPE&state=STATE#wechat_redirect
		
			参数				是否必须		说明
			-------------------------------------------------------------------------------
			appid				是			应用唯一标识(申请)
			-------------------------------------------------------------------------------
			redirect_uri		是			请使用urlEncode对链接进行处理(用户确认后需要跳的页面url
										 	需要使用url_encode编码)
			-------------------------------------------------------------------------------
			response_type		是			填code即可
			-------------------------------------------------------------------------------
			scope				是			写snsapi_login即可
			-------------------------------------------------------------------------------
			state				否			自定义密匙，防攻击。用
										 	该参数可用于防止csrf攻击（跨站请求伪造攻击）
										 	，建议第三方带上该参数，可设置为
										 	简单的随机数加session进行校验
			-------------------------------------------------------------------------------

		2，把需要扫描的二维码直接展示在登录页	
			html页面中操作:
				1,引入html页面:
				<script src="http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>
				2,html下面加入这段js对象	
				<script type="text/javascript">
					var obj = new WxLogin({
                              id:"login_container", 
                              appid: "", 
                              scope: "", 
                              redirect_uri: "",
                              state: "",
                              style: "",//样式
                              href: ""	//样式    样式查阅开发文档即可
                            });
				</script>
				3，需要展示二维码的地方加入如下标签(注意id和js对象的id要一致)
				<div class="login_fast" id="login_container">


**2，扫描二维码及处理**

			跳到redirect_uri网址,带上code和state参数。如果用户不允许登录，只带state参数。
			这里只讨论用户允许登录的情况下。
			---------------------------------------------------------------------
			1，根据code，以及申请的appid，secret来获取access_token
			例如:
				https://api.weixin.qq.com/sns/oauth2/access_token?
				appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code
			刷新access_token
			例如：
				https://api.weixin.qq.com/sns/oauth2/refresh_token?
				appid=APPID&grant_type=refresh_token&refresh_token=REFRESH_TOKEN
			注意：
			access_token 为用户授权第三方应用发起接口调用的凭证（相当于用户登录态），存储
			在客户端
			---------------------------------------------------------------------
			2，获取用户个人信息
			http请求方式: GET
			https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID

**3，代码示例**

	<?php
	    session_start();
	    //检查state参数，如果不同，禁止页面向下执行
	    if($local_state != $_GET['state']){ 
	        return false;
	        exit('state有误');
	    }
	    //获取access_token
	    $appid = "appid";
	    $secret = "secret";
	    $code = $_GET['code'];
	    $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
	    $ch = curl_init();
	    $timeout = 0;
	    curl_setopt ($ch, CURLOPT_URL, $url);
	    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch,  CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
	    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	    $res = curl_exec($ch);
	    curl_close($ch);
	    //get_object_vars()获取$object对象中的属性，组成一个数组
	    $array=get_object_vars(json_decode($res));
	    //获取用户信息利用open_id和access_token
	    $access_token=$array['access_token'];
	    //授权用户唯一标识
	    $openid=$array['openid'];
	    $url="https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid;
	    $ch = curl_init();
	    $timeout = 0;
	    curl_setopt ($ch, CURLOPT_URL, $url);
	    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($ch,  CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
	    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	    $res = curl_exec($ch);
	    curl_close($ch);
	    $callback_data= json_decode($res);
	    $array=get_object_vars($callback_data);
	
	    /*获取到用户信息就可以进行查询用户的注册信息
	    以及获得如何跳页，如何处理等等
	    */

			

		