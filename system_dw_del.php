<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>基本计量单位删除</title>
</head>
<body>
<?php
require_once(dirname(__FILE__)."/include/config_base.php");
require_once(dirname(__FILE__)."/include/config_rglobals.php");
require_once(dirname(__FILE__)."/include/checklogin.php");
if($id=='')ShowMsg('非法的执行操作','system_dw.php');
//检测分类的等级
$username=str_replace($cfg_cookie_encode,'',$_COOKIE["VioomaUserID"]);
$dsql=New Dedesql(false);
$query="select * from #@__dw where id='$id'";
$dsql->Setquery($query);
$dsql->Execute();
$rowcount=$dsql->GetTotalRow();
if($rowcount==0) //非法ID
ShowMsg('执行了非法的操作','-1');
else{
 $row=$dsql->GetArray();
 if($row['reid']==0){ //删除顶级分类
 $msql=New Dedesql(false);
 $msql->SetQuery("select * from #@__dw where reid='".$row['id']."'");
 $msql->Execute();
 if($msql->GetTotalRow()>=1)
 echo "<script language='javascript'>alert('你要删除的单位下有子单位,请先删除其子单位!');history.go(-1);</script>";
 else{
 $msql->ExecuteNoneQuery("delete from #@__dw where id='$id'");
 WriteNote('成功删除基本单位'.$row['dwname'],getdatetimemk(time()),getip(),$username);
 ShowMsg('删除计量单位成功','system_dw.php');
 }
 $msql->close();
 }
 else{//删除子分类
  $msql=New Dedesql(false);
  $msql->ExecuteNoneQuery("delete from #@__dw where id='$id'");
  WriteNote('成功删除子计量单位'.$row['dwname'],getdatetimemk(time()),getip(),$username);
  ShowMsg('成功删除子计量单位','system_dw.php');
  $msql->close();
 }
 $dsql->close();
}

?>
</body>
</html>
