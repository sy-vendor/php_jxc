<?php
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/config_rglobals.php");
require_once(dirname(__FILE__)."/include/checklogin.php");
if($action=='save'){
 if($reid==''){//添加大单位
 $addsql="insert into #@__dw(dwname,reid) values('$dwname','0')";
 $message="添加计量单位".$dwname."成功";
 }
 else{//添加子分类
 $addsql="insert into #@__dw(dwname,reid) values('$dwname','$reid')";
 $message="添加子计量单位".$dwname."成功";
 }
 $loginip=getip();
 $logindate=getdatetimemk(time());
 $username=Getcookie('VioomaUserID');
 $asql=New Dedesql(false);
 $asql->ExecuteNoneQuery($addsql);
 $asql->close();
 WriteNote($message,$logindate,$loginip,$username);
 showmsg('成功添加产品计量单位','system_dw.php');
 exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link href="style/main.css" rel="stylesheet" type="text/css" />
<title><?php echo $cfg_softname;?>单位管理</title>
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
      <td><strong>&nbsp;产品计量单位管理</strong>&nbsp;&nbsp;<a href="system_dw.php?action=new">添加基本计量单位</a> | <a href="system_dw.php">查看产品单位列表</a></td>
     </tr>
	 <form action="system_dw.php?action=save" method="post">
     <tr>
      <td bgcolor="#FFFFFF">
	  <?php if($action=='new'){ ?>
       <table width="100%" cellspacing="0" cellpadding="0" border="0" id="table_border">
	    <tr>
		 <td id="row_style">&nbsp;基本单位名称:</td>
		 <td>
		 &nbsp;<input type="text" name="dwname" size="20"><input type="hidden" name="reid" value="<?php echo $reid; ?>"></td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;</td>
		 <?php $submitstring=($reid=='')?' 添加单位 ':' 添加子单位 ';?>
		 <td>&nbsp;<input type="submit" name="submit" value="<?php echo $submitstring;?>"></td>
	    </tr>
		</form>
	   </table>
	   <?php
	    } 
		else
		{
       echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" id=\"table_border\">";
       $csql=New Dedesql(false);
	   $csql->SetQuery("select * from #@__dw where reid=0");
	   $csql->Execute();
	   $rowcount=$csql->GetTotalRow();
	   if($rowcount==0)
	   echo "<tr><td>&nbsp;系统里还没有任何计量单位,请先<a href=system_dw.php?action=new>添加基本计量单位</a>。</td></tr>";
	   else{
	   echo "<tr class='row_color_head'><td>ID</td><td>名称</td><td>操作</td></tr>";
	   while($row=$csql->GetArray()){
	   echo "<tr><td>ID号:".$row['id']."</td><td><img src=images/cate.gif align=absmiddle>&nbsp;".$row['dwname']."</td><td><a href=system_dw_edit.php?id=".$row['id'].">修改</a> | <a href=system_dw_del.php?id=".$row['id'].">删除</a></td></tr>";
	     $csql1=New Dedesql(false);
	     $csql1->SetQuery("select * from #@__dw where reid='".$row['id']."'");
		 $csql1->Execute();
		 while($row1=$csql1->GetArray()){
		 echo "<tr class='row_color_gray'><td>&nbsp;&nbsp;ID号:".$row1['id']."</td><td> ├ ".$row1['dwname']."</td><td><a href=system_dw_edit.php?id=".$row1['id'].">修改</a> | <a href=system_dw_del.php?id=".$row1['id'].">删除</a></td></tr>";
		 } $csql1->close();
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
