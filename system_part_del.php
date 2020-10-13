<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>部门删除</title>
</head>
<body>
<?php
require_once(dirname(__FILE__)."/include/config_base.php");
require_once(dirname(__FILE__)."/include/config_rglobals.php");
require_once(dirname(__FILE__)."/include/checklogin.php");
if($id=='')ShowMsg('非法的执行操作','system_part.php');
//检测分类的等级
$username=GetCookie("VioomaUserID");
$dsql=New Dedesql(false);
$query="select * from #@__part where id='$id'";
$dsql->Setquery($query);
$dsql->Execute();
$rowcount=$dsql->GetTotalRow();
if($rowcount==0) //非法ID
ShowMsg('执行了非法的操作','-1');
else{
 $dsql->ExecuteNoneQuery("delete from #@__part where id='$id'");
 WriteNote('成功删除部门(ID为'.$id.')',getdatetimemk(time()),getip(),$username);
 ShowMsg('删除部门资料成功','system_part.php');
 }
 $dsql->close();
?>
</body>
</html>
