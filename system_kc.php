<?php
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/config_rglobals.php");
require(dirname(__FILE__)."/include/page.php");
require_once(dirname(__FILE__)."/include/checklogin.php");
check_grant('system_kc.php',GetCookie('rank'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link href="style/main.css" rel="stylesheet" type="text/css" />
<title><?php echo $cfg_softname;?>系统库存</title>
<script language = "JavaScript">
var onecount; 
onecount = 0; 
subcat = new Array();
<?php
$count=0;
$rsql=New Dedesql(false);
$rsql->SetQuery("select * from #@__categories where reid!=0");
$rsql->Execute();
while($rs=$rsql->GetArray()){
?>
subcat[<?php echo $count;?>] = new Array("<?php echo $rs['categories'];?>","<?php echo $rs['reid'];?>","<?php echo $rs['id'];?>");
<?php 
    $count++;
}
$rsql->close();
?>
onecount=<?php echo $count?>; 
function getCity(locationid) 
{ 
    document.form1.cp_categories_down.length = 0; 

    var locationid=locationid; 

    var i; 
    document.form1.cp_categories_down.options[0] = new Option('==所选分类的子分类==',''); 
    for (i=0;i < onecount; i++) 
    { 
        if (subcat[i][1] == locationid) 
        { 
        document.form1.cp_categories_down.options[document.form1.cp_categories_down.length] = new Option(subcat[i][0], subcat[i][2]);
        } 
    } 

} 
function out_excel(){
cp=document.forms[0].cp_categories.value;
cp_down=document.forms[0].cp_categories_down.value;
s=document.forms[0].sort.value;
st=document.forms[0].stext.value;
window.open('excel_kc.php?cp_categories='+cp+'&cp_categories_down='+cp_down+'&sort='+s+'&stext='+st,'','');
}
function skiplab(lid){
	if(!lid==''){
        window.location.href='system_kc.php?lid='+lid;
		}
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
      <td>
	   <table width="100%" border="0" cellspacing="0">
	   <form action="system_kc.php?action=seek" name="form1" method="post">
	    <tr height="22" bgcolor="#FFFFFF">
		 <td style="text-align:right;font-weight:bold;" colspan="2">
		 <?php
		 $ksql=New Dedesql(false);
		 $query="select * from #@__mainkc";
		 $ksql->setquery($query);
		 $ksql->execute();
		 $allrow=$ksql->gettotalrow();
		 while($row=$ksql->getarray()){
		 $allnumber+=$row['number'];
		 $thisjj=$ksql->getone("select * from #@__basic where cp_number='".$row['p_id']."'");
		 $themoney+=$thisjj['cp_jj']*$row['number'];
		 }
		 $ksql->close();
		 ?>
		 &nbsp;仓库统计:计样 <font color=red><?php echo $allrow;?></font> 个共 <font color=red><?php echo $allnumber;?></font> 件,共计 <font color=red>￥<?php echo number_format($themoney,2,'.',',')?></font>&nbsp;&nbsp;&nbsp;&nbsp;
		 </td>
		</tr>
	    <tr height="30">
		 <td>
	  <strong>&nbsp;库存管理</strong>
	     </td>
		 <td align="right">
		 仓库:
<?php 
$gsql=New Dedesql(false);
$query="select * from #@__lab";
$gsql->setquery($query);
$gsql->execute();
$rowcount=$gsql->gettotalrow();
if($rowcount>0){
 echo "<select name='labid' onchange='skiplab(this.value)'>\r\n<option value=''>所有仓库</option>";
 while ($row=$gsql->getarray()){
 	if($lid=='')
 	 if($labid==$row['id'])
 		echo "<option value='".$row['id']."' selected>".$row['l_name']."</option>";
 		else 
 		echo "<option value='".$row['id']."'>".$row['l_name']."</option>";
 	elseif($lid==$row['id'])
   echo "<option value='".$row['id']."' selected>".$row['l_name']."</option>";
 	else
   echo "<option value='".$row['id']."'>".$row['l_name']."</option>";
  }
   echo "</select>";
   }
   else
   {
   echo "<select name='labid'>\r\n<option value=''>所有仓库</option></select>";
   }
  $gsql->close();
		 ?>
		 分类:
		 <?php
		 if ($action=='seek')
		 getcategories($cp_categories,$cp_categories_down);
		 else
         getcategories(0,'');
	     ?>
		 <select name="sort">
		 <option value="1">按货号查询</option>
		 <option value="2">按条码查询</option>
		 <option value="3" selected>按名称查询</option>
		 <option value="4">按助记词查询</option>
		 </select>
		 <input type="text" name="stext" size="15" VALUE="<?PHP ECHO $stext ?>"><input type="submit" value="开始检索">&nbsp;<input type="button" onclick="out_excel()" value="导出excel" />
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
	   if($cp_categories_down=='')echo "<script>alert('请选择小分类');history.go(-1);</script>";
	   if($labid=='')$labstring="";
	   else
	    $labstring=" and #@__mainkc.l_id='$labid'";
	   switch($sort){
	    case "1"://按货号
		$query="select * from #@__mainkc,#@__basic where  #@__basic.cp_number='$stext' and #@__basic.cp_categories='$cp_categories' and #@__basic.cp_categories_down='$cp_categories_down' and #@__mainkc.p_id=#@__basic.cp_number".$labstring;
		break;
		case "2"://按条码
		$query="select * from #@__mainkc,#@__basic where  #@__basic.cp_tm='$stext' and #@__basic.cp_categories='$cp_categories' and #@__basic.cp_categories_down='$cp_categories_down' and #@__mainkc.p_id=#@__basic.cp_number".$labstring;
		break;
		case "3"://按名称
		$query="select * from #@__mainkc,#@__basic where  #@__basic.cp_name LIKE '%".$stext."%' and #@__basic.cp_categories='$cp_categories' and #@__basic.cp_categories_down='$cp_categories_down' and #@__mainkc.p_id=#@__basic.cp_number".$labstring;
		break;
		case "4"://按肋记词
		$query="select * from #@__mainkc,#@__basic where  #@__basic.cp_helpword LIKE '%".$stext."%' and #@__basic.cp_categories='$cp_categories' and #@__basic.cp_categories_down='$cp_categories_down' and #@__mainkc.p_id=#@__basic.cp_number".$labstring;
		break;
		}
	   }
	   elseif($lid=='')
       $query="select * from #@__mainkc,#@__basic where #@__mainkc.p_id=#@__basic.cp_number".$labstring;
       else 
       $query="select * from #@__mainkc,#@__basic where #@__mainkc.p_id=#@__basic.cp_number and #@__mainkc.l_id='$lid'";
	   //echo $query;
	   //exit();
$csql=New Dedesql(false);
$dlist = new DataList();
$dlist->pageSize = $cfg_record;
//设置GET参数表
if($action=='seek'){
$dlist->SetParameter("action",$action);
$dlist->SetParameter("cp_categories",$cp_categories);
$dlist->SetParameter("cp_categories_down",$cp_categories_down);
$dlist->SetParameter("sort",$sort);
$dlist->SetParameter("stext",$stext);
$dlist->SetParameter("labid",$labid);
}
$dlist->SetParameter("lid",$lid);
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
	   <td><center>".$row['p_id']."</td>
	   <td><center>&nbsp;".$row['cp_name']."</td>
	   <td><center>".$row['cp_gg']."</td>
	   <td><center>".get_name($row['cp_categories'],'categories').">".get_name($row['cp_categories_down'],'categories')."</td>
	   <td><center>".get_name($row['cp_dwname'],'dw')."</td>
	   <td><center>￥".$row['cp_jj']."</td>
	   <td><center><a href='' title='查看与该供应商的数据'>".get_name($row['p_id'],'gys')."</a></td>
	   <td><center>".get_name($row['l_id'],'lab')."</td>
	   <td><center><font color=red>".$row['number']."</font></td>
	   <td><center><a href='system_kc_edit.php?id=".$row['kid']."&lid=".$row['l_id']."&n=".$row['number']."&pid=".$row['cp_number']."'>修改</a>|<a href='system_kc_del.php?action=del&id=".$row['kid']."'>删除</a><input type='checkbox' name='sel_pro".$row['id']."' value='".$row['id']."'></td>\r\n</tr>";
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
