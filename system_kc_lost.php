<?php
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/config_rglobals.php");
require(dirname(__FILE__)."/include/page.php");
require_once(dirname(__FILE__)."/include/checklogin.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link href="style/main.css" rel="stylesheet" type="text/css" />
<title><?php echo $cfg_softname;?>系统库存缺货查询</title>
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
      <td>
	   <table width="100%" border="0" cellspacing="0">
	    <tr><form action="system_kc_lost.php?action=seek" name="form1" method="post">
		 <td>
	  <strong>&nbsp;系统库存缺货管理</strong>
	     </td>
		 <td align="right">
		 <?php if($action=='seek')
		 echo "只显示库存低于<input type=\"text\" name=\"stext\" size=\"5\" VALUE=\"".$stext."\">的记录<input type=\"submit\" value=\"开始检索\">";
		 else
		 echo "只显示库存低于<input type=\"text\" name=\"stext\" size=\"5\" VALUE=\"5\">的记录<input type=\"submit\" value=\"开始检索\">";
		 ?>
		 &nbsp;&nbsp;
		 </td>
		</tr></form>
	   </table>
	  </td>
     </tr>
	 <form method="post" name="sel">
     <tr>
      <td bgcolor="#FFFFFF">
       <?php
       echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" id=\"table_border\">";
   if($action=='seek'){
   if($stext=='' || !is_numeric($stext) || $stext<0)echo "<script>alert('请输入正确的数字');history.go(-1);</script>";
	$query="select * from #@__mainkc,#@__basic where  #@__mainkc.number<'$stext' and #@__mainkc.p_id=#@__basic.cp_number";
	   }
   else
    $query="select * from #@__mainkc,#@__basic where #@__mainkc.number<5  and #@__mainkc.p_id=#@__basic.cp_number";
$csql=New Dedesql(false);
$dlist = new DataList();
$dlist->pageSize = $cfg_record;
//设置GET参数表
if($action=='seek'){
$dlist->SetParameter("action",$action);
$dlist->SetParameter("stext",$stext);
}
$dlist->SetSource($query);
	   echo "<tr class='row_color_head'>
	   <td>货号</td>
	   <td>名称</td>
	   <td>规格</td>
	   <td>分类</td>
	   <td>单位</td>
	   <td>进价</td>
	   <td>供应商</td>
	   <td>所在仓库</td>
	   <td>库存</td>
	   <td>选择</td>
	   </tr>";
	   $mylist = $dlist->GetDataList();
       while($row = $mylist->GetArray('dm')){
	   echo "<tr onMouseMove=\"javascript:this.bgColor='#EBF1F6';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">\r\n
	   <td>".$row['p_id']."</td><td>&nbsp;".$row['cp_name']."</td>
	   <td>".$row['cp_gg']."</td>
	   <td>".get_name($row['cp_categories'],'categories').">".get_name($row['cp_categories_down'],'categories')."</td>
	   <td>".get_name($row['cp_dwname'],'dw')."</td>
	   <td>￥".$row['cp_jj']."</td>
	   <td><a href='' title='查看与该供应商的数据'>".get_name($row['p_id'],'gys')."</a></td>
	   <td>".get_name($row['l_id'],'lab')."</td>
	   <td><font color=red>".$row['number']."</font></td>
	   <td><a href='system_kc_edit.php?pid=".$row['cp_number']."&lid=".$row['l_id']."&n=".$row['number']."&id=".$row['kid']."'>修改</a>|<a href='system_kc_del.php?action=del&id=".$row['kid']."'>删除</a><input type='checkbox' name='sel_pro".$row['id']."' value='".$row['id']."'></td>\r\n</tr>";
	   }
	   echo "<tr><td colspan='8'>&nbsp;".$dlist->GetPageList($cfg_record)."</td></tr>";
	   echo "</table>";
	   $csql->close();
	   ?>
	  </td>
     </tr></form>
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
</body>
</html>
