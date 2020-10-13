<?php
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/config_rglobals.php");
require_once(dirname(__FILE__)."/include/checklogin.php");
check_grant('system_guest.php',GetCookie('rank'));
if($action=='save'){
if($g_name==''){
ShowMsg('请输入客户的姓名','-1');
exit();
}
 $loginip=getip();
 $logindate=getdatetimemk(time());
 $username=GetCookie('VioomaUserID');
 $pingyin=GetPinyin($g_name,1);
 $addsql="insert into #@__guest(g_name,g_man,g_address,g_phone,g_qq,g_bank,g_card,g_group,g_people,g_dtime,g_helpword) values('$g_name','$g_man','$g_address','$g_phone','$g_qq','$g_bank','$g_card','$g_group','$g_people','$logindate','$pingyin')";
 $message="添加客户".$g_name."成功";
 $asql=New Dedesql(false);
 $asql->ExecuteNoneQuery($addsql);
 $asql->close();
 WriteNote($message,$logindate,$loginip,$username);
 showmsg('成功添加了客户','system_guest.php');
 exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link href="style/main.css" rel="stylesheet" type="text/css" />
<title><?php echo $cfs_softname;?>客户管理</title>
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
     <tr><form action="system_guest.php" method="post">
      <td><strong>&nbsp;客户管理</strong>&nbsp;&nbsp;<a href="system_guest.php?action=new">添加客户</a> | <a href="system_guest.php">查看客户</a> 
	  </td>
	  <td align="right">
	  客户搜索：<input type="text" value="<?php echo ($helpw=='')?'输入名称或首字拼音':$helpw?>" onclick="this.value='';" name="helpw">&nbsp;<input type="submit" value="搜索">&nbsp;&nbsp;
	  </td></form>
     </tr>
     <tr>
      <td bgcolor="#FFFFFF" colspan="2">
	  <?php if($action=='new'){ ?><form action="system_guest.php?action=save" method="post" name="form1">
       <table width="100%" cellspacing="0" cellpadding="0" border="0" id="table_border">
	    <tr>
		 <td id="row_style">&nbsp;客户全称:</td>
		 <td>
		 &nbsp;<input type="text" name="g_name" size="20" id="need"></td>
	    </tr>
	    <tr>
		 <td id="row_style">&nbsp;联系人:</td>
		 <td>
		 &nbsp;<input type="text" name="g_man" size="15"></td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;联系地址:</td>
		 <td>
		 &nbsp;<input type="text" name="g_address" size="25"></td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;联系电话:</td>
		 <td>
		 &nbsp;<input type="text" name="g_phone" size="15"></td>
	    </tr>	
		<tr>
		 <td id="row_style">&nbsp;即时联系(QQ/MSN):</td>
		 <td>
		 &nbsp;<input type="text" name="g_qq" size="15"></td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;开户行:</td>
		 <td>
		 &nbsp;<input type="text" name="g_bank" size="20"> (格式:招行XX省XX支行)</td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;账号:</td>
		 <td>
		 &nbsp;<input type="text" name="g_card" size="20"></td>
	    </tr>	
		<tr>
		 <td id="row_style">&nbsp;所在分组:</td>
		 <td>
		 <?php
		 getgroup();
		 ?>
		 </td>
	    </tr>		
		<tr>
		 <td id="row_style">&nbsp;操作员:</td>
		 <td>
		 &nbsp;<input type="text" name="g_people" size="10" value="<?php echo Getcookie('VioomaUserID')?>" readonly>
		 </td>
	    </tr>	
		<tr>
		 <td id="row_style">&nbsp;操作时间:</td>
		 <td>
		 &nbsp;<?php echo getDatetimeMk(time()); ?></td>
	    </tr>									
		<tr>
		 <td id="row_style">&nbsp;</td>
		 <td>&nbsp;<input type="submit" name="submit" value=" 添加客户 "></td>
	    </tr>
	   </table></form>
	   <?php
	    } 
		else
		{
       echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" id=\"table_border\">";
       $csql=New Dedesql(false);
	   $query="select * from #@__guest where g_name LIKE '%".$helpw."%' or g_helpword LIKE '%".$helpw."%'";	   
	   $csql->SetQuery($query);
	   $csql->Execute();
	   $rowcount=$csql->GetTotalRow();
	   if($rowcount==0)
	   echo "<tr><td>&nbsp;没有任何客户,请先<a href=system_guest.php?action=new>添加客户</a>。</td></tr>";
	   else{
	   echo "<tr class='row_color_head'>
	   <td>ID</td>
	   <td>客户全称</td>
	   <td>联系人</td>
	   <td>联系地址</td>
	   <td>联系电话</td>
	   <td>QQ/MSN</td>
	   <td>开户行</td>
	   <td>账号</td>
	   <td>分组</td>
	   <td>预存款</td>
	   <td>操作</td>
	   </tr>";
	   while($row=$csql->GetArray()){
	   echo "<tr>
	   <td><center>".$row['id']."</td>
	   <td><center>&nbsp;".$row['g_name']."</td>
	   <td><center>".$row['g_man']."</td>
	   <td><center>&nbsp;".$row['g_address']."</td>
	   <td><center>&nbsp;".$row['g_phone']."</td>
	   <td><center>".$row['g_qq']."</td>
	   <td><center>&nbsp;".$row['g_bank']."</td>
	   <td><center>&nbsp;".$row['g_card']."</td>
	   <td><center>&nbsp;".getgroup($row['g_group'],'group')."</td>
	   <td><center>￥".number_format($row['g_pay'],2,'.',',')."</td>
	   <td><center><a href=guest_edit.php?id=".$row['id'].">改</a> | <a href=guest_del.php?id=".$row['id'].">删</a></td>
	   </tr>";
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
