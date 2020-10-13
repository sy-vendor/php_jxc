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
<title>仓库调拨管理</title>
<style type="text/css">
.rtext {background:transparent;border:0px;color:red;font-weight:bold;font-family:Verdana, Arial, Helvetica, sans-serif;}
</style>
<script language="javascript">
function isInteger(sNum) { 
var num 
num=new RegExp('[^0-9_]','') 
if (isNaN(sNum)) { 
return false 
} 
else { 
if (sNum.search(num)>=0) { 
return false 
} 
else { 
return true 
} 
} 
} 

function getinfo(){
window.open('select_kc.php?form=form1&field=seek_text','selected','directorys=no,toolbar=no,status=no,menubar=no,resizable=no,width=750,height=500,top=100,left=120');
}
function putrkinfo(){
pid=document.forms[0].seek_number.value;//货号
did=document.forms[0].r_dh.value;//单号
lid=document.forms[0].labid2.value;//所在仓库号
lid2=document.forms[0].labid.value;//目标仓库号
number=document.forms[0].rk_number.value;//数量

if(pid==''){
alert('请选择要入库的产品!');
return false;
}
if(number=='' || (!isInteger(number)) || number<=0){
alert('请确保输入了正确的入库数量');
return false;
}
url="sw_order.php?pid="+pid+"&did="+did+"&lid="+lid+"&num="+number+"&tolid="+lid2;
var obj=window.frames["current_order"];
 obj.window.location=url;
}

function showsubinfo(tbnum){
whichEl = eval("rk_subinfo" + tbnum);
if (whichEl.style.display == "none"){eval("rk_subinfo" + tbnum + ".style.display=\"\";");}
else{eval("rk_subinfo" + tbnum + ".style.display=\"none\";");}
}
</script>
</head>
<?php
//入库单号设置
$rs=New Dedesql(falsh);
$query="select * from #@__reportswitch";
$rs->SetQuery($query);
$rs->Execute();
$rowcount=$rs->GetTotalRow();
$cdh="SW".str_replace('-','',GetDateMk(date(time())))."-".($rowcount+1);
 $rs->close();
 
