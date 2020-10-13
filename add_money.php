<?php
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/config_rglobals.php");
require_once(dirname(__FILE__)."/include/checklogin.php");
if($action=='save'){
if($atext==''){
ShowMsg('请输入财务进出原因','-1');
exit();
}
if($amoney=='' || !is_numeric($amoney) || $amoney<0){
ShowMsg('请确保输入了正确的金额','-1');
exit();
}
if($atype='收入')
$money=$amoney;
else
$money=-$amoney;
 $loginip=getip();
 $logindate=getdatetimemk(time());
 $username=Getcookie('VioomaUserID');
 $updatesql="update #@__bank set bank_money=bank_money+'$amoney' where id='$abank'";
 $addsql="insert into #@__accounts(atype,amoney,abank,dtime,apeople,atext) values('$atype','$money','$abank','$logindate','$username','$atext')";
 $message="手动添加".$atype."账务成功";
 $asql=New Dedesql(false);
 $asql->ExecuteNoneQuery($updatesql);
 $asql->ExecuteNoneQuery($addsql);
 $asql->close();
 WriteNote($message,$logindate,$loginip,$username);
 showmsg('成功添加了账务','system_money.php');
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
      <td><strong>&nbsp;账务管理</strong>&nbsp;&nbsp;<a href="system_money.php">查看明细账</a></td>
     </tr>
     <tr>
      <td bgcolor="#FFFFFF"><form action="add_money.php?action=save" method="post">
       <table width="100%" cellspacing="0" cellpadding="0" border="0" id="table_border">
	    <tr>
		 <td id="row_style">&nbsp;科目:</td>
		 <td>
		 &nbsp;<select name="atype"><option value="收入">收入</option><option value="支出">支出</option></select>
		 </td>
	    </tr>
	    <tr>
		 <td id="row_style">&nbsp;银行:</td>
		 <td>
		 <?php
		 $bank=new dedesql(false);
		 $bank->setquery("select * from #@__bank");
		 $bank->execute();
		 $r=$bank->gettotalrow();
		 if($r==0)
		 echo "没有银行供选择,请先<a href='bank.php?action=new'>添加</a>";
		 else{
		 echo "<select name='abank'>";
		 while($row=$bank->getArray()){
		 if($row['bank_default']==1)
		 echo "<option selected value='".$row['id']."'>".$row['bank_name']."</option>";
		 else
		 echo "<option value='".$row['id']."'>".$row['bank_name']."</option>";
		 }
		 echo "</select>";
		 }
		 $bank->close();
		 ?>
		 &nbsp;
		 </td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;金额:</td>
		 <td>
		 &nbsp;<input type="text" name="amoney" size="10">&nbsp;元</td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;备注:</td>
		 <td>
		 &nbsp;<textarea name="atext" rows="2" cols="40"></textarea></td>
	    </tr>	
		<tr>
		 <td id="row_style">&nbsp;</td>
		 <td>&nbsp;<input type="submit" name="submit" value=" 添加账务 "></td>
	    </tr>
	   </table></form>
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
