<?php
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/config_rglobals.php");
require_once(dirname(__FILE__)."/include/checklogin.php");
if($id=='')
ShowMsg('非法参数，请正确执行此文件。','-1');
if($action=='save'){
if($b_name==''){
ShowMsg('请输入账户名称','-1');
exit();
}
if($b_default==1){
$sasql=New Dedesql(false);
$sasql->ExecuteNoneQuery("update #@__bank set bank_default=0");
$sasql->close();
}
$addsql="update #@__bank set bank_name='$b_name',bank_account='$b_account',bank_default='$b_default',bank_text='".$b_text."' where id='$id'";
 $message= "修改银行资料".$b_name."成功";
 $loginip=getip();
 $logindate=getdatetimemk(time());
 $username=str_replace($cfg_cookie_encode,'',$_COOKIE["VioomaUserID"]);
 WriteNote($message,$logindate,$loginip,$username);
 $isql=new dedesql(false);
 $isql->ExecuteNoneQuery($addsql);
 $isql->close();
 showmsg('成功修改了银行账户资料','bank.php');
 exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link href="style/main.css" rel="stylesheet" type="text/css" />
<title><?php echo $cfg_softname;?>银行管理</title>
</head>
<body>
<?php
$esql=New Dedesql(false);
$query="select * from #@__bank where id='$id'";
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
      <td><strong>&nbsp;银行资料修改</strong></td>
     </tr>
	 <form action="bank_edit.php?action=save" method="post">
     <tr>
      <td bgcolor="#FFFFFF">
       <table width="100%" cellspacing="0" cellpadding="0" border="0" id="table_border">
	    <tr>
		 <td id="row_style">&nbsp;银行名称:</td>
		 <td>
		 &nbsp;<input type="text" name="b_name" size="20" value="<?php echo $row['bank_name'] ?>" id="need"><input type="hidden" name="id" value="<?php echo $id; ?>">
		 </td>
	    </tr>
	    <tr>
		 <td id="row_style">&nbsp;金额:</td>
		 <td>
		 &nbsp;<input type="text" name="b_money" size="15" value="<?php echo $row['bank_money'] ?>" readonly>&nbsp;元</td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;账号:</td>
		 <td>
		 &nbsp;<input type="text" name="b_account" size="20" value="<?php echo $row['bank_account'] ?>"></td>
	    </tr>	
		<tr>
		 <td id="row_style">&nbsp;是否默认银行:</td>
		 <td>
		 <?php
		  if ($row['bank_default']==0)
		 echo "&nbsp;<select name=\"b_default\"><option value=\"1\">是</option><option value=\"0\" selected>否</option></select>&nbsp;只能保留一个默认银行";
		 else
		 echo "&nbsp;<select name=\"b_default\"><option value=\"1\" selected>是</option><option value=\"0\">否</option></select>&nbsp;只能保留一个默认银行";
		 ?>
		 </td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;备注:</td>
		 <td>
		 &nbsp;<textarea name="b_text" cols="40" rows="2"><?php echo $row['bank_text'] ?></textarea></td>
	    </tr>	
		<tr>
		 <td id="row_style">&nbsp;</td>
		 <td>&nbsp;<input type="submit" name="submit" value=" 修改银行资料 "></td>
	    </tr></form>
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
