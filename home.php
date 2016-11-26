<?php
$title = '首页';
require_once 'header.php';
echo '空空如也的首页';
echo FILE_PATH;
require_once 'user.model.php';
echo '<img src="'.get_gravatar('doudou19758@gmail.com').'">';
echo getIdByEmail('a@a.aa');
require_once 'footer.php';