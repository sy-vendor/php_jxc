<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>操作员删除</title>
</head>
<body>
<?php
require_once(dirname(__FILE__)."/include/config_base.php");
require_once(dirname(__FILE__)."/include/config_rglobals.php");
require_once(dirname(__FILE__)."/include/checklogin.php");
if($id=='')ShowMsg('非法的执行操作','system_boss.php');
//检测分类的等级
$username=GetCookie("VioomaUserID");
$dsql=New Dedesql(false);
$query="select * from #@__boss where id='$id'";
$dsql->Setquery($query);
$dsql->Execute();
$rowcount=$dsql->GetTotalRow();
if($rowcount==0) //非法ID
ShowMsg('执行了非法的操作','-1');
else{
 $dsql->ExecuteNoneQuery("delete from #@__boss where id='$id'");
 WriteNote('成功删除操作员(ID为'.$id.')',getdatetimemk(time()),getip(),$username);
 ShowMsg('删除操作员资料成功','system_boss.php');
 }
 $dsql->close();
?>
</body>
</html>
