<?php
/*
 Author:WangJie
 Last Update:2016-07-07
 Develop Note:正在带着困意写码
 */

define('ROOT_PATH',__DIR__.'/');// 从内部请求请调用 ROOT_FILE
define('SITENAME','Lone First');
require_once ROOT_PATH.'config.php';
define('PATH',substr($_SERVER['REQUEST_URI'],strpos($_SERVER['PHP_SELF'],'index.php')));
define('FILE_PATH','//'.substr($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'],0,-9));// 从外部请求请调用 FILE_PATH
$tmp = explode('/',PATH);
if($tmp[0] == '') {
	$tmp[0] == 'home';
}
$function = array_shift($tmp);
for($i=0;isset($tmp[0]);$i+=1){
	$var[$i] = array_shift($tmp);
}
/*用户信息获取流程
① 得到邮箱、经MD5加密后的用户密码、cookie有效时间(本文设置的是两星期，可根据自己需要修改)
② 自定义的一个webKey，这个Key是我们为自己的网站定义的一个字符串常量，这个可根据自己需要随意设置
③ 将上两步得到的四个值得新连接成一个新的字符串，再进行MD5加密，这样就得到了一个MD5明文字符串
④ 将邮箱、cookie有效时间、MD5明文字符串使用“：”间隔连接起来，再对这个连接后的新字符串进行Base64编码
⑤ 设置一个cookieName,将cookieName和上一步产生的Base64编码写入到客户端。

2． 读取用户信息：
其实弄明白了保存原理，读取及校验原理就很容易做了。读取和检验可以分为下面几个步骤：
① 根据设置的cookieName，得到cookieValue，如果值为空，就不帮用户进行自动登陆；否则执行读取方法
② 将cookieValue进行Base64解码，将取得的字符串以split(“:”)进行拆分，得到一个String数组cookieValues（此操作与保存阶段的第4步正好相反），这一步将得到三个值：
       cookieValues[0] ---- 邮箱
       cookieValues[1] ---- cookie有效时间
       cookieValues[2] ---- MD5明文字符串
③ 判断cookieValues的长度是否为3，如果不为3则进行错误处理。
④ 如果长度等于3，取出第二个,即cookieValues[1]，此时将会得到有效时间（long型），将有效时间与服务器系统当前时间比较，如果小于当前时间，则说明cookie过期，进行错误处理。
⑤ 如果cookie没有过期，就取cookieValues[0]，这样就可以得到邮箱了，然后去数据库按邮箱查找用户。
⑥ 如果上一步返回为空，进行错误处理。如果不为空，那么将会得到一个已经封装好用户信息的User实例对象user
⑦ 取出实例对象user的邮箱、密码、cookie有效时间（即cookieValues[1]）、webKey，然后将四个值连接起来，然后进行MD5加密，这样做也会得到一个MD5明文字符串（此操作与保存阶段的第3步类似）
⑧ 将上一步得到MD5明文与cookieValues[2]进行equals比较，如果是false，进行错误处理；如果是true，则将user对象添加到session中，帮助用户完成自动登陆
 * */

session_start();
if (isset($_SESSION['user'])) {
	require_once 'user.model.php';
	$user['id'] = $_SESSION['user'];
	$user['email'] = getEmailById($user['id']);
}else{
	//verCookie();
}
function verCookie(){

	if(isset($_COOKIE['USS'])){
		$cookie = base64_decode($_COOKIE['USS']);
		$tmpb = explode(':',$cookie);
		if(count($tmpb) != 3){
			setcookie('USS',"",time()-1);
			header('Location:'.FILE_PATH);
		}
	}

}
if($function == '') {
	require_once ROOT_PATH.'home.php';
}elseif($function == 'logout'){
	unset($_SESSION['user']);
	header('Location:'.FILE_PATH);
}elseif(file_exists(ROOT_PATH.$function.'.php')){
	require_once ROOT_PATH.$function.'.php';
}else{
	header('Location:'.FILE_PATH);
}