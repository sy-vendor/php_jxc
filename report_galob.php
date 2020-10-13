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
<title>营业统计</title>
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
      <td><strong>&nbsp;营业统计</strong>&nbsp;&nbsp; 
	  <a href="report_galob.php?type=other">综合统计</a>&nbsp;&nbsp;
	  <input type="button" onClick="preview(1);" value=" 打印统计报表 ">
	  </td>
     </tr>
     <tr>
      <td bgcolor="#FFFFFF">
     <?php
	  if($type=='')$type='other';
	  switch($type){
	   case 'month':
	   ?>
       <table width="100%" cellspacing="0" cellpadding="0" border="0" id="table_border">
	    <tr height="40">
		<form action="report_galob.php?action=save&type=month" name="form1" method="post">
		 <td id="row_style" colspan="10">
		 供应商名称:<?php echo ($action=='save')?getgyslist($gys,'select'):getgyslist('','')?>&nbsp;
		 请选择月份&nbsp;&nbsp;<input type="text" name="sday" onclick="setday(this)" value="<?php echo ($action=='save')?$sday:GetDateMk(time());?>">(单击输入框选择报表日期)&nbsp;&nbsp;
		 <input type="submit" value=" 显示月统计 ">
		 </td>
	    </tr>
	   <?php
	   break;
	   case 'year':
	   ?>
       <table width="100%" cellspacing="0" cellpadding="0" border="0" id="table_border">
	    <tr height="40">
		<form action="report_galob.php?action=save&type=year" name="form1" method="post">
		 <td id="row_style" colspan="10">
		 供应商名称:<?php echo ($action=='save')?getgyslist($gys,'select'):getgyslist('','')?>&nbsp;
		 请选择年份&nbsp;&nbsp;<input type="text" name="sday" onclick="setday(this)" value="<?php echo ($action=='save')?$sday:GetDateMk(time());?>">(单击输入框选择报表日期)&nbsp;&nbsp;
		 <input type="submit" value=" 显示年统计 ">
		 </td>
	    </tr>
		<?php
	   break;
	   case 'other':
	   ?>
	   <table width="100%" cellspacing="0" cellpadding="0" border="0" id="table_border">
	   <tr height="40">
		<form action="report_galob.php?action=save&type=other" name="form1" method="post">
		 <td id="row_style" colspan="10">
		 开始时间:&nbsp;&nbsp;<input type="text" name="sday" onclick="setday(this)" value="<?php echo ($action=='save')?$sday:GetDateMk(time());?>">&nbsp;&nbsp;结束时间:&nbsp;&nbsp;<input type="text" name="eday" onclick="setday(this)" value="<?php echo ($action=='save')?$eday:GetDateMk(time());?>">(单击输入框选择报表日期)&nbsp;&nbsp;
		 <input type="submit" value=" 显示综合统计 ">
	   <?php
	   break;
	   }
		if($action=='save'){//显示报表
        $row=new dedesql(false);
		switch($type){
case 'other':
//采购情况
$query="select distinct rdh from #@__kc where dtime between '$sday' and '$eday'";
$row->setquery($query);
$row->execute();
$total_d=$row->gettotalrow();//单数
$query="select * from #@__kc,#@__basic where #@__kc.productid=#@__basic.cp_number and dtime between '$sday' and '$eday'";
$report_title="综合营业分析";
$row->setquery($query);
$row->execute();
while ($rs=$row->getArray()){
 $totalnumber_in+=$rs['number'];
 $totalmoney_in+=$rs['number']*$rs['cp_jj'];
}
//采购退货情况
$query="select distinct rdh from #@__kcbackgys where dtime between '$sday' and '$eday'";
$row->setquery($query);
$row->execute();
$total_b=$row->gettotalrow();//退单数
$query="select * from #@__kcbackgys,#@__basic where #@__kcbackgys.productid=#@__basic.cp_number and dtime between '$sday' and '$eday'";
$row->setquery($query);
$row->execute();
while($rs=$row->getArray()){
 $totalmoney_back+=$rs['number']*$rs['cp_jj'];
 $totalnumber_back+=$rs['number'];
 }
//销售情况
$query="select distinct rdh from #@__sale where dtime between '$sday' and '$eday'";
$row->setquery($query);
$row->execute();
$total_s=$row->gettotalrow();//出单数
$query="select * from #@__sale,#@__basic where #@__sale.productid=#@__basic.cp_number and dtime between '$sday' and '$eday'";
$row->setquery($query);
$row->execute();
while ($rs=$row->getArray()){
 $totalnumber_s+=$rs['number'];
 $totalmoney_s+=$rs['number']*$rs['cp_sale'];
 $totalmoney_cb+=$rs['number']*$rs['cp_jj'];//销售成本
}
//销售退货情况
$query="select distinct rdh from #@__saleback where dtime between '$sday' and '$eday'";
$row->setquery($query);
$row->execute();
$total_sb=$row->gettotalrow();//退单数
$query="select * from #@__saleback,#@__basic where #@__saleback.productid=#@__basic.cp_number and dtime between '$sday' and '$eday'";
$row->setquery($query);
$row->execute();
while ($rs=$row->getArray()){
 $totalnumber_back+=$rs['number'];
 $totalmoney_sb+=$rs['number']*$rs['cp_sale'];
 $totalmoney_sb_cb+=$rs['number']*$rs['cp_jj'];
}
//库存
$query="select * from #@__mainkc,#@__basic where #@__mainkc.p_id=#@__basic.cp_number";
$row->setquery($query);
$row->execute();
while ($rs=$row->getArray()){
 $totalnumber_kc+=$rs['number'];
 $totalmoney_kc+=$rs['number']*$rs['cp_jj'];
}
break;
}
$p_name=GetCookie('VioomaUserID');
$p_date=GetDateMk(time());

$row->close();
}
		?>
	   </table>
	   <?php if($action=='save'){?>
	   <table width="100%" cellspacing="0" cellpadding="0">
	    <tr>
		 <td>
   	  <!--startprint1-->
<?php 
require(dirname(__FILE__)."/templets/t_global.html");
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
