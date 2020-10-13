<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>职工删除</title>
</head>
<body>
<?php
require_once(dirname(__FILE__)."/include/config_base.php");
require_once(dirname(__FILE__)."/include/config_rglobals.php");
require_once(dirname(__FILE__)."/include/checklogin.php");
if($id=='')ShowMsg('非法的执行操作','system_kc.php');
$username=str_replace($cfg_cookie_encode,'',$_COOKIE["VioomaUserID"]);
if($action=='del'){
$dsql=New Dedesql(false);
$query="select * from #@__mainkc where kid='$id'";
$dsql->Setquery($query);
$dsql->Execute();
$rowcount=$dsql->GetTotalRow();
if($rowcount==0) //非法ID
ShowMsg('执行了非法的操作','-1');
else{
 $dsql->ExecuteNoneQuery("delete from #@__mainkc where kid='$id'");
 WriteNote('成功删除库存产品('.get_name($id,'name').')',getdatetimemk(time()),getip(),$username);
 ShowMsg('成功删除库存产品基本信息','system_kc.php');
 }
 $dsql->close();
 }
 else{//批量删除
 }
?>
</body>
</html>
