<?php
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/config_rglobals.php");
if($action=='save'){
if($id==''){
ShowMsg('非法参数，请正确执行此文件。','-1');
exit();
}
if($password==''){
showmsg('请输入原始密码','-1');
exit();
}
if($password1!=$password2){
showmsg('两次输入的新密码不一致','-1');
exit();
}
$equery="select * from #@__boss where password='".md5($password)."' and id='$id'";
$esql=new dedesql(false);
$esql->setquery($equery);
$esql->execute();
$allrow=$esql->gettotalrow();
if($allrow==0){
showmsg('你输入的原始密码不正确','-1');
exit();
}
$row=$esql->getone();
 $addsql="update #@__boss set password='".md5($password1)."' where id='$id'";
 $message= "操作员".$row['boss']."修改密码成功";
 $loginip=getip();
 $logindate=getdatetimemk(time());
 $username=GetCookie('VioomaUserID');
 $esql->ExecuteNoneQuery($addsql);
 WriteNote($message,$logindate,$loginip,$username);
 $esql->close();
 showmsg('成功修改操作员密码','main.php');
 exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link href="style/main.css" rel="stylesheet" type="text/css" />
<title><?php echo $cfg_softname;?>密码修改管理</title>
</head>
<body>
<?php
$esql=New Dedesql(false);
$queryboss="select * from #@__boss where boss='".GetCookie('VioomaUserID')."'";
$esql->SetQuery($queryboss);
$esql->Execute();
if($esql->GetTotalRow()==0){
ShowMsg('非法调用参数,请重试','-1');
exit();
}
$rs=$esql->GetOne($query);
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
      <td><strong>&nbsp;操作员密码修改</strong></td>
     </tr>
	 <form action="system_password.php?action=save" method="post">
     <tr>
      <td bgcolor="#FFFFFF">
       <table width="100%" cellspacing="0" cellpadding="0" border="0" id="table_border">
	    <tr>
		 <td id="row_style">&nbsp;系统登陆名称:</td>
		 <td>
		 &nbsp;<font color='red'><?php echo $rs['boss'];?>（在线试用版，已关闭密码修改权限）</font>
		 <input type="hidden" name="id" value="<?php echo $rs['id']; ?>"> 
		 </td>
	    </tr>
	    <tr>
		 <td id="row_style">&nbsp;登陆原始密码:</td>
		 <td>
		 &nbsp;<input type="password" name="password"> (不正确则不能修改)</td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;新密码:</td>
		 <td>
		 &nbsp;<input type="password" name="password1"> </td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;验证新密码:</td>
		 <td>
		 &nbsp;<input type="password" name="password2"> </td>
	    </tr>		
		<tr>
		 <td id="row_style">&nbsp;</td>
		 <td>&nbsp;<input type="button" name="" value=" 修改管理密码 "></td>
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
