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
<script language="javascript" src="include/calendar.js"></script>
<title>退货报表管理</title>
<script language=javascript>    
function preview(oper)
{
if (oper < 10){
bdhtml=window.document.body.innerHTML;//获取当前页的html代码
sprnstr="<!--startprint"+oper+"-->";//设置打印开始区域
eprnstr="<!--endprint"+oper+"-->";//设置打印结束区域
prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)+18); //从开始代码向后取html

prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));//从结束代码向前取html
window.document.body.innerHTML=prnhtml;
window.print();
window.document.body.innerHTML=bdhtml;
} 
else {
window.print();
}
}
function out_excel(sign){
edate=document.forms[0].sday.value;
window.open('excel_s_back.php?type='+sign+'&sday='+edate,'','');
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
      <td><strong>&nbsp;客户退货报表管理</strong>&nbsp;&nbsp;<a href="report_s_back.php?type=day">日报表</a> | <a href="report_s_back.php?type=week">周报表</a> | <a href="report_s_back.php?type=month">月报表</a> | <a href="report_s_back.php?type=year">年报表</a>&nbsp;&nbsp;<input type="button" onClick="preview(1);" value=" 打印退货报表 "></td>
     </tr>
     <tr>
      <td bgcolor="#FFFFFF">
     <?php
	  if($type=='')$type='day';
	  switch($type){
	   case 'day':
	  ?>
       <table width="100%" cellspacing="0" cellpadding="0" border="0" id="table_border"><form action="report_s_back.php?action=save&type=day" name="form1" method="post">
	    <tr height="40">
		 <td id="row_style" colspan="10">请选择日期&nbsp;&nbsp;<input type="text" name="sday" onclick="setday(this)" value="<?php echo ($action=='save')?$sday:GetDateMk(time());?>">(单击输入框选择报表日期)&nbsp;&nbsp;<input type="submit" value=" 显示日报表 ">&nbsp;<input type="button" value=" 导出Excel " onclick="out_excel('day')"></td>
	    </tr>
	   <?php
	   break;
	   case 'week':
	   ?>
       <table width="100%" cellspacing="0" cellpadding="0" border="0" id="table_border"><form action="report_s_back.php?action=save&type=week" name="form1" method="post">
	    <tr height="40">
		 <td id="row_style" colspan="10">请选择周&nbsp;&nbsp;
		 <?php
		 echo "<select name='sday'>";
		 for($i=1;$i<=52;$i++){
		 if($action=='save' && $i==$sday)
		 echo "<option value='$i' selected>第{$i}周</option>";
		 else
		 echo "<option value='$i'>第{$i}周</option>";
		 }
		 echo "</select>";
		 ?>
		 &nbsp;&nbsp;<input type="submit" value=" 显示周报表 ">&nbsp;<input type="button" value=" 导出Excel " onclick="out_excel('week')"></td>
	    </tr>
	   <?php
	   break;
	   case 'month':
	   ?>
       <table width="100%" cellspacing="0" cellpadding="0" border="0" id="table_border"><form action="report_s_back.php?action=save&type=month" name="form1" method="post">
	    <tr height="40">
		 <td id="row_style" colspan="10">请选择日期&nbsp;&nbsp;<input type="text" name="sday" onclick="setday(this)" value="<?php echo ($action=='save')?$sday:GetDateMk(time());?>">(单击输入框选择报表日期)&nbsp;&nbsp;<input type="submit" value=" 显示月报表 ">&nbsp;<input type="button" value=" 导出Excel " onclick="out_excel('month')"></td>
	    </tr>
	   <?php
	   break;
	   case 'year':
	   ?>
       <table width="100%" cellspacing="0" cellpadding="0" border="0" id="table_border"><form action="report_s_back.php?action=save&type=year" name="form1" method="post">
	    <tr height="40">
		 <td id="row_style" colspan="10">请选择日期&nbsp;&nbsp;<input type="text" name="sday" onclick="setday(this)" value="<?php echo ($action=='save')?$sday:GetDateMk(time());?>">(单击输入框选择报表日期)&nbsp;&nbsp;<input type="submit" value=" 显示年报表 ">&nbsp;<input type="button" value=" 导出Excel " onclick="out_excel('year')"></td>
	    </tr>
		<?php
	   break;
	   case 'other':
	   ?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" id="table_border">
	   <?php
	   break;
	   }
		if($action=='save'){//显示报表
        $row=new dedesql(false);
		$plist=new datalist();
		$plist->pageSize = $cfg_record;
		//设置GET参数表
		switch($type){
		case "day":
$query="select * from #@__saleback,#@__basic where to_days(#@__saleback.dtime)=to_days('$sday') and #@__saleback.productid=#@__basic.cp_number";
$query1="select * from #@__saleback,#@__basic where to_days(#@__saleback.dtime)=to_days('$sday') and #@__saleback.productid=#@__basic.cp_number";
$report_title="退货日报表";
break;
case "week":
$query="select * from #@__saleback,#@__basic where week(#@__saleback.dtime)='$sday' and #@__saleback.productid=#@__basic.cp_number";
$query1="select * from #@__saleback,#@__basic where week(#@__saleback.dtime)='$sday' and #@__saleback.productid=#@__basic.cp_number";
$report_title="退货周报表";
break;
case "month":
$query="select * from #@__saleback,#@__basic where month(#@__saleback.dtime)=month('$sday') and #@__saleback.productid=#@__basic.cp_number";
$query1="select * from #@__saleback,#@__basic where month(#@__saleback.dtime)=month('$sday') and #@__saleback.productid=#@__basic.cp_number";
$report_title="退货月报表";
break;
case "year":
$query="select * from #@__saleback,#@__basic where YEAR(#@__saleback.dtime)=YEAR('$sday') and #@__saleback.productid=#@__basic.cp_number";
$query1="select * from #@__saleback,#@__basic where year(#@__saleback.dtime)=year('$sday') and #@__saleback.productid=#@__basic.cp_number";
$report_title="退货年报表";
break;
case "other":
$query="select * from #@__saleback,#@__basic where #@__saleback.rdh='$sday' and #@__saleback.productid=#@__basic.cp_number";
$query1="select * from #@__saleback,#@__basic where #@__saleback.rdh='$sday' and #@__saleback.productid=#@__basic.cp_number";
$report_title="客户退货单";
break;
}
$p_name=getCookie('VioomaUserID');
$p_date=GetDateMk(time());
$dh=$sday;
$row->setquery($query1);
$row->execute();
while($rs=$row->getArray()){
$allmoney+=$rs['number']*$rs['cp_sale'];
$alln+=$rs['number'];
}
$row->close();
$plist->SetParameter("type",$type);
$plist->SetParameter("action",$action);
$plist->SetParameter("sday",$sday);
$plist->SetSource($query);
$p_rtitle= "<tr class='row_report_head'>
<td>货号</td>
<td>名称</td>
<td>规格</td>
<td>分类</td>
<td>单位</td>
<td>售价</td>
<td>客户</td>
<td>销售单号</td>
<td>数量</td>
<td>金额</td>
</tr>";
$mylist = $plist->GetDataList();
       while($row = $mylist->GetArray('dm')){
	   $n+=$row['number'];
	   $money+=$row['number']*$row['cp_sale'];
	   $p_string=$p_string."<tr onMouseMove=\"javascript:this.bgColor='#EBF1F6';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">\r\n
	   <td>".$row['productid']."</td>\r\n
	   <td>&nbsp;".$row['cp_name']."</td>\r\n
	   <td>".$row['cp_gg']."</td>\r\n
	   <td>".get_name($row['cp_categories'],'categories').">".get_name($row['cp_categories_down'],'categories')."</td>\r\n
	   <td>".get_name($row['cp_dwname'],'dw')."</td>
	   <td>￥".$row['cp_sale']."</td>\r\n
	   <td>".$row['member']."</td>\r\n
	   <td>".$row['sdh']."</td>\r\n
	   <td>".$row['number']."</td>\r\n
	   <td>￥".$row['number']*$row['cp_sale']."</td>\r\n
	   </tr>";
	   }
	   $p_string="<table width='100%' id='report_table' border='1' cellspacing='0' cellpadding='0'>". $p_rtitle .$p_string. "<tr>\r\n<td>&nbsp;&nbsp;小  计：</td><td colspan='5'>&nbsp;</td><td colspan='2'>数量：".$n."</td><td colspan='2'>金额：￥".$money."</td>\r\n</tr>\r\n
	   <tr><td>&nbsp;&nbsp;合  计:</td><td colspan='5'>&nbsp;</td><td colspan='2'>数量：".$alln."</td><td colspan='2'>金额:￥".number_format($allmoney,2,'.',',')."</td></tr>
	   </table>";	
	   $p_pagestring=$plist->GetPageList($cfg_record);
		}
		?>
	   </table><?php if($action=='save'){?>
	   <table width="100%" cellspacing="0" cellpadding="0">
	    <tr>
		 <td>
   	  <!--startprint1-->
<?php 
if($type=='other')
require(dirname(__FILE__)."/templets/t_saleback_single.html");
else
require(dirname(__FILE__)."/templets/t_saleback.html");
?>
	   <!--endprint1-->
	     </td>
		</tr>
	   </table>
	   <?php } ?>
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
<?php
copyright();
?>
</body>
</html>
