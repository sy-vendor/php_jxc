<?php
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/config_rglobals.php");
require_once(dirname(__FILE__)."/include/checklogin.php");
if($action=='save'){
if($b_name==''){
ShowMsg('请输入账户的名称','-1');
exit();
}
if($b_money=='' || !is_numeric($b_money) || $b_money<0){
ShowMsg('请确保输入了正确的初始金额','-1');
exit();
}
 $addsql="insert into #@__bank(bank_name,bank_money,bank_account,bank_default,bank_text) values('$b_name','$b_money','$b_account','$b_default','$b_text')";
 $message="添加银行账户".$b_name."成功";

 $loginip=getip();
 $logindate=getdatetimemk(time());
 $username=Getcookie('VioomaUserID');
 $asql=New Dedesql(false);
 $asql->ExecuteNoneQuery($addsql);
 $asql->close();
 WriteNote($message,$logindate,$loginip,$username);
 showmsg('成功添加了银行账户','bank.php');
 exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link href="style/main.css" rel="stylesheet" type="text/css" />
<title><?php echo $cfs_softname;?>账户管理</title>
</head>
<body>
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
      <td><strong>&nbsp;账户管理</strong>&nbsp;&nbsp;<a href="bank.php?action=new">添加新账户</a> | <a href="bank.php">查看账户列表</a></td>
     </tr>
	 <form action="bank.php?action=save" method="post">
     <tr>
      <td bgcolor="#FFFFFF">
	  <?php 
	  if($action=='new'){ 
	  ?>
       <table width="100%" cellspacing="0" cellpadding="0" border="0" id="table_border">
	    <tr>
		 <td id="row_style">&nbsp;银行名称:</td>
		 <td>
		 &nbsp;<input type="text" name="b_name" size="20" id="need"></td>
	    </tr>
	    <tr>
		 <td id="row_style">&nbsp;金额:</td>
		 <td>
		 &nbsp;<input type="text" name="b_money" size="10">元</td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;账号:</td>
		 <td>
		 &nbsp;<input type="text" name="b_account" size="20"></td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;备注:</td>
		 <td>
		 &nbsp;<textarea name="b_text" rows="2" cols="40"></textarea></td>
	    </tr>	
		<tr>
		 <td id="row_style">&nbsp;是否默认银行:</td>
		 <td>
		 &nbsp;<select name="b_default"><option value="1">是</option><option value="0" selected>否</option></select>&nbsp;只能保留一个默认银行</td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;</td>
		 <td>&nbsp;<input type="submit" name="submit" value=" 添加账户 "></td>
	    </tr></form>
	   </table>
	   <?php
	    } 
		else
		{
       echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" id=\"table_border\">";
       $csql=New Dedesql(false);
	   $csql->SetQuery("select * from #@__bank");
	   $csql->Execute();
	   $rowcount=$csql->GetTotalRow();
	   if($rowcount==0)
	   echo "<tr><td>&nbsp;还没添加银行账户,请先<a href=bank.php?action=new>添加账户</a>。</td></tr>";
	   else{
	   echo "<tr class='row_color_head'><td>ID</td><td>银行名称</td><td>银行账号</td><td>金额</td><td>默认</td><td>备注</td><td>修改</td></tr>";
	   while($row=$csql->GetArray()){
	   if ($row['bank_default']==1)
	    $default_yes="<img src=images/yes.png>";
		else{
		$default_yes="&nbsp;";
		$delstring=" | <a href=bank_del.php?id=".$row['id'].">删除</a>";
		}
	   echo "<tr><td>ID号:".$row['id']."</td><td>&nbsp;".$row['bank_name']."</td><td>&nbsp;".$row['bank_account']."</td><td>&nbsp;￥".$row['bank_money']."</td><td>&nbsp;".$default_yes."</td><td>".$row['bank_text']."</td><td><a href=bank_edit.php?id=".$row['id'].">修改</a>".$delstring."</td></tr>";
	   }
	   }
	   echo "</table>";
	  
	   $csql->close();
		}
	   ?>
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
