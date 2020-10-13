<?php
require(dirname(__FILE__)."/include/config_base.php");
$message='用户'.GetCookie('VioomaUserID').'成功退出系统';
$outtime=GetDatetimeMk(time());
$theip=getip();
WriteNote($message,$outtime,$theip,GetCookie('VioomaUserID'));
DropCookie('VioomaUserID');
?>