<?php
if(!isset($user)){
  header('Location:'.FILE_PATH.'login');
}
require_once 'DB.class.php';
if(isset($var[0])) {
	if($var[0] == 'getfile'){
		if(!isset($var[1])) {
		echo '参数缺失';exit;
		}
	}
}




/*
@param string
@return array (string [,string])
将带有目录的文件名拆分成数组
第一个元素是目录，第二个元素是文件名
如果传入本身是目录，那么第二个元素不会设置
*/
function getDN($var){
	if(strrpos($var,'/') == strlen($var)) {
		return [$var,];
	}
	return [substr($var,0,strrpos($var,'/')+1),substr($var,-strrpos($var,'/'))];
}

function ls($dir){
	$db = DB::get();
    $n = $db->query("SELECT `name`,`type`,`size`,`creater`,`update_time`,`down` FROM `file` WHERE `dir`='".$dir."'");
	return $n->fetchAll();
}