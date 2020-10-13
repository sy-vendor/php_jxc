<?php
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/config_rglobals.php");
require_once(dirname(__FILE__)."/include/checklogin.php");
if($action=='save'){
if($l_name==''){
ShowMsg('请输入仓库的名称','-1');
exit();
}
 $addsql="insert into #@__lab(l_name,l_city,l_mang,l_default) values('$l_name','$l_city','$l_mang','$l_default')";
 $message="添加仓库".$s_name."成功";

 $loginip=getip();
 $logindate=getdatetimemk(time());
 $username=Getcookie('VioomaUserID');
 $asql=New Dedesql(false);
 $asql->ExecuteNoneQuery($addsql);
 $asql->close();
 WriteNote($message,$logindate,$loginip,$username);
 showmsg('成功添加了仓库','system_lab.php');
 exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link href="style/main.css" rel="stylesheet" type="text/css" />
<title><?php echo $cfs_softname;?>仓库管理</title>
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
      <td><strong>&nbsp;仓库管理</strong>&nbsp;&nbsp;<a href="system_lab.php?action=new">添加新仓库</a> | <a href="system_lab.php">查看仓库</a></td>
     </tr>
	 <form action="system_lab.php?action=save" method="post">
     <tr>
      <td bgcolor="#FFFFFF">
	  <?php if($action=='new'){ ?>
       <table width="100%" cellspacing="0" cellpadding="0" border="0" id="table_border">
	    <tr>
		 <td id="row_style">&nbsp;仓库名称:</td>
		 <td>
		 &nbsp;<input type="text" name="l_name" size="20" id="need"></td>
	    </tr>
	    <tr>
		 <td id="row_style">&nbsp;所在城市:</td>
		 <td>
		 &nbsp;<input type="text" name="l_city" size="20"></td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;负责人:</td>
		 <td>
		 &nbsp;<input type="text" name="l_mang" size="15"></td>
	    </tr>	
		<tr>
		 <td id="row_style">&nbsp;是否默认仓库:</td>
		 <td>
		 &nbsp;<select name="l_default"><option value="1">是</option><option value="0" selected>否</option></select>&nbsp;只能保留一个默认仓库</td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;</td>
		 <td>&nbsp;<input type="submit" name="submit" value=" 添加仓库 "></td>
	    </tr>
		</form>
	   </table>
	   <?php
	    } 
		else
		{
       echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" id=\"table_border\">";
       $csql=New Dedesql(false);
	   $csql->SetQuery("select * from #@__lab");
	   $csql->Execute();
	   $rowcount=$csql->GetTotalRow();
	   if($rowcount==0)
	   echo "<tr><td>&nbsp;还没添加仓库,请先<a href=system_lab.php?action=new>添加仓库</a>。</td></tr>";
	   else{
	   echo "<tr class='row_color_head'><td>ID</td><td>仓库名称</td><td>所在城市</td><td>负责人</td><td>默认</td><td>修改</td></tr>";
	   while($row=$csql->GetArray()){
	   if ($row['l_default']==1)
	    $default_yes="<img src=images/yes.png>";
		else
		$default_yes="&nbsp;";
	   echo "<tr><td>ID号:".$row['id']."</td><td>&nbsp;".$row['l_name']."</td><td>&nbsp;".$row['l_city']."</td><td>&nbsp;".$row['l_mang']."</td><td>&nbsp;".$default_yes."</td><td><a href=system_lab_edit.php?id=".$row['id'].">修改</a> | <a href=system_lab_del.php?id=".$row['id'].">删除</a></td></tr>";
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
