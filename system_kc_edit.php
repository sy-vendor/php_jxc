<?php
require(dirname(__FILE__)."/include/config_rglobals.php");
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/page.php");
require_once(dirname(__FILE__)."/include/checklogin.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link href="style/main.css" rel="stylesheet" type="text/css" />
<title>产品入库管理</title>
<style type="text/css">
.rtext {background:transparent;border:0px;color:red;font-weight:bold;font-family:Verdana, Arial, Helvetica, sans-serif;}
</style>
</head>
<?php
if ($action=='save'){//保存入库单及记录
 if($labid=='' || $kc_number=='' || $id==''){
 showmsg('执行了带有非法参数的文件','-1');
 exit();
 }
$bsql=New Dedesql(false);
$query="select * from #@__mainkc where kid='$id'";
$bsql->SetQuery($query);
$bsql->Execute();
$rowcount=$bsql->GetTotalRow();
if ($rowcount==0){
 ShowMsg('非法参数或没有此产品信息!','-1');
 exit();
}
else{
 $bsql->executenonequery("update #@__mainkc set number='$kc_number',l_id='$labid' where kid='".$id."'");
 $loginip=getip();
 $logindate=getdatetimemk(time());
 $username=Getcookie('VioomaUserID');
 WriteNote('修改产品'.get_name($pid,'name').'资料成功',$logindate,$loginip,$username);
 ShowMsg('产品信息已成功修改','system_kc.php');
$bsql->close();
exit();
    }
}
 else{
 if($id=='' || $lid==''){
 echo "<script language='javascript'>alert('非法参数');history.go(-1);</script>";
 exit();}
?>
<body onload="form1.seek_text.focus()">
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
      <td><strong><strong>&nbsp;库存管理-修改库存资料</strong>&nbsp;&nbsp;- <a href="system_kc.php">查看库存</a> - <a href="system_basic_cp.php?action=seek">产品基本信息表</a></td>
     </tr>
     <tr>
      <td bgcolor="#FFFFFF">
       <table width="100%" border="0" cellspacing="0" cellpadding="0" id="table_border">
	   <form action="system_kc_edit.php?action=save" method="post" name="form1">
    <tr height="30">
    <td class="cellcolor">产品货号:</td>
    <td><input type="text" name="pid" value="<?php echo $pid; ?>" readonly size="15"><input type="hidden" name="id" value="<?php echo $id; ?>" />
	</td>
  </tr>
  <tr>
    <td class="cellcolor" width="30%">产品名称:<br></td>
    <td>&nbsp;<input type="text" name="seek_text" value="<?php echo get_name($pid,'name')?>" readonly>&nbsp;(修改名称请到<a href="system_basic_cp.php?action=seek">产品基本信息</a>)
	<input type="hidden" name="seek_number" value=""/>
	</td>
  </tr> 
  <tr>
    <td class="cellcolor" width="30%">所在仓库:<br></td>
    <td>&nbsp;<?php getlab($lid,'lab') ?>
	</td>
  </tr> 
  <tr>
    <td class="cellcolor" width="30%">现有库存数量:<br></td>
    <td>&nbsp;<input type="text" name="kc_number" size="5" value="<?php echo $n; ?>">&nbsp;<?php echo get_name(get_name($pid,'dwname'),'dw')?>
	</td>
  </tr>   
  <tr id="product_date" style="display:block;">
   <td colspan="2">
   &nbsp;其它基本信息: <font color=red><?php echo "规格:".get_name($pid,'gg')." 分类:".get_name(get_name($pid,'bcate'),'categories')."->".get_name(get_name($pid,'scate'),'categories')." 供货商:".get_name($pid,'gys');?></font>
   </td>
  </tr> 
  <tr>
    <td class="cellcolor">&nbsp;</td>
    <td>&nbsp;<input type="submit" value="保存<?php echo get_name($pid,'name')?>的资料"></td>
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
}
copyright();
?>
</body>
</html>
