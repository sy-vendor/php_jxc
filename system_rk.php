<?php
require(dirname(__FILE__)."/include/config_rglobals.php");
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/page.php");
require_once(dirname(__FILE__)."/include/checklogin.php");
check_grant('system_rk.php',GetCookie('rank'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link href="style/main.css" rel="stylesheet" type="text/css" />
<title>产品入库管理</title>
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
window.open('rk_list.php?form=form1&field=seek_text','selected','directorys=no,toolbar=no,status=no,menubar=no,resizable=no,width=750,height=500,top=100,left=120,scrollbars=yes');
}
function putrkinfo(){
pid=document.forms[0].seek_number.value;//货号
did=document.forms[0].r_dh.value;//单号
lid=document.forms[0].labid.value;//仓库号
number=document.forms[0].rk_number.value;//入库数量
rk_price=document.forms[0].rk_price.value;//入库的进价
bank=document.forms[0].bank.value;//入库银行
if(pid==''){
alert('请选择要入库的产品!');
return false;
}
if(number=='' || (!isInteger(number)) || number<=0){
alert('请确保输入了正确的入库数量');
return false;
}
url="current_order.php?pid="+pid+"&did="+did+"&lid="+lid+"&num="+number+"&rk_price="+rk_price+"&bank="+bank;
var obj=window.frames["current_order"];
 //alert(url);
 obj.window.location=url;
}

function showsubinfo(tbnum){
whichEl = eval("rk_subinfo" + tbnum);
if (whichEl.style.display == "none"){eval("rk_subinfo" + tbnum + ".style.display=\"\";");}
else{eval("rk_subinfo" + tbnum + ".style.display=\"none\";");}
}
</script>
<script language="javascript">
function check(e){
var e = window.event ? window.event : e;
    if(e.keyCode == 13){
        thistm=document.forms[0].tm.value;
        window.location.href='system_rk.php?thistm='+thistm;
	return false;
    }
}
function checkForm(){
document.forms[0].submit();
}
</script>
</head>
<?php
//入库单号设置
$rs=New Dedesql(falsh);
$query="select * from #@__reportrk";
$rs->SetQuery($query);
$rs->Execute();
$rowcount=$rs->GetTotalRow();
  $cdh="Vin".str_replace('-','',GetDateMk(date(time())))."-".($rowcount+1);
  //$cdh=GetDateMk(date(time()));
 $rs->close();
 
if ($action=='save'){//保存入库单及记录
 if($bank=='')ShowMsg("请选择入库银行，以方便记账操作！","-1");
$bsql=New Dedesql(false);
$query="select * from #@__kc where rdh='$r_dh'";
$bsql->SetQuery($query);
$bsql->Execute();
$rowcount=$bsql->GetTotalRow();
if ($rowcount==0){
 ShowMsg('非法参数或没有添加产品信息!','-1');
 exit();
}
else{
 //checkbank();检索默认银行，返回BANKID
 $money=0;
 while($row=$bsql->getArray()){
 $money+=$row['number']*$row['rk_price'];
 $csql=New dedesql(false);
 $csql->setquery("select * from #@__mainkc where p_id='".$row['productid']."' and l_id='".$row['labid']."'");
 $csql->execute();
 $totalrec=$csql->gettotalrow();
 if($totalrec==0)
  $rs=$csql->executenonequery("insert into #@__mainkc(p_id,l_id,d_id,number) values('".$row['productid']."','".$row['labid']."','0','".$row['number']."')");
  else
  $rs=$csql->executenonequery("update #@__mainkc set number=number+".$row['number']." where p_id='".$row['productid']."' and l_id='".$row['labid']."'");
 }
 if(!$rs){
 showmsg("发生错误:".$csql->getError(),"-1");
 exit();
 }
 $csql->close(); 
 $loginip=getip();
 $logindate=getdatetimemk(time());
 $username=GetCookie('VioomaUserID');
 WriteNote('入库单'.$r_dh.'成功保存',$logindate,$loginip,$username);
 $newsql=New dedesql(false);
 $newsql->executenonequery("insert into #@__reportrk(r_dh,r_people,r_date,r_status) values('$r_dh','$r_people','$r_date','0')");
 //写入财务记录
 $newsql->executenonequery("insert into #@__accounts(atype,amoney,abank,dtime,apeople,atext) values('支出','$money','$bank','$r_date','$r_people','进货支出金额，对应入库单号为：".$r_dh."')");
 //更新银行金额
 $newsql->executenonequery("update #@__bank set bank_money=bank_money-".$money." where id='$bank'");
 $newsql->close();
 ShowMsg('产品信息已写入库存表','system_rk.php');
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
      <td><strong>&nbsp;产品入库单管理</strong>&nbsp;&nbsp;- <a href="system_rk.php">新进货单</a> - <a href="importrk1.php">导入入库记录</a> | <a href="importrk2.php">导入入库详情</a></td>
     </tr>
     <tr>
      <td bgcolor="#FFFFFF">
<?php
$orderstring=" order by r_date desc";
       echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" id=\"table_border\">";
	   if(GetCookie('rank')==1)
	   $query="select * from #@__reportrk".$orderstring;
	   else
	   $query="select * from #@__reportrk where r_people='".GetCookie('VioomaUserID')."'".$orderstring;
   
       $csql=New Dedesql(false);
	   $dlist = new DataList();
       $dlist->pageSize = $cfg_record;
       $dlist->SetParameter("action",$action);//设置GET参数表
       $dlist->SetSource($query);
	   echo "<tr class='row_color_head'>
	   <td>ID</td>
	   <td>入库单号</td>
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
	   $printstring=" | <a href=report_rk.php?action=save&type=other&sday=".$row['r_dh'].">打印入库单</a>";
	   $workstring="";
	   }
	   else{
	    if(Getcookie('rank')=='1')
	   $statusstring="<a href='?action=sure&t=yes&id=".$row['id']."'><img src='images/no.png' alt='审核该单' border='0'></a>";
	    else
	   $statusstring="<img src='images/no.png' alt='审核该单' border='0'>";
	   $printstring="";
	   $workstring="<a href=''>编辑</a> | <a href=''>删除</a>";
	   }
	   echo "<tr>
	   <td><center>ID号:".$row['id']."</td>
	   <td><center>&nbsp;".$row['r_dh']."</td>
	   <td><center>&nbsp;".$row['r_people']."</td>
	   <td><center>&nbsp;".$row['r_date']."</td>
	   <td><center>&nbsp;".$statusstring."</td>
	   <td><center><span onclick=showsubinfo(".$row['id'].") style='cursor:hand;'>展开详情</span>".$printstring."</td>
	   </tr>";
	   echo "<tr id='rk_subinfo".$row['id']."' style='display:none;'><td colspan='6'><br><table width=\"98%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" id=\"table_border\" align=\"center\">";
	   
	   $csql1=New Dedesql(false);
	   $csql1->SetQuery("select * from #@__kc where rdh='".$row['r_dh']."'");
	   $csql1->Execute();
	   $rowcount=$csql1->GetTotalRow();
	   echo "<tr class='row1_color_head'>
	   <td><center>货号</td>
	   <td><center>名称</td>
	   <td><center>规格</td>
	   <td><center>分类</td>
	   <td><center>单位</td>
	   <td><center>进价</td>
	   <td><center>供应商</td>
	   <td><center>入库数量</td>
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
	   <td><center>￥".$row['rk_price']."</td>
	   <td><center>".$row1['cp_gys']."</td>
	   <td><center>".$row['number']."</td>
	   <td><center>￥".number_format($row['number']*$row['rk_price'],2,'.',',')."</td>
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
 $query="update #@__reportrk set r_status=1 where id='$id'";
 else
 $query="update #@__reportrk set r_status=0 where id='$id'";
 $susql->executenonequery($query);
 $susql->close();
 showmsg('单据审核状态已修改','system_rk.php?action=seek');
 }
 else{
?>
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
	<form action="system_rk.php?action=save" method="post" name="form1">
     <tr>
      <td><strong><strong>&nbsp;产品入库管理</strong>(注:橙色背景为必填选项)&nbsp;&nbsp;- <a href="system_rk.php">新入库单</a> - <a href="system_rk.php?action=seek">进货单查询</a></td>
     </tr>
     <tr>
      <td bgcolor="#FFFFFF">
       <table width="100%" border="0" cellspacing="0" cellpadding="0" id="table_border">
	    <tr>
	     <td class="cellcolor">入库银行:</td>
		 <td>&nbsp;
		 <?php
		 $sql_bank=New dedesql(false);
		 $query_bank="select * from #@__bank";
		 $sql_bank->setquery($query_bank);
		 $sql_bank->execute();
		 $bank_n=$sql_bank->gettotalrow();
		 if($bank_n==0)echo "没有银行列表，请<a href='bank.php'>添加</a>";
		 else{
		 echo "<select name='bank'><option value=''>请选择银行</option>";
		      while($row_bank=$sql_bank->getArray()){
			   if($row_bank['bank_default']=='1')
		         echo "<option value='".$row_bank['id']."' selected>".$row_bank['bank_name']."</option>";
				 else
				 echo "<option value='".$row_bank['id']."'>".$row_bank['bank_name']."</option>";
		      }
		     }
			 $sql_bank->close();
			 echo "</select>";
		 ?>&nbsp;为能正确记账，请选择正确的银行。
		 </td>
	    </tr>
        <tr height="30">
         <td class="cellcolor">入库单号:</td>
         <td class="cellcolor">
		 &nbsp;<input type="text" name="r_dh" value="<?php echo $cdh; ?>" readonly class="rtext" size="15">
		 &nbsp;(操作员:<input type="text" name="r_people" value="<?php echo Getcookie('VioomaUserID'); ?>" readonly class="rtext" size="8">
		 创建时间:<input type="text" name="r_date" value="<?php echo GetDateTimeMk(time());?>"  readonly class="rtext">)</td>
        </tr>
        <tr>
         <td class="cellcolor" width="30%">产品检索信息:<br></td>
         <td>&nbsp;<input type="text" name="tm" value="" onkeydown="check(event);"">&nbsp;<img src="images/03.gif" border="0" style="cursor:hand;" alt="单击浏览更多产品信息" onclick="getinfo()"> 
	<input type="text" name="seek_text" value="" readonly class="rtext" size="15" Tabindex="1">(支持扫描枪)
	      <input type="hidden" name="seek_number" value=""/>
	     </td>
        </tr> 
        <tr>
         <td class="cellcolor" width="30%">所在仓库:<br></td>
         <td>&nbsp;<?php getlab() ?>
    	 </td>
  </tr> 
  <tr>
    <td class="cellcolor" width="30%">入库数量:<br></td>
    <td>&nbsp;<input type="text" name="rk_number" size="5">&nbsp;<input type="text" class="rtext" name="showdw" readonly size="5">
	</td>
  </tr>   
  <tr>
   <td class="cellcolor" width="30%">进货价格:</td>
   <td>&nbsp;<input type="text" name="rk_price" size="5" />&nbsp;元
  </tr>
  <tr id="product_date" style="display:block;">
   <td colspan="2">
   &nbsp;所检索产品基本信息:<input type="text" class="rtext" style="width:80%;" name="showinfo" readonly>
   </td>
  </tr> 
  <tr>
    <td class="cellcolor">&nbsp;</td>
    <td>&nbsp;<input type="button" value=" 登记到此单 " onclick="putrkinfo()">&nbsp;&nbsp;<input type="button" value="保存此单入库记录" onclick="checkForm()"></td>
  </tr></form>
  <tr>
   <td colspan="2">
   <iframe src="current_order.php?pid=&did=<?php echo $cdh ?>&action=normal" width="100%" height="400" scrolling="auto" frameborder="0" marginheight="0" marginwidth="0" name="current_order" od="current_order"></iframe>
   </td>
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
if($thistm!=''){//扫描枪输入
	echo $thistm;
	$checksql=new Dedesql(false);
	$checkquery="select * from #@__basic where cp_tm='$thistm'";
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
		document.forms[0].showdw.value="<?php echo get_name($row['cp_dwname'],'dw')?>";
		document.forms[0].rk_price.value="<?php echo $row['cp_jj']?>";
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
