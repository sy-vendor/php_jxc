<?php
require(dirname(__FILE__)."/include/config_rglobals.php");
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/page.php");
require_once(dirname(__FILE__)."/include/checklogin.php");
check_grant('sale.php',GetCookie('rank'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link href="style/main.css" rel="stylesheet" type="text/css" />
<title>销售管理</title>
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
window.open('system_basic_list.php?form=form1&field=seek_text','selected','directorys=no,toolbar=no,status=no,menubar=no,resizable=no,width=750,height=500,top=100,left=120,scrollbars=yes');
}
function getinfo1(){
window.open('member_list.php?form=form1&field=member','selected','directorys=no,toolbar=no,status=no,menubar=no,resizable=no,width=600,height=500,top=100,left=320,scrollbars=yes');
}

function putrkinfo(){
pid=document.forms[0].seek_number.value;//货号
did=document.forms[0].r_dh.value;//单号
member=document.forms[0].member.value;//会员
number=document.forms[0].rk_number.value;//退回数量
salen=document.forms[0].sale.value;//销售价
lid=document.forms[0].labid.value;//仓库号
if(pid==''){
alert('请选择要销售的产品!');
return false;
}
if(number=='' || (!isInteger(number)) || number<=0){
alert('请确保输入了正确的销售数量');
return false;
}
if(salen=='' || salen<=0){
alert('请确保输入了正确的销售价格');
return false;
}
url="current_order_sale.php?pid="+pid+"&did="+did+"&num="+number+"&sale="+salen+"&labid="+lid+"&member="+member;
var obj=window.frames["current_order"];
 obj.window.location=url;
}

function showsubinfo(tbnum){
whichEl = eval("rk_subinfo" + tbnum);
if (whichEl.style.display == "none"){eval("rk_subinfo" + tbnum + ".style.display=\"\";");}
else{eval("rk_subinfo" + tbnum + ".style.display=\"none\";");}
}
function setsale(number){
document.forms[0].sale.value=number;
}
</script>
</head>
<?php
//入库单号设置
$rs=New Dedesql(falsh);
$query="select * from #@__reportsale";
$rs->SetQuery($query);
$rs->Execute();
$rowcount=$rs->GetTotalRow();
$cdh="Vs".str_replace('-','',GetDateMk(date(time())))."-".($rowcount+1);
 $rs->close();
 
if ($action=='save'){//保存退货单及记录

$bsql=New Dedesql(false);
$query="select * from #@__sale where rdh='$r_dh'";//遍历此单产品
$bsql->SetQuery($query);
$bsql->Execute();
$rowcount=$bsql->GetTotalRow();
if ($rowcount==0){
 ShowMsg('非法参数或没有要销售的产品!','-1');
 exit();
}
else{
 checkbank();
 $money=0;
 while($row=$bsql->getArray()){
 $money+=$row['number']*$row['sale'];
 $csql=New dedesql(false);
 $csql->setquery("select * from #@__mainkc where p_id='".$row['productid']."'");
 $csql->execute();
 $totalrec=$csql->gettotalrow();
 if($totalrec!=0){
  $csql->executenonequery("update #@__mainkc set number=number-".$row['number']." where p_id='".$row['productid']."' and l_id='".$row['salelab']."'");
  }
 }
 //预付款处理
 if($payed!='' && $payed>0){
 $guestid=get__id('#@__guest',$member,'id','g_name');
 if($guestid>0){
 if($money>=$payed)
 $csql->ExecuteNonequery("update #@__guest set g_pay=0 where id='$guestid'");
 else
 $csql->ExecuteNonequery("update #@__guest set g_pay=g_pay-".$money." where id='$guestid'");
 }
 }
 $csql->close(); 
 $loginip=getip();
 $logindate=getdatetimemk(time());
 $username=GetCookie('VioomaUserID');
 WriteNote('销售单'.$r_dh.'成功保存',$logindate,$loginip,$username);
 $newsql=New dedesql(false);
 $newsql->executenonequery("insert into #@__reportsale(r_dh,r_people,r_date,r_status,r_adid) values('".$r_dh."','".$r_people."','".$r_date."','0','".$staff."')");
 //写入财务记录
 $newsql->executenonequery("insert into #@__accounts(atype,amoney,abank,dtime,apeople,atext) values('收入','".$money."','".BANKID."','".$r_date."','".$r_people."','销售产品收入现金，对应销售单号为：".$r_dh."')");
  //更新银行金额
 $newsql->executenonequery("update #@__bank set bank_money=bank_money+".$money." where id='".BANKID."'");
 $newsql->close();
 ShowMsg('产品已销售,系统自动跳转到销售单打印界面.','report_sale.php?action=save&type=other&sday='.$r_dh);
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
      <td><strong>&nbsp;销售单管理</strong>&nbsp;&nbsp;- <a href="sale.php">新单</a> <a href="importsale1.php">导入销售数据</a> | <a href="importsale2.php">导入销售细则</a></td>
     </tr>
     <tr>
      <td bgcolor="#FFFFFF">
<?php
$orderstring=" order by r_date desc";
       echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" id=\"table_border\">";
	   if(GetCookie('rank')==1)
	   $query="select * from #@__reportsale".$orderstring;
	   else
	   $query="select * from #@__reportsale where r_people='".GetCookie('VioomaUserID')."'".$orderstring;
       $csql=New Dedesql(false);
	   $dlist = new DataList();
       $dlist->pageSize = $cfg_record;
       $dlist->SetParameter("action",$action);//设置GET参数表
       $dlist->SetSource($query);
	   echo "<tr class='row_color_head'>
	   <td>ID</td>
	   <td>销售单号</td>
	   <td>操作人员</td>
	   <td>创单时间</td>
	   <td>审核状态</td>
	   <td>相关操作</td>
	   </tr>";
	   $mylist = $dlist->GetDataList();
       while($row = $mylist->GetArray('dm')){
	   if($row['r_status']==1){
	   if(Getcookie('rank')=='1')
	   $statusstring="<a href='?action=sure&t=no&id=".$row['id']."'><img src='images/yes.png' alt='取消该单审核' border='0'></a>";
	    else
	   $statusstring="<img src='images/yes.png' alt='取消该单审核' border='0'>";
	   $printstring=" | <a href=report_sale.php?action=save&type=other&sday=".$row['r_dh'].">打印销售单</a>";
	   }
	   else{
	   if(Getcookie('rank')=='1')
	   $statusstring="<a href='?action=sure&t=yes&id=".$row['id']."'><img src='images/no.png' alt='审核该单' border='0'></a>";
	    else
	   $statusstring="<img src='images/no.png' alt='审核该单' border='0'>";
	   $printstring="";
	   }
	   echo "<tr>
	   <td><center>ID号:".$row['id']."</td>
	   <td><center>&nbsp;".$row['r_dh']."</td>
	   <td><center>&nbsp;".$row['r_people']."</td>
	   <td><center>&nbsp;".$row['r_date']."</td>
	   <td><center>&nbsp;".$statusstring."</td>
	   <td><center><span onclick=showsubinfo(".$row['id'].") style='cursor:hand;'>展开详情</span> ".$printstring."</td>
	   </tr>";
	   echo "<tr id='rk_subinfo".$row['id']."' style='display:none;'>
	   <td colspan='6'><br>
	   <table width=\"98%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" id=\"table_border\" align=\"center\">";
	   
	   $csql1=New Dedesql(false);
	   $csql1->SetQuery("select * from #@__sale where rdh='".$row['r_dh']."'");
	   $csql1->Execute();
	   $rowcount=$csql1->GetTotalRow();
	   echo "<tr class='row1_color_head'>
	   <td><center>货号</td>
	   <td><center>名称</td>
	   <td><center>规格</td>
	   <td><center>分类</td>
	   <td><center>单位</td>
	   <td><center>售价</td>
	   <td><center>客户</td>
	   <td><center>销售数量</td>
	   <td><center>金额</td>
	   </tr>";
	   while($row=$csql1->GetArray()){
	   $nsql=New dedesql(false);
	   $query1="select * from #@__basic where cp_number='".$row['productid']."'";
	   $nsql->setquery($query1);
	   $nsql->execute();
	   $row1=$nsql->getone();
	   echo "<tr onMouseMove=\"javascript:this.bgColor='#EBF1F6';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">
	   <td><center>".$row['productid']."</td>
	   <td><center>&nbsp;".$row1['cp_name']."</td>
	   <td><center>".$row1['cp_gg']."</td>
	   <td><center>".get_name($row1['cp_categories'],'categories').">".get_name($row1['cp_categories_down'],'categories')."</td>
	   <td><center>".get_name($row1['cp_dwname'],'dw')."</td>
	   <td><center>￥".$row['sale']."</td>
	   <td><center>".$row['member']."</td>
	   <td><center>".$row['number']."</td>
	   <td><center>￥".number_format($row['number']*$row['sale'],2,'.',',')."</td>
	   </tr>";
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
 $query="update #@__reportsale set r_status=1 where id='$id'";
 else
 $query="update #@__reportsale set r_status=0 where id='$id'";
 $susql->executenonequery($query);
 $susql->close();
 showmsg('单据审核状态已修改','sale.php?action=seek');
 }
 else{
?>
<script language="javascript">
function check(e){
var e = window.event ? window.event : e;
    if(e.keyCode == 13){
        thistm=document.forms[0].tm.value;
    //window.parent.main.location.href='sale.php?thistm='+thistm;
        window.location.href='sale.php?thistm='+thistm;
    //document.forms[0].rk_number.focus();
	return false;
    }
}
function checkForm(){
document.forms[0].submit();
}
</script>
<body onload="form1.tm.focus()">
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
      <td><strong><strong>&nbsp;销售管理</strong>&nbsp;&nbsp;- <a href="sale.php">新单</a> - <a href="sale.php?action=seek">销售单查询</a></td>
     </tr>
     <tr>
      <td bgcolor="#FFFFFF">
       <table width="100%" border="0" cellspacing="0" cellpadding="0" id="table_border">
	   <form action="sale.php?action=save" method="post" name="form1">
    <tr height="30">
    <td class="cellcolor">销售单号:</td>
    <td class="cellcolor">&nbsp;<input type="text" name="r_dh" value="<?php echo $cdh; ?>" readonly class="rtext" size="15">&nbsp;(销售人员:<input type="text" name="r_people" value="<?php echo GetCookie('VioomaUserID'); ?>" readonly class="rtext" size="8">创建时间:<input type="text" name="r_date" value="<?php echo GetDateTimeMk(time());?>"  readonly class="rtext">)</td>
  </tr>
  <tr>
    <td class="cellcolor" width="30%">产品检索信息:<br></td>
    <td>&nbsp;<input type="text" name="tm" value="" onkeydown="check(event);" ondblclick="getinfo()">&nbsp;<img src="images/03.gif" border="0" style="cursor:hand;" alt="单击浏览更多产品信息" onclick="getinfo()"> 
	<input type="text" name="seek_text" value="" readonly class="rtext" size="15">(支持扫描枪)
	<input type="hidden" name="seek_number" value=""/>
	</td>
  </tr> 
  <tr>
    <td class="cellcolor" width="30%">数量:<br></td>
    <td>
	&nbsp;<input type="text" name="rk_number" size="5"><input type="text" class="rtext" name="showdw" readonly size="15">
	&nbsp;<!--出货仓库--><input type="hidden" name="labid" value="">
	</td>
  </tr> 
  <tr>
    <td class="cellcolor" width="30%">业务员:<br></td>
    <td>&nbsp;<?php getadid('');?>
	</td>
  </tr>
  <tr>
   <td class="cellcolor" width="30%">销售价格：</td>
   <td>&nbsp;<input type="text" name="sale" id="need">&nbsp;(请选择或输入售价)
   <div style="height:27px;float:left;" id="sale_string"></div>
   </td>
  </tr>
  <tr>
    <td class="cellcolor" width="30%">客户:<br></td>
    <td>&nbsp;<input type="text" name="member">&nbsp;<input type="button" value="选择客户" onclick="getinfo1()">
	&nbsp;预存金额:<input type="text" name="payed" value="" size="6" class="rtext" readonly> 元
	</td>
  </tr>      
  <tr id="product_date" style="display:block;">
   <td colspan="2">
   &nbsp;所检索产品基本信息:<input type="text" class="rtext" style="width:80%;" name="showinfo" readonly>
   </td>
  </tr> 
  <tr>
    <td class="cellcolor">&nbsp;</td>
    <td>&nbsp;<input type="button" value=" 登记到此单 " onclick="putrkinfo()">&nbsp;&nbsp;<input type="button" value="保存此销售记录" onclick="checkForm()"></td>
  </tr>
  <tr>
   <td colspan="2">
   <iframe src="current_order_sale.php?pid=&did=<?php echo $cdh ?>&action=normal" width="100%" height="400" scrolling="auto" frameborder="0" marginheight="0" marginwidth="0" name="current_order" od="current_order"></iframe>
   </td>
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
if($thistm!=''){//扫描枪输入
	echo $thistm;
	$checksql=new Dedesql(false);
	$checkquery="select * from #@__basic,#@__mainkc where #@__basic.cp_tm='$thistm' and #@__mainkc.p_id=#@__basic.cp_number";
	$checksql->setquery($checkquery);
	$checksql->execute();
	$recordnumbers=$checksql->getTotalRow();
	if($recordnumbers==0){//无此条码
		?>
		<script language="javascript">
		 document.forms[0].tm.focus();
		</script>
		<?php 
	}
	else{
		$row=$checksql->getone();
		//echo $row['cp_name']
		?>
		<script lanugage="javascript">
		function showproduct(){
		document.forms[0].seek_text.value="<?php echo $row['cp_name']?>";
		document.forms[0].seek_number.value="<?php echo $row['cp_number']?>";
		document.forms[0].showinfo.value="产品名称：<?php echo $row['cp_number']?>  规格：<?php echo $row['cp_gg']?>";
		document.forms[0].showdw.value="<?php echo get_name($row['cp_dwname'],'dw')." 库存：".$row['number']?>";
		document.forms[0].sale.value="<?php echo $row['cp_sale']?>";
		document.forms[0].labid.value="<?php echo $row['l_id']?>";
		document.getElementById("sale_string").innerHTML="&nbsp;<input type='radio' name='sale1' checked value='<?php echo $row['cp_sale']?>' onclick='setsale(this.value)'><?php echo $row['cp_sale']?>&nbsp;零售<input type='radio' name='sale1' value='<?php echo $row['cp_saleall']?>' onclick='setsale(this.value)'><?php echo $row['cp_saleall']?>&nbsp;批发<input type='radio' name='sale1' value='<?php echo $row['cp_sale1']?>' onclick='setsale(this.value)'><?php echo $row['cp_sale1']?> 特殊";
		document.forms[0].rk_number.value="1";
		document.forms[0].rk_number.focus();
		}
		showproduct();
		</script>
		<?php 
	}
}
}
copyright();
?>
</body>
</html>