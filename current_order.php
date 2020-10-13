<?php
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/config_rglobals.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link href="style/main.css" rel="stylesheet" type="text/css" />
</head>
<body oncontextmenu="return false">
<?php
if($action=='del'){
$dsql=New Dedesql(false);
$delstring="delete from #@__kc where id='$id'";
$dsql->executenonequery($delstring);
$dsql->close();
echo "<script language='javascript'>window.location.href='current_order.php?action=normal&did=".$rid."'</script>";
}
?>
	<table width="100%" border="0" cellpadding="0" cellspacing="2">
     <tr>
      <td><strong>&nbsp;入库单详细产品</strong></td>
     </tr>
	 <form method="post" name="sel">
     <tr>
      <td bgcolor="#FFFFFF">
       <?php
       echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" id=\"table_border\">";
       $csql=New Dedesql(false);
	   if ($pid==''){//初始状态
	   if($action=='normal')
	   $csql->SetQuery("select * from #@__kc where rdh='$did'");
	   else
	   $csql->SetQuery("select * from #@__kc where id<0");
	   }
	   else{
	   if($action=='' && $did!=''){
	   //写入产品记录
	    if($rk_price=='' || (!is_numeric($rk_price)))ShowMsg("对不起，进价输入不合法！","-1");
	   $wsql=New Dedesql(false);
	   $writesql="select * from #@__basic where cp_number='$pid'";
	   $wsql->Setquery($writesql);
	   $wsql->Execute();
	   $wrs=$wsql->GetOne();
	   $wsql->ExecuteNoneQuery("insert into #@__kc(productid,number,labid,rdh,rk_price,bank,dtime) values('$pid','$num','$lid','$did','$rk_price','$bank','".GetDateTimeMk(time())."')");

	   $wsql->close();
	   }
	   $csql->SetQuery("select * from #@__kc where rdh='$did'");
	   }
	   $csql->Execute();
	   $rowcount=$csql->GetTotalRow();
	   if($rowcount==0)
	   echo "<tr><td>&nbsp;</td></tr>";
	   else{
	   echo "<tr class='row_color_head'>
	   <td>货号</td>
	   <td>名称</td>
	   <td>规格</td>
	   <td>分类</td>
	   <td>单位</td>
	   <td>进价</td>
	   <td>供应商</td>
	   <td>入库数量</td>
	   <td>删除</td>
	   </tr>";
	   while($row=$csql->GetArray()){
	   $nsql=New dedesql(false);
	   $query1="select * from #@__basic where cp_number='".$row['productid']."'";
	   $nsql->setquery($query1);
	   $nsql->execute();
	   $row1=$nsql->getone();
	   $amoney+=$row['rk_price']*$row['number'];
	   $anum+=$row['number'];
	   echo "<tr onMouseMove=\"javascript:this.bgColor='#EBF1F6';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">
	   <td><center>".$row['productid']."</td>
	   <td><center>".$row1['cp_name']."</td>
	   <td><center>".$row1['cp_gg']."</td>
	   <td><center>".get_name($row1['cp_categories'],'categories').">".get_name($row1['cp_categories_down'],'categories')."</td>
	   <td><center>".get_name($row1['cp_dwname'],'dw')."</td>
	   <td><center>￥".$row['rk_price']."</td>
	   <td><center>".$row1['cp_gys']."</td>
	   <td><center>".$row['number']."</td>
	   <td><center><a href='current_order.php?action=del&id=".$row['id']."&rid=".$row['rdh']."'>删除</a></td>
	   </tr>";
	   $nsql->close();
	   }
	   }
	   echo "<tr>
	   <td>&nbsp;共计:</td>
	   <td></td><td></td><td></td>
	   <td>&nbsp;金额:</td>
	   <td>￥".$amoney."</td>
	   <td align='right'>数量:</td>
	   <td>".$anum."</td>
	   </tr>
	   </table>";
	   $csql->close();
	   ?>
	  </td>
     </tr></form>
    </table>
</body>
</html>
