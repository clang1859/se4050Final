<?php
//即使是注销时，也必须首先开始会话才能访问会话变量
session_start();
//使用一个会话变量检查登录状态
if(isset($_SESSION['user_id'])){
	if (isset ($_SESSION['url'])){
		$url = $_SESSION['url'];
	} else{
		$url = "storefront.html";
	}
    //如果存在一个会话cookie，通过将到期时间设置为之前1个小时从而将其删除
    if(isset($_COOKIE[session_name()])){
        setcookie(session_name(),'',time()-3600);
    }
    //使用内置session_destroy()函数调用撤销会话
    unset($_SESSION["user_id"]);
	unset($_SESSION["username"]);
	unset($_SESSION["password"]);
}
header('Location:'.$url);
//location首部使浏览器重定向到另一个页面
?>