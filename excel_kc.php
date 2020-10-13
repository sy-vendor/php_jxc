<?php
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/config_rglobals.php");

if($action=='seek'){
	   if($cp_categories_down=='')echo "<script>alert('请选择小分类');history.go(-1);</script>";
	   switch($sort){
	    case "1"://按货号
		$query="select * from #@__mainkc,#@__basic where  #@__basic.cp_number='$stext' and #@__basic.cp_categories='$cp_categories' and #@__basic.cp_categories_down='$cp_categories_down' and #@__mainkc.p_id=#@__basic.cp_number";
		break;
		case "2"://按条码
		$query="select * from #@__mainkc,#@__basic where  #@__basic.cp_tm='$stext' and #@__basic.cp_categories='$cp_categories' and #@__basic.cp_categories_down='$cp_categories_down' and #@__mainkc.p_id=#@__basic.cp_number";
		break;
		case "3"://按名称
		$query="select * from #@__mainkc,#@__basic where  #@__basic.cp_name LIKE '%".$stext."%' and #@__basic.cp_categories='$cp_categories' and #@__basic.cp_categories_down='$cp_categories_down' and #@__mainkc.p_id=#@__basic.cp_number";
		break;
		case "4"://按肋记词
		$query="select * from #@__mainkc,#@__basic where  #@__basic.cp_helpword LIKE '%".$stext."%' and #@__basic.cp_categories='$cp_categories' and #@__basic.cp_categories_down='$cp_categories_down' and #@__mainkc.p_id=#@__basic.cp_number";
		break;
		}
	   }
	   else
       $query="select * from #@__mainkc,#@__basic where #@__mainkc.p_id=#@__basic.cp_number";
	   //echo $query;
	   //exit();
$row=New Dedesql(false);
$row->setquery($query);
$row->execute();
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:filename=excel_rk.xls");
echo "货号\t名称\t规格\t分类\t单位\t进价\t供应商\t所在仓库\t库存\t\n";
while($rs=$row->getArray()){
$allmoney+=$rs['number']*$rs['cp_jj'];
$alln+=$rs['number'];
echo $rs['p_id']."\t".$rs['cp_name']."\t".$rs['cp_gg']."\t".get_name($rs['cp_categories'],'categories').">".get_name($rs['cp_categories_down'],'categories')."\t".get_name($rs['cp_dwname'],'dw')."\t".$rs['cp_jj']."\t".get_name($rs['p_id'],'gys')."\t".get_name($rs['l_id'],'lab')."\t".$rs['number']."\t\n";
}
echo "合   计\t\t\t\t\t\t\t库存：".$alln."\t金额：￥".$allmoney."\t\n";
?>