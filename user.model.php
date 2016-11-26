<?php
require_once 'DB.class.php';
require_once 'send.php';
function isUserExist($email){
	$dbh = DB::get();
	$n = $dbh->query("SELECT * FROM `user` WHERE `email`='".$email."'");
	$r = $n->fetch();
	if ($r) {
		return true;
	}return false;
}

function newUser($email,$password){
	$dbh = DB::get();
	$time = time();
    $sql = "INSERT INTO `user` (`email`, `password`, `verified`,`regtime`)
VALUES (?,?,0,?);";
    $sth = $dbh->prepare($sql);
    $subject = "[".SITENAME."] 这是一封邮箱验证邮件";
    $verifyToken = md5($email.$password.$time);
    $url = FILE_PATH.'verified/'.$email.'/'.$verifyToken;
    $message = "
	<html>
	<body>
	尊敬的用户您好：
	<p>
	您使用了邮箱 ".$email." 注册成为 ".SITENAME." 的会员。请点击以下链接，确认您在".SITENAME."的注册：<br>
	<a href='".$url."' target='_blank'>".$url."</a><br><br>

	如果以上链接不能点击，你可以复制网址URL，然后粘贴到浏览器地址栏打开，完成确认。<br><br>

	".SITENAME."<br><br>

	（这是一封自动发送的邮件，请不要直接回复）<br><br>

	说明<br><br>

	－如果你没有注册过'".SITENAME."，可能是有人尝试使用你的邮件来注册，请忽略本邮件。<br>
	－没有激活的账号当日内会为你保留, 请尽快激活。<br>
	－今天过后, 没有被激活的注册会自动失效，你需要重新填写并注册。<br>
	</p>
	</div>
	</body>
	</html>";
    sendMail($email,$subject,$message);
    return $sth->execute([$email,$password,$time]);
}

function verPassword($email,$password){
	$dbh = DB::get();
	$n = $dbh->query("SELECT `password` FROM `user` WHERE `email`='".$email."'");
	$r = $n->fetch();
	return password_verify($password,$r[0]);
}

function getIdByEmail($email){
	$dbh = DB::get();
	$n = $dbh->query("SELECT `id` FROM `user` WHERE `email`='".$email."'");
	$r = $n->fetch();
	return $r[0];
}

function getEmailById($id){
	$dbh = DB::get();
	$n = $dbh->query("SELECT `email` FROM `user` WHERE `id`='".$id."'");
	$r = $n->fetch();
	return $r[0];
}

function get_gravatar( $email, $s = 18, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

function delUserByEmail($email){}
function delUserById($id){}