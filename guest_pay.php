<?php
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/config_rglobals.php");
require_once(dirname(__FILE__)."/include/checklogin.php");
check_grant('guest_pay.php',GetCookie('rank'));
if($action=='save'){
if($guestid=='' || $guestid==0){
ShowMsg('请选择客户后再试','-1');
exit();
}
 $loginip=getip();
 $logindate=getdatetimemk(time());
 $username=GetCookie('VioomaUserID');
 $pingyin=GetPinyin($g_name,1);
 $addsql="insert into #@__pay(guestid,money,mem,dtime) values('$guestid','$pay','$mem','$logindate')";
 $message="客户".$guestid."添加预付款".$pay."元成功";
 $asql=New Dedesql(false);
 $asql->ExecuteNoneQuery($addsql);
 $asql->ExecuteNoneQuery("update #@__guest set g_pay=g_pay+'$pay' where id='$guestid'");
 $asql->close();
 WriteNote($message,$logindate,$loginip,$username);
 showmsg('成功添加了客户预付款','guest_pay.php');
 exit();
}elseif($action=='del'){
 $loginip=getip();
 $logindate=getdatetimemk(time());
 $username=GetCookie('VioomaUserID');
 $addsql="delete from #@__pay where id='$id'";
 $message="客户".$id."预存记录删除成功";
 $asql=New Dedesql(false);
 $asql->ExecuteNoneQuery($addsql);
 $asql->ExecuteNoneQuery("update #@__guest set g_pay=g_pay-".$m." where id='$gid'");
 $asql->close();
 WriteNote($message,$logindate,$loginip,$username);
 showmsg('成功删除了客户预存款记录','guest_pay.php');
 exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link href="style/main.css" rel="stylesheet" type="text/css" />
<title><?php echo $cfs_softname;?>客户预付款操作</title>
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
      <td><strong>&nbsp;客户预付款管理</strong>&nbsp;&nbsp;<a href="guest_pay.php?action=new">增加客户预付款</a> | <a href="guest_pay.php">查看客户预付款</a> 
	  </td>
	  <td align="right">
	  客户搜索：<input type="text" value="<?php echo ($helpw=='')?'输入名称或首字拼音':$helpw?>" onclick="this.value='';" name="helpw">&nbsp;<input type="submit" value="搜索">&nbsp;&nbsp;
	  </td></form>
     </tr>
     <tr>
      <td bgcolor="#FFFFFF" colspan="2">
	  <?php if($action=='new'){ ?><form action="guest_pay.php?action=save" method="post" name="form1">
       <table width="100%" cellspacing="0" cellpadding="0" border="0" id="table_border">
	    <tr>
		 <td id="row_style">&nbsp;客户名称:</td>
		 <td>
		 &nbsp;<?php echo get__list('#@__guest','guestid',$guestid,'id','g_name');?> (请选择要预存货款的客户)</td>
	    </tr>
	    <tr>
		 <td id="row_style">&nbsp;预存金额:</td>
		 <td>
		 &nbsp;<input type="text" name="pay" size="15"> 元</td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;预存说明:</td>
		 <td>
		 &nbsp;<textarea rows="2" cols="50" name="mem"></textarea></td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;预存日期:</td>
		 <td>
		 &nbsp;<?php echo getdatetimemk(time()); ?></td>
	    </tr>	
		<tr>
		 <td id="row_style">&nbsp;</td>
		 <td>&nbsp;<input type="submit" name="submit" value=" 添加客户预存 "></td>
	    </tr>
	   </table></form>
	   <?php
	    } 
		else
		{
       echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" id=\"table_border\">";
       $csql=New Dedesql(false);
	   $query="select * from #@__pay order by id desc";	   
	   $csql->SetQuery($query);
	   $csql->Execute();
	   $rowcount=$csql->GetTotalRow();
	   if($rowcount==0)
	   echo "<tr><td>&nbsp;没有任何客户预存,请先<a href=guest_pay.php?action=new>添加客户预存</a>。</td></tr>";
	   else{
	   echo "<tr class='row_color_head'>
	   <td>ID</td>
	   <td>客户全称</td>
	   <td>预存金额</td>
	   <td>预存说明</td>
	   <td>时间</td>
	   <td>操作</td>
	   </tr>";
	   while($row=$csql->GetArray()){
	   echo "<tr>
	   <td><center>".$row['id']."</td>
	   <td><center>&nbsp;".get__id('#@__guest',$row['guestid'],'g_name','id')."</td>
	   <td><center>￥".number_format($row['money'],2,'.',',')."</td>
	   <td><center>&nbsp;".$row['mem']."</td>
	   <td><center>&nbsp;".$row['dtime']."</td>
	   <td><center><a href=guest_pay.php?action=del&id=".$row['id']."&gid=".$row['guestid']."&m=".$row['money'].">删</a></td>
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
