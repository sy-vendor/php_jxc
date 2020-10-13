<?php
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/config_rglobals.php");
require_once(dirname(__FILE__)."/include/checklogin.php");
if($id=='')
ShowMsg('非法参数，请正确执行此文件。','-1');
if($action=='save'){
if($l_name==''){
ShowMsg('请输入新仓库','-1');
exit();
}
if($l_default==1){
$sasql=New Dedesql(false);
$sasql->ExecuteNoneQuery("update #@__lab set l_default=0");
$sasql->close();
}
 
 $addsql="update #@__lab set l_name='$l_name',l_city='$l_city',l_mang='$l_mang',l_default='$l_default' where id='$id'";
 $message= "修改仓库".$l_name."资料成功";
 $loginip=getip();
 $logindate=getdatetimemk(time());
 $username=str_replace($cfg_cookie_encode,'',$_COOKIE["VioomaUserID"]);
 $asql=New Dedesql(false);
 $asql->ExecuteNoneQuery($addsql);
 $asql->ExecuteNoneQuery("insert into #@__recordline(message,date,ip,userid) values('{$message}','{$logindate}','{$loginip}','$username')");
 $asql->close();
 showmsg('成功修改了仓库资料','system_lab.php');
 exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link href="style/main.css" rel="stylesheet" type="text/css" />
<title><?php echo $cfg_softname;?>仓库管理</title>
</head>
<body>
<?php
$esql=New Dedesql(false);
$query="select * from #@__lab where id='$id'";
$esql->SetQuery($query);
$esql->Execute();
if($esql->GetTotalRow()==0){
ShowMsg('非法调用参数,请重试','-1');
exit();
}
$row=$esql->GetOne($query);
$esql->close();
?>
<table width="100%" border="0" id="table_style_all" cellpadding="0" cellspacing="0">
  <tr>
    <td id="table_style" class="l_t">&nbsp;</td>
    <td>&nbsp;</td>
    <td id="table_style" class="r_t">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
	<table width="100%" border="0" cellpadding="0" cellspacing="2">
     <tr>
      <td><strong>&nbsp;仓库资料修改</strong></td>
     </tr>
	 <form action="system_lab_edit.php?action=save" method="post">
     <tr>
      <td bgcolor="#FFFFFF">
       <table width="100%" cellspacing="0" cellpadding="0" border="0" id="table_border">
	    <tr>
		 <td id="row_style">&nbsp;仓库名称:</td>
		 <td>
		 &nbsp;<input type="text" name="l_name" size="10" value="<?php echo $row['l_name'] ?>" id="need"><input type="hidden" name="id" value="<?php echo $id; ?>">
		 </td>
	    </tr>
	    <tr>
		 <td id="row_style">&nbsp;所在城市:</td>
		 <td>
		 &nbsp;<input type="text" name="l_city" size="30" value="<?php echo $row['l_city'] ?>"></td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;负责人:</td>
		 <td>
		 &nbsp;<input type="text" name="l_mang" size="15" value="<?php echo $row['l_mang'] ?>"></td>
	    </tr>	
		<tr>
		 <td id="row_style">&nbsp;是否默认仓库:</td>
		 <td>
		 <?php
		  if ($row['l_default']==0)
		 echo "&nbsp;<select name=\"l_default\"><option value=\"1\">是</option><option value=\"0\" selected>否</option></select>&nbsp;只能保留一个默认仓库";
		 else
		 echo "&nbsp;<select name=\"l_default\"><option value=\"1\" selected>是</option><option value=\"0\">否</option></select>&nbsp;只能保留一个默认仓库";
		 ?>
		 </td>
	    </tr>	
		<tr>
		 <td id="row_style">&nbsp;</td>
		 <td>&nbsp;<input type="submit" name="submit" value=" 修改仓库资料 "></td>
	    </tr>
		</form>
	   </table>
	  </td>
	 </tr>
	</table>
	</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td id="table_style" class="l_b">&nbsp;</td>
    <td>&nbsp;</td>
    <td id="table_style" class="r_b">&nbsp;</td>
  </tr>
</table>
<?php
copyright();
?>
</body>
</html>
