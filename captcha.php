<?php
session_start();
// 验证码生成
$image = imagecreatetruecolor(100,30);
$bgcolor = imagecolorallocate($image,255,255,255);
imagefill($image,0,0,$bgcolor);
for($i=0;$i<100;$i++) {
    $pointcolor = imagecolorallocate($image,rand(50,200),rand(50,200),rand(50,200));
    imagesetpixel($image,rand(1,99),rand(1,29),$pointcolor);
}
for($i=0;$i<4;$i++) {
    $linecolor = imagecolorallocate($image,rand(80,220),rand(80,220),rand(80,220));
    imageline($image,rand(1,99),rand(1,29),rand(1,99),rand(1,29),$linecolor);
}
$captch_code = '';
for($i=0;$i<4;$i++) {
    $fontcolor = imagecolorallocate($image,rand(0,120),rand(0,120),rand(0,120));
    $data = 'abcdefghijkmnpqrstuvwxyz23456789';
    $fontcontent = substr($data,rand(0,strlen($data)),1);
    $x = ($i*100/4) + rand(5,10);
    $y = rand(5,10);
    $captch_code .= $fontcontent;
    imagestring($image,5,$x,$y,$fontcontent,$fontcolor);
}
$_SESSION['authcode'] = $captch_code;// 保存验证码内容
for($i=0;$i<100;$i++) {
    $pointcolor = imagecolorallocate($image,rand(50,200),rand(50,200),rand(50,200));
    imagesetpixel($image,rand(1,99),rand(1,29),$pointcolor);
}
for($i=0;$i<4;$i++) {
    $linecolor = imagecolorallocate($image,rand(80,220),rand(80,220),rand(80,220));
    imageline($image,rand(1,99),rand(1,29),rand(1,99),rand(1,29),$linecolor);
}
header('content-type:image/png');
imagepng($image);

imagedestroy($image);