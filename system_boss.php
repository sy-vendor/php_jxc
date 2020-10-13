<?php
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/config_rglobals.php");
require_once(dirname(__FILE__)."/include/checklogin.php");
if($action=='save'){
if($b_name==''){
ShowMsg('请输入操作员的登陆名','-1');
exit();
}
 if(checkbossexist($b_name)){
 $password=md5($password);
 $addsql="insert into #@__boss(boss,password,logindate,loginip,errnumber,rank) values('$b_name','$password','0000-00-00 00:00:00','','0','$s_utype')";
 $message="添加操作员".$b_name."成功";

 $loginip=getip();
 $logindate=getdatetimemk(time());
 $username=GetCookie('VioomaUserID');
 $asql=New Dedesql(false);
 $asql->ExecuteNoneQuery($addsql);
 $asql->close();
 WriteNote($message,$logindate,$loginip,$username);
 showmsg('成功添加了操作员','system_boss.php');
 exit();
 }
 else
 showmsg('你添加的登陆名已存在','system_boss.php?action=new');
 exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link href="style/main.css" rel="stylesheet" type="text/css" />
<title><?php echo $cfg_softname;?>操作员管理</title>
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
      <td><strong>&nbsp;操作员管理</strong>&nbsp;&nbsp;<a href="system_worker.php?action=new">添加新的操作员</a> | <a href="system_boss.php">查看操作员列表</a>&nbsp;|&nbsp;<a href="system_grant.php">权限分配</a></td>
     </tr>
     <tr>
      <td bgcolor="#FFFFFF">
	  <?php if($action=='new'){ ?>
       <table width="100%" cellspacing="0" cellpadding="0" border="0" id="table_border">
	   <form action="system_boss.php?action=save" method="post">
	    <tr>
		 <td id="row_style">&nbsp;操作员登陆名:</td>
		 <td>
		 &nbsp;<input type="text" name="b_name" size="15" id="need"> *系统登陆的用户名</td>
	    </tr>
	    <tr>
		 <td id="row_style">&nbsp;登陆密码:</td>
		 <td>
		 &nbsp;<input type="password" name="password"> *系统登陆的密码</td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;操作员类型:</td>
		 <td>&nbsp;<?php getusertype('',0);?></td>
	    </tr>
		<tr>
		 <td></td>
		 <td><input type="submit" value=" 添加系统操作员 "></td>
		</tr>
		</form>
	   </table>
	   <?php
	    } 
		else
		{
       echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" id=\"table_border\">";
       $csql=New Dedesql(false);
	   if(GetCookie('rank')==1)
	   $csql->SetQuery("select * from #@__boss");
	   else
	   $csql->SetQuery("select * from #@__boss where boss='".GetCookie('VioomaUserID')."'");
	   $csql->Execute();
	   $rowcount=$csql->GetTotalRow();
	   if($rowcount==0)
	   echo "<tr><td>&nbsp;系统里还没有任何操作员,请先<a href=system_boss.php?action=new>添加操作员</a>。</td></tr>";
	   else{
	   echo "<tr class='row_color_head'>
	   <td>ID</td>
	   <td>登陆名称</td>
	   <td>最后登陆时间</td>
	   <td>登陆IP</td>
	   <td>用户类型</td>
	   <td>操作</td>
	   </tr>";
	   while($row=$csql->GetArray()){
	   if($row['boss']!='admin')
	   echo "<tr>
	   <td><center>ID号:".$row['id']."</td>
	   <td><center>".$row['boss']."</td>
	   <td><center>".$row['logindate']."</td>
	   <td><center>".$row['loginip']."</td>
	   <td><center>".getusertype($row['rank'],0)."</td>
	   <td><center><a href=system_boss_edit.php?id=".$row['id'].">修改</a> | <a href=system_boss_del.php?id=".$row['id'].">删除</a></td></tr>";
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
