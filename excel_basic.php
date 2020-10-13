<?php
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/config_rglobals.php");
$query="select * from #@__basic";
$row=New Dedesql(false);
$row->setquery($query);
$row->execute();
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:filename=excel_basic.xls");
echo "货号\t名称\t规格\t分类\t单位\t进价\t供应商\t\n";
while($rs=$row->getArray()){
$alln+=1;
echo $rs['cp_number']."\t".$rs['cp_name']."\t".$rs['cp_gg']."\t".get_name($rs['cp_categories'],'categories').">".get_name($rs['cp_categories_down'],'categories')."\t".get_name($rs['cp_dwname'],'dw')."\t".$rs['cp_jj']."\t".get_name($rs['cp_number'],'gys')."\t\n";
}
echo "合   计\t\t\t\t\t\t\t产品种类：\t".$alln." 种\t\n";
?>