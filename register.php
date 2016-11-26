<?php
if(isset($user)){
  header('Location:'.FILE_PATH);
}

$title = '注册';
require_once 'header.php';
?>
<script>
    var email = false;
    var pw = false;
    function cg() {
        document.getElementById('cap').src="./captcha.php?r="+Math.random();
    }
    function jk() {
        if (email && pw) {
            document.getElementById("btn").innerHTML="<button id='submit' type='submit' class='btn btn-default'>注册</button>";
        } else {
            document.getElementById("btn").innerHTML="<button id='submit' type='submit' class='btn btn-default' disabled>注册</button>";
        }
    }
    function emailoninput() {
        if (RegExp(/^([\w-_]+(?:\.[\w-_]+)*)@((?:[a-z0-9]+(?:-[a-zA-Z0-9]+)*)+\.[a-z]{2,6})$/).test(document.getElementById('email').value)) {
            email = true;
            document.getElementById('emailf').className = "form-group has-success";
        } else {
            email = false;
            document.getElementById('emailf').className = "form-group has-error";
        }
        jk();
    }
    function pwoninput() { 
        if (RegExp(/^(?=.*\d.*\d+)(?=.*[a-zA-Z].*[a-zA-Z]+).{8,60}$/).test(document.getElementById('password').value)) {
            pw = true;
            document.getElementById('pwf').className = "form-group has-success";
        } else {
            pw = false;
            document.getElementById('pwf').className = "form-group has-error";
        }
        jk();
    }
</script>
<?php
require_once 'user.model.php';

// 有空把这里变成链式的，现在头疼先放着 233
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_POST['email']) && isset($_POST['password'])) {
		$email = $_POST['email'];
		if (preg_match("/^([\w-_]+(?:\.[\w-_]+)*)@((?:[a-z0-9]+(?:-[a-zA-Z0-9]+)*)+\.[a-z]{2,6})$/",$email)) {
			if(!isUserExist($email)) {
				$password = $_POST['password'];
				if (preg_match("/^(?=.*\d.*\d+)(?=.*[a-zA-Z].*[a-zA-Z]+).{8,60}$/", $password)) {
					if(newUser($email,password_hash($password,PASSWORD_BCRYPT))) {
						$msg = [true,'注册成功，已向您的邮箱发送注册邮件。请查收邮件并点击邮件中的链接以此验证你的邮箱是正确的。链接仅当日有效'];
					}else{$msg = [false,'SQL执行失败或者邮件发送失败，若遇到这种情况请立即联系站长'];}
				}else{$msg = [false,'密码不符合规范'];}
			}else{$msg = [false,'邮件已存在，请尝试登陆或找回密码'];}
		}else{$msg = [false,'请输入正确的邮箱地址'];}
	}else{$msg = [false,'请提交数据'];}
}
?>
<div class="container">
  <div class="row">
    <div class="col-md-6">
      <h2>注册</h2>
      <?php if (isset($msg)) {
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
        </div>
      <?php }}?>
      <form class="form-horizontal" action="" method="post">
          <div id="emailf" class="form-group">
            <label class="col-sm-2 control-label">邮箱</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="email" name="email" placeholder="邮箱" oninput="emailoninput()">
            </div>
          </div>
          <div id="pwf" class="form-group">
            <label class="col-sm-2 control-label">密码</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" id="password" name="password" placeholder="密码" oninput="pwoninput()">
            </div>
          </div>
          <div class="form-group">
            <div id="btn" class="col-sm-offset-2 col-sm-10">
              <button id="submit" type="submit" class="btn btn-default" disabled>注册</button>
            </div>
          </div>
        </form>
    </div>
    <div class="col-md-6">
    </div>
    </div>
</div>
<?php
	require_once 'footer.php';