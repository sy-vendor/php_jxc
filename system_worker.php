<?php
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/config_rglobals.php");
require_once(dirname(__FILE__)."/include/checklogin.php");
if($action=='save'){
if($s_name==''){
ShowMsg('请输入员工的姓名','-1');
exit();
}
 $addsql="insert into #@__staff(s_name,s_address,s_phone,s_part,s_way,s_money,s_utype,s_duty) values('$s_name','$s_address','$s_phone','$s_part','$s_way','$s_money','$s_utype','$s_utype')";
 $message="添加员工".$s_name."成功";
$password1=md5($password);
 $addsql2="insert into #@__boss(boss,password,logindate,loginip,errnumber,rank,`key`,key1,code) values('$s_name','$password1','0000-00-00 00:00:00','','0','$s_utype','0','0','0')";
 $loginip=getip();
 $logindate=getdatetimemk(time());
 $username=GetCookie('VioomaUserID');
 $asql=New Dedesql(false);
 $rs=$asql->ExecuteNoneQuery($addsql);
 if(!$rs){
  showmsg('发生错误:'.$asql->getError(),'-1');
  exit();
 }
 $rs1=$asql->ExecuteNoneQuery($addsql2);
 if(!$rs1){
  showmsg('发生错误:'.$asql->getError(),'-1');
  exit();
 }
 WriteNote($message,$logindate,$loginip,$username);
 showmsg('成功添加了公司员工','system_worker.php');
 exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link href="style/main.css" rel="stylesheet" type="text/css" />
<title><?php echo $cfs_softname;?>员工管理</title>
<script language="javascript">
function cway(value){
if(value==0)
document.forms[0].s_e.value="%";
else
document.forms[0].s_e.value="元/件";
}
function getinfo(){
window.open('part_list.php?form=form1&field=s_part','selected','directorys=no,toolbar=no,status=no,menubar=no,resizable=no,width=500,height=500,top=100,left=320');
}
</script>
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
      <td><strong>&nbsp;公司员工管理</strong>&nbsp;&nbsp;<a href="system_worker.php?action=new">添加公司员工</a> | <a href="system_worker.php">查看公司员工</a></td>
     </tr>
	 <form action="system_worker.php?action=save" method="post" name="form1">
     <tr>
      <td bgcolor="#FFFFFF">
	  <?php if($action=='new'){ ?>
       <table width="100%" cellspacing="0" cellpadding="0" border="0" id="table_border">
	    <tr>
		 <td id="row_style">&nbsp;员工姓名/登陆名:</td>
		 <td>
		 &nbsp;<input type="text" name="s_name" size="10" id="need"></td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;登陆密码：</td>
		 <td>&nbsp;<input type="password" name="password" size="12"></td>
		</tr>
	    <tr>
		 <td id="row_style">&nbsp;联系地址:</td>
		 <td>
		 &nbsp;<input type="text" name="s_address" size="30"></td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;联系电话:</td>
		 <td>
		 &nbsp;<input type="text" name="s_phone" size="15"></td>
	    </tr>	
		<tr>
		 <td id="row_style">&nbsp;所在部门:</td>
		 <td>
		 &nbsp;<input type="text" name="s_part" size="20">&nbsp;<input type="button" value="选择部门" onclick="getinfo()"></td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;职务/操作员类型:</td>
		 <td>
		 &nbsp;<?php getusertype('',0);?></td>
	    </tr>	
		<tr>
		 <td id="row_style">&nbsp;提成方式:</td>
		 <td>
		 <?php
		 if ($cfg_way=='1'){
		 ?>
		 &nbsp;<select name="s_way" onchange="cway(this.value)"><option value="0">销售总额的百分比</option><option value="1">固定提成(按件)</select>
		 <?php
		 }
		 else
		 echo "&nbsp;员工提成功能被管理员禁用!";
		 ?>
		 </td>
	    </tr>		
		<tr>
		 <td id="row_style">&nbsp;提成额(为空表示添加的此员工不提成):</td>
		 <td>
		 <?php
		 if ($cfg_way=='1'){
		 ?>
		 &nbsp;<input type="text" name="s_money" size="5" value="0">
		 <input type="text" name="s_e" size="5" style="border:0px;background:transparent;" value="%" readonly>
		 <?php
		 }
		 else
		 echo "&nbsp;";
		 ?>
		 </td>
	    </tr>	
		<tr>
		 <td id="row_style">&nbsp;</td>
		 <td>&nbsp;<input type="submit" name="submit" value=" 添加员工 "></td>
	    </tr>
		</form>
	   </table>
	   <?php
	    } 
		else
		{
       echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" id=\"table_border\">";
       $csql=New Dedesql(false);
	   $csql->SetQuery("select * from #@__staff");
	   $csql->Execute();
	   $rowcount=$csql->GetTotalRow();
	   if($rowcount==0)
	   echo "<tr><td>&nbsp;公司里还没有任何员工,请先<a href=system_worker.php?action=new>添加员工</a>。</td></tr>";
	   else{
	   echo "<tr class='row_color_head'>
	   <td>ID</td>
	   <td>姓名</td>
	   <td>联系地址</td>
	   <td>联系电话</td>
	   <td>部门</td>
	   <td>职务</td>
	   <td>操作</td>
	   </tr>";
	   while($row=$csql->GetArray()){
	   echo "<tr>
	   <td><center>ID号:".$row['id']."</td>
	   <td><center>&nbsp;".$row['s_name']."</td>
	   <td><center>&nbsp;".$row['s_address']."</td>
	   <td><center>&nbsp;".$row['s_phone']."</td>
	   <td><center>&nbsp;".$row['s_part']."</td>
	   <td><center>&nbsp;".getusertype($row['s_duty'],0)."</td>
	   <td><center><a href=system_worker_edit.php?id=".$row['id'].">修改</a> | <a href=system_worker_del.php?id=".$row['id'].">删除</a></td>
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
