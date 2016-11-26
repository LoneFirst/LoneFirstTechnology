<?php
require_once 'user.model.php';
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title><?php echo $title." | ".SITENAME;?></title>

    <!-- Bootstrap core CSS -->
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles -->
    <link href=<?php echo '"'.FILE_PATH.'style.css"'?> rel="stylesheet">
  </head>

  <body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand"><?php echo SITENAME;?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li <?php if($function == '' || $function == 'home'){echo "class='active'";}?> ><a href=<?php echo '"'.FILE_PATH.'"';?>>首页</a></li>
            <li <?php if($function == 'community'){echo "class='active'";}?> ><a href=<?php echo '"'.FILE_PATH.'community"';?>>社区</a></li>
            <li <?php if($function == 'share'){echo "class='active'";}?> ><a href=<?php echo '"'.FILE_PATH.'share"';?>>文件分享</a></li>
            <li <?php if($function == 'about'){echo "class='active'";}?> ><a href=<?php echo '"'.FILE_PATH.'about"';?>>关于</a></li>
            <!--
            <li class="dropdown">
              <a href="#" class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>-->
          </ul>

          <ul class="nav navbar-nav navbar-right">
          <?php 
          if (isset($user)) {
            echo "<li class='dropdown'>
                  <a href='' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'><img src='".get_gravatar($user['email'])."'> ".$user['email']."</a>
                    <ul class='dropdown-menu'>
                    <li><a href='".FILE_PATH."usercenter'>用户中心</a></li>
                    <li role='separator' class='divider'></li>
                    <li><a href='".FILE_PATH."logout'>登出</a></li>
                    </ul>
                </li>";
          }else{
            if($function == 'login' || $function == 'register') {
              echo "<li class='active'><a href='".FILE_PATH."login'>登陆/注册</a></li>";
            }else{
              echo "<li><a href='".FILE_PATH."login'>登陆/注册</a></li>";
            }
          }
          ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">