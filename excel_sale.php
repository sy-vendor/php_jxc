<?php
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/config_rglobals.php");
$row=new dedesql(false);
switch($type){
case "day":
$query="select * from #@__sale,#@__basic where YEAR(#@__kc.dtime)=YEAR('$sday') and month(#@__kc.dtime)=month('$sday') and to_days(#@__sale.dtime)=to_days('$sday') and #@__sale.productid=#@__basic.cp_number";
$report_title="销售日报表";
break;
case "week":
$query="select * from #@__sale,#@__basic where week(#@__sale.dtime)='$sday' and #@__sale.productid=#@__basic.cp_number";
$report_title="销售周报表";
break;
case "month":
$query="select * from #@__sale,#@__basic where YEAR(#@__kc.dtime)=YEAR('$sday') and month(#@__sale.dtime)=month('$sday') and #@__sale.productid=#@__basic.cp_number";
$report_title="销售月报表";
break;
case "year":
$query="select * from #@__sale,#@__basic where YEAR(#@__sale.dtime)=YEAR('$sday') and #@__sale.productid=#@__basic.cp_number";
$report_title="销售年报表";
break;
case "other":
$query="select * from #@__sale,#@__basic where #@__sale.rdh='$sday' and #@__sale.productid=#@__basic.cp_number";
$report_title="客户销售单";
break;
}
$row->setquery($query);
$row->execute();
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:filename=excel_rk.xls");
echo "货号\t名称\t规格\t分类\t单位\t售价\t客户\t销售单\t数量\t金额\t\n";
while($rs=$row->getArray()){
$allmoney+=$rs['number']*$rs['sale'];
$alln+=$rs['number'];
echo $rs['productid']."\t".$rs['cp_name']."\t".$rs['cp_gg']."\t".get_name($rs['cp_categories'],'categories').">".get_name($rs['cp_categories_down'],'categories')."\t".get_name($rs['cp_dwname'],'dw')."\t".$rs['cp_jj']."\t".get_name($rs['productid'],'gys')."\t".$rs['rdh']."\t".$rs['number']."\t￥".$rs['number']*$rs['sale']."\t\n";
}
echo "合   计\t\t\t\t\t\t\t\t数量：".$alln."\t金额：￥".$allmoney."\t\n";
?>