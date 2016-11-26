<?php
if(isset($user)){
  header('Location:'.FILE_PATH);
}
require_once 'DB.class.php';
require_once 'user.model.php';

if(isset($var[0]) && isset($var[1])) {

	$title = '邮箱验证';
	require_once 'header.php';
	$email = $var[0];
	$token = $var[1];
	if(!isUserExist($email)){
		$msg = [false,'邮箱不存在'];
	}else{
		$dbh = DB::get();
		$n = $dbh->query("SELECT `password`,`regtime` FROM `user` WHERE `email`='".$email."'");
		$r = $n->fetch(PDO::FETCH_ASSOC);
		if($token == md5($email.$r['password'].$r['regtime'])) {
			$n = $dbh->exec("UPDATE `user` SET `verified` = 1 WHERE `email`='".$email."'");
			if($n = 1) {
				$msg = [true,'邮箱验证成功'];
			}$msg = [false,'SQL执行错误，若遇到这种情况请立即联系站长'];
		}$msg = [false,'链接不正确'];
	}
	if ($msg[0]) {
      		?><div class="alert alert-success alert-dismissible" role="alert">
	        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <strong>SUCCESS!</strong><?php echo $msg[1];?> </div>
        				<?php 

	require_once 'footer.php';exit();
      	} else {
      	?>
        <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>错误!</strong> <?php echo $msg[1];?>
        </div><?php
	require_once 'footer.php';}
}else{
	header('Location:'.FILE_PATH);
}