if ($action=='save'){//保存入库单及记录

$bsql=New Dedesql(false);
$query="select * from #@__switch where rdh='$r_dh'";
$bsql->SetQuery($query);
$bsql->Execute();
$rowcount=$bsql->GetTotalRow();
if ($rowcount==0){
 ShowMsg('非法参数或没有添加产品信息!','-1');
 exit();
}
else{
 while($row=$bsql->getArray()){
 $csql=New dedesql(false);
 //修改库存
 $csql->ExecuteNoneQuery("update #@__mainkc set number=number-".$row['number']." where p_id='".$row['productid']."' and l_id='".$row['fromlab']."'");
 //检索目标仓库有无此产品
 $csql->setquery("select * from #@__mainkc where p_id='".$row['productid']."' and l_id='".$row['tolab']."'");
 $csql->execute();
 $totalrec=$csql->gettotalrow();
 if($totalrec==0)
  $csql->executenonequery("insert into #@__mainkc(p_id,l_id,number) values('".$row['productid']."','".$row['tolab']."','".$row['number']."')");
  else
  $csql->executenonequery("update #@__mainkc set number=number+".$row['number']." where p_id='".$row['productid']."' and l_id='".$row['tolab']."'");
 }
 $csql->close(); 
 $loginip=getip();
 $logindate=getdatetimemk(time());
 $username=GetCookie('VioomaUserID');
 WriteNote('调拨单'.$r_dh.'成功保存',$logindate,$loginip,$username);
 $newsql=New dedesql(false);
 $newsql->executenonequery("insert into #@__reportswitch(r_dh,r_people,r_date,r_status) values('".$r_dh."','".$r_people."','".$r_date."','0')");
 $newsql->close();
 ShowMsg('仓库调拨已完成操作','system_switch.php');
$bsql->close();
exit();
    }
}
else if($action=='seek'){ //列表
?>
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
      <td><strong>&nbsp;仓库调拨管理</strong>&nbsp;&nbsp;- <a href="system_switch.php">新调拨单</a></td>
     </tr>
     <tr>
      <td bgcolor="#FFFFFF">
<?php
       echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" id=\"table_border\">";
	   $query="select * from #@__reportswitch";
       $csql=New Dedesql(false);
	   $dlist = new DataList();
       $dlist->pageSize = $cfg_record;
       $dlist->SetParameter("action",$action);//设置GET参数表
       $dlist->SetSource($query);
	   echo "<tr class='row_color_head'>
	   <td>ID</td>
	   <td>调拨单号</td>
	   <td>操作人员</td>
	   <td>创单时间</td>
	   <td>审核状态</td>
	   <td>相关操作</td>
	   </tr>";
	   $mylist = $dlist->GetDataList();
       while($row = $mylist->GetArray('dm')){
	   if($row['r_status']==1){
	   $statusstring="<a href='?action=sure&t=no&id=".$row['id']."'><img src='images/yes.png' alt='取消该单审核' border='0'></a>";
	   $printstring=" | <a href=report_rk.php?action=save&type=other&sday=".$row['r_dh'].">打印调拨单</a>";
	   }
	   else{
	   $statusstring="<a href='?action=sure&t=yes&id=".$row['id']."'><img src='images/no.png' alt='审核该单' border='0'></a>";
	   $printstring="";}
	   echo "<tr><td>ID号:".$row['id']."</td><td>&nbsp;".$row['r_dh']."</td><td>&nbsp;".$row['r_people']."</td><td>&nbsp;".$row['r_date']."</td><td>&nbsp;".$statusstring."</td><td><span onclick=showsubinfo(".$row['id'].") style='cursor:hand;'>展开详情</span>".$printstring."</td></tr>";
	   echo "<tr id='rk_subinfo".$row['id']."' style='display:none;'><td colspan='6'><br><table width=\"98%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" id=\"table_border\" align=\"center\">";
	   
	   $csql1=New Dedesql(false);
	   $csql1->SetQuery("select * from #@__switch where rdh='".$row['r_dh']."'");
	   $csql1->Execute();
	   $rowcount=$csql1->GetTotalRow();
	   echo "<tr class='row1_color_head'>
	   <td>货号</td>
	   <td>名称</td>
	   <td>规格</td>
	   <td>分类</td>
	   <td>单位</td>
	   <td>进价</td>
	   <td>供应商</td>
	   <td>调拨数量</td>
	   <td>调拨情况</td>
	   </tr>";
	   while($row=$csql1->GetArray()){
	   $nsql=New dedesql(false);
	   $query1="select * from #@__basic where cp_number='".$row['productid']."'";
	   $nsql->setquery($query1);
	   $nsql->execute();
	   $row1=$nsql->getone();
	   echo "<tr onMouseMove=\"javascript:this.bgColor='#EBF1F6';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\"><td>".$row['productid']."</td><td>&nbsp;".$row1['cp_name']."</td><td>".$row1['cp_gg']."</td><td>".get_name($row1['cp_categories'],'categories').">".get_name($row1['cp_categories_down'],'categories')."</td><td>".get_name($row1['cp_dwname'],'dw')."</td><td>￥".$row1['cp_jj']."</td><td>".$row1['cp_gys']."</td><td>".$row['number']."</td><td>从 ".get_name($row['fromlab'],'lab')." 到 ".get_name($row['tolab'],'lab')."</td></tr>";
	   $nsql->close();
	   }
	   $csql1->close();
	   echo "</table><br></td></tr>\r\n";
	   }
	   $csql->close();
   echo "<tr><td colspan='6'>&nbsp;".$dlist->GetPageList($cfg_record)."</td></tr></table>\r\n </td></tr></table>
 </td></tr>  <tr>
    <td id=\"table_style\" class=\"l_b\">&nbsp;</td>
    <td>&nbsp;</td>
    <td id=\"table_style\" class=\"r_b\">&nbsp;</td>
  </tr>
</table>";
 }
 else if($action=='sure'){
 $susql=new dedesql(false);
 if($t=='yes')
 $query="update #@__reportswitch set r_status=1 where id='$id'";
 else
 $query="update #@__reportswitch set r_status=0 where id='$id'";
 $susql->executenonequery($query);
 $susql->close();
 showmsg('单据审核状态已修改','system_switch.php?action=seek');
 }
 else{
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
      <td><strong><strong>&nbsp;库存调拨管理</strong>(注:橙色背景为必填选项)&nbsp;&nbsp;- <a href="system_switch.php">新调拨单</a> - <a href="system_switch.php?action=seek">调拨单查询</a></td>
     </tr><form action="system_switch.php?action=save" method="post" name="form1">
     <tr>
      <td bgcolor="#FFFFFF">
       <table width="100%" border="0" cellspacing="0" cellpadding="0" id="table_border">
    <tr height="30">
    <td class="cellcolor">调拨单号:</td>
    <td class="cellcolor">&nbsp;<input type="text" name="r_dh" value="<?php echo $cdh; ?>" readonly class="rtext" size="15">&nbsp;(创建人:<input type="text" name="r_people" value="<?php echo GetCookie('VioomaUserID'); ?>" readonly class="rtext" size="8">      创建时间:
      <input type="text" name="r_date" value="<?php echo GetDateTimeMk(time());?>"  readonly class="rtext" />
      )</td>
  </tr>
  <tr>
    <td class="cellcolor" width="30%">产品检索信息:<br></td>
    <td>&nbsp;
      <input type="text" name="seek_text" value="单击选择产品信息" onclick="getinfo()" />      &nbsp;(快速检索产品信息)
	<input type="hidden" name="seek_number" value=""/>	<input type="hidden" name="labid2" value=""/></td>
  </tr> 
  <tr>
    <td class="cellcolor" width="30%">所在仓库:<br></td>
    <td>&nbsp;<input type="text" name="labtext" value="" readonly class="rtext"/>&nbsp;&nbsp;目标仓库:&nbsp;<?php getlab();?></td>
  </tr> 
  <tr>
    <td class="cellcolor" width="30%">调拨数量:<br></td>
    <td>&nbsp;<input type="text" name="rk_number" size="5"><input type="text" class="rtext" name="showdw" readonly size="5">	</td>
  </tr>   
  <tr id="product_date" style="display:block;">
   <td colspan="2">
   &nbsp;<input type="text" class="rtext" style="width:80%;" name="showinfo" readonly>   </td>
  </tr> 
  <tr>
    <td class="cellcolor">&nbsp;</td>
    <td>&nbsp;<input type="button" value=" 登记到此单 " onclick="putrkinfo()">&nbsp;&nbsp;<input type="submit" value="保存此单入库记录"></td>
  </tr></form>
  <tr>
   <td colspan="2">
   <iframe src="sw_order.php?pid=&did=<?php echo $cdh ?>&action=normal" width="100%" height="400" scrolling="auto" frameborder="0" marginheight="0" marginwidth="0" name="current_order" od="current_order"></iframe>   </td>
  </tr>
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
