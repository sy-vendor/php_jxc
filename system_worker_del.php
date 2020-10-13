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
if($id=='')ShowMsg('非法的执行操作','system_worker.php');
//检测分类的等级
$username=str_replace($cfg_cookie_encode,'',$_COOKIE["VioomaUserID"]);
$dsql=New Dedesql(false);
$query="select * from #@__staff where id='$id'";
$dsql->Setquery($query);
$dsql->Execute();
$rowcount=$dsql->GetTotalRow();
if($rowcount==0) //非法ID
ShowMsg('执行了非法的操作','-1');
else{
 $dsql->ExecuteNoneQuery("delete from #@__staff where id='$id'");
 $dsql->ExecuteNoneQuery("delete from #@__boss where boss='$buser'");
 WriteNote('成功删除职工资料(ID为'.$id.')',getdatetimemk(time()),getip(),$username);
 ShowMsg('成功删除公司职工资料','system_worker.php');
 }
 $dsql->close();
?>
</body>
</html>
