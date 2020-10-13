<?php
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/config_rglobals.php");
require_once(dirname(__FILE__)."/include/checklogin.php");
if($id=='')
ShowMsg('非法参数，请正确执行此文件。','-1');
if($action=='save'){
if($g_name==''){
ShowMsg('请输入供应商的名称','-1');
exit();
}
 $addsql="update #@__gys set g_name='$g_name',g_people='$g_people',g_address='$g_address',g_phone='$g_phone',g_qq='$g_qq' where id='$id'";
 $message= "修改供应商".$g_name."成功";
 $loginip=getip();
 $logindate=getdatetimemk(time());
 $username=str_replace($cfg_cookie_encode,'',$_COOKIE["VioomaUserID"]);
 $asql=New Dedesql(false);
 $asql->ExecuteNoneQuery($addsql);
 $asql->ExecuteNoneQuery("insert into #@__recordline(message,date,ip,userid) values('{$message}','{$logindate}','{$loginip}','$username')");
 $asql->close();
 showmsg('成功修改供应商资料','system_gys.php');
 exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link href="style/main.css" rel="stylesheet" type="text/css" />
<title><?php echo $cfg_softname;?>供应商管理</title>
</head>
<body>
<?php
$esql=New Dedesql(false);
$query="select * from #@__gys where id='$id'";
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
      <td><strong>&nbsp;供应商资料修改</strong></td>
     </tr>
	 <form action="system_gys_edit.php?action=save" method="post">
     <tr>
      <td bgcolor="#FFFFFF">
       <table width="100%" cellspacing="0" cellpadding="0" border="0" id="table_border">
	    <tr>
		 <td id="row_style">&nbsp;供应商名称:</td>
		 <td>
		 &nbsp;<input type="text" name="g_name" size="30" value="<?php echo $row['g_name'] ?>"><input type="hidden" name="id" value="<?php echo $id; ?>">
		 </td>
	    </tr>
	    <tr>
		 <td id="row_style">&nbsp;供应商地址:</td>
		 <td>
		 &nbsp;<input type="text" name="g_address" size="30" value="<?php echo $row['g_address'] ?>"></td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;联系人:</td>
		 <td>
		 &nbsp;<input type="text" name="g_people" size="10" value="<?php echo $row['g_people'] ?>"></td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;供应商电话:</td>
		 <td>
		 &nbsp;<input type="text" name="g_phone" size="15" value="<?php echo $row['g_phone'] ?>"></td>
	    </tr>	
		<tr>
		 <td id="row_style">&nbsp;即时联系(QQ):</td>
		 <td>
		 &nbsp;<input type="text" name="g_qq" size="20" value="<?php echo $row['g_qq'] ?>"></td>
	    </tr>			
		<tr>
		 <td id="row_style">&nbsp;</td>
		 <td>&nbsp;<input type="submit" name="submit" value=" 修改供应商资料 "></td>
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
