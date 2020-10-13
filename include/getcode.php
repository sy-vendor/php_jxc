<?php
//启动会话，将产生的验证码保存到会话变量中
//Session保存路径
$sessSavePath = dirname(__FILE__)."/../data/sessions/";
if(is_writeable($sessSavePath) && is_readable($sessSavePath)){ session_save_path($sessSavePath); }
session_start();//
function getrandom ($length,$mode)
{ 
switch ($mode)
{ 
case '1': 
$str = '1234567890'; 
break; 
case '2': 
$str = 'abcdefghijklmnopqrstuvwxyz';
break;
case '3': 
$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
break;
case '4': 
$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
break;
case '5': 
$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
break;
case '6': 
$str = 'abcdefghijklmnopqrstuvwxyz1234567890';
break;
default: 
$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890'; 
break; 
} 
$result = ''; 
$l = strlen($str);
for($i = 0;$i < $length;$i++)
{
$num = rand(0, $l-1); 
$result .= $str[$num]; 
} 
return $result;
}
if(function_exists("imagecreate"))
{
mt_srand((double)microtime()*1000000);
$mode = 1;//mt_rand(1,5);
$text=getrandom(4,$mode);//取得验证码！
$_SESSION["v_ckstr"] = strtolower($text);//初始化变量

Header("Content-type: image/PNG");
$im=imagecreate(60,40);//制定图片背景大小
$black = ImageColorAllocate($im, 0,0,0); //设定三种颜色
$white = ImageColorAllocate($im, 255,255,255);
$gray = ImageColorAllocate($im, 200,200,200); 
imagefill($im,0,0,$white); //填充背景色//采用区域填充法，设定（0,0）

// 用 col 颜色将字符串 s 画到 image 所代表的图像的 x，y 座标处（图像的左上角为 0, 0）。
//如果 font 是 1，2，3，4 或 5，则使用内置字体
imagestring($im, 6, 15, 10, $text, $black);//将四位整数验证码绘入图片 

for($i=0;$i<200;$i++) //加入干扰象素 
{ 
$randcolor = ImageColorallocate($im,rand(0,255),rand(0,255),rand(0,255));
imagesetpixel($im, rand()%70 , rand()%40 , $randcolor); 
} 

imagepng($im); 
imagedestroy($im);
}
else
{
//不支持GD，只输出字母 ABCD	
	//PutCookie("dd_ckstr","abcd",1800,"/");
	$_SESSION['v_ckstr'] = "abcd";
	header("content-type:image/jpeg\r\n");
	header("Pragma:no-cache\r\n");
  header("Cache-Control:no-cache\r\n");
  header("Expires:0\r\n");
	$fp = fopen("./vdcode.jpg","r");
	echo fread($fp,filesize("./vdcode.jpg"));
	fclose($fp);
}
?>