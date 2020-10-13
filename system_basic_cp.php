<?php
require(dirname(__FILE__)."/include/config_rglobals.php");
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/page.php");
require_once(dirname(__FILE__)."/include/checklogin.php");
check_grant('system_basic_cp.php',GetCookie('rank'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link href="style/main.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="include/calendar.js"></script>
<script language="javascript" src="include/py.js"></script>
<title>产品基本信息录入</title>
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
/*cp=document.forms[0].cp_categories.value;
cp_down=document.forms[0].cp_categories_down.value;*/
s=document.forms[0].sort.value;
st=document.forms[0].stext.value;
window.open('excel_basic.php?sort='+s+'&stext='+st,'','');
}

</script>
<script type="text/vbscript"> 
function vbChr(c) 
vbChr = chr(c) 
end function 

function vbAsc(n) 
vbAsc = asc(n) 
end function 

</script> 
</head>
<?php
if ($action=='save'){
 if($cp_name==''){ echo "<script language='javascript'>alert('请输入产品的名称!');history.go(-1)</script>";exit();}
 if($cp_gg=='') {echo "<script language='javascript'>alert('请输入产品的规格!');history.go(-1)</script>";exit();}
 if($cp_categories==''){ echo "<script language='javascript'>alert('请输入产品的分类!');history.go(-1)</script>";exit();}
 if($cp_categories_down==''){ echo "<script language='javascript'>alert('请输入产品的子分类!');history.go(-1)</script>";exit();}
 if($cp_dwname==''){ echo "<script language='javascript'>alert('请输入产品的基本单位!');history.go(-1)</script>";exit();}
 if($cp_jj=='' || $cp_sale==''){ echo "<script language='javascript'>alert('产品进价与建议零售价为必填项!');history.go(-1)</script>";exit();}
 if(!(is_numeric($cp_jj) && is_numeric($cp_sale) )){ echo "<script language='javascript'>alert('价格必须为数字!');history.go(-1)</script>";exit();}
 if($cp_jj>$cp_sale){ echo "<script language='javascript'>alert('零售价不能小于进价!');history.go(-1)</script>";exit();}
$bsql=New Dedesql(false);
$query="select * from #@__basic where cp_name='$cp_name' and cp_gg='$cp_gg'";
$bsql->SetQuery($query);
$bsql->Execute();
$rowcount=$bsql->GetTotalRow();
if ($rowcount>=1){
 ShowMsg('此产品名称和规格在数据库里已经存在,请检查或区分!','-1');
 exit();
}
else{
if($cp_saleall=='')$cp_saleall=$cp_sale;
if($cp_sale1=='')$cp_sale1=$cp_sale;
if($cp_sdate=='')$cp_sdate='0000-00-00';
if($cp_edate=='')$cp_edate='0000-00-00';
$addquery="insert into #@__basic(cp_number,cp_tm,cp_name,cp_gg,cp_categories,cp_categories_down,cp_dwname,cp_style,cp_jj,cp_sale,cp_saleall,cp_sale1,cp_sdate,cp_edate,cp_gys,cp_helpword,cp_bz) values('$cp_number','$cp_tm','$cp_name','$cp_gg','$cp_categories','$cp_categories_down','$cp_dwname','$cp_style','$cp_jj','$cp_sale','$cp_saleall','$cp_sale1','$cp_sdate','$cp_edate','$cp_gys','$cp_helpword','$cp_bz')";
$rs=$bsql->ExecuteNoneQuery($addquery);
if($rs)
ShowMsg('成功写入一条产品基本信息.','system_basic_cp.php');
else
ShowMsg('发生错误:'.$bsql->getError(),'-1');
 $loginip=getip();
 $logindate=getdatetimemk(time());
 $username=GetCookie('VioomaUserID');
 WriteNote('添加产品基本信息'.$cp_name.' 成功',$logindate,$loginip,$username);
$bsql->close();
exit();
    }
}
else if($action=='seek'){ //列表
?>
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
	<form action="system_basic_cp.php?action=seek&seek=yes" method="post" name="form1">
     <tr>
      <td><strong>&nbsp;产品基本信息管理</strong>(注:橙色背景为必填选项)&nbsp;&nbsp;- <a href="system_basic_cp.php">新产品登记</a> - <a href="system_basic_cp.php?action=seek">产品基本信息查询</a></td>
     </tr>
     <tr height="27">
	  <td align="right" bgcolor="#FFFFFF">
	  检索：
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
	 <tr>
      <td bgcolor="#FFFFFF">
<?php
echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" id=\"table_border\">";
if($seek=='yes'){
switch($sort){
 case "1":
 $query="select * from #@__basic where cp_number LIKE '%".$stext."%'";
 break;
 case "2":
 $query="select * from #@__basic where cp_tm = '$stext'";
 break;
 case "3":
 $query="select * from #@__basic where cp_name LIKE '%".$stext."%'";
 break;
 case "4":
 $query="select * from #@__basic where cp_helpword LIKE '%".$stext."%'";
 break;
}
}
else
$query="select * from #@__basic";
$csql=New Dedesql(false);
$dlist = new DataList();
$dlist->pageSize = $cfg_record;
$dlist->SetParameter("action",$action);
$dlist->SetParameter("seek",$seek);
$dlist->SetParameter("sort",$sort);
$dlist->SetParameter("stext",$stext);
//$dlist->SetParameter("field",$field);//设置GET参数表
$dlist->SetSource($query);
	   echo "<tr class='row_color_head'>
	   <td>ID</td>
	   <td>名称</td>
	   <td>规格</td>
	   <td>分类</td>
	   <td>单位</td>
	   <td>进价</td>
	   <td>供应商</td>
	   <td>类型</td>
	   <td>助记词</td>
	   <td>操作</td>
	   </tr>";
	   $mylist = $dlist->GetDataList();
       while($row = $mylist->GetArray('dm')){
	   if($row['cp_style']=='1')$pstyle='';
	   else
	   $pstyle="<font color=red>非销售</font>";
	   echo "<tr>
	   <td><center>ID号:".$row['id']."</td>
	   <td><center>&nbsp;".$row['cp_name']."</td>
	   <td><center>&nbsp;".$row['cp_gg']."</td>
	   <td><center>&nbsp;".get_name($row['cp_categories'],'categories').">".get_name($row['cp_categories_down'],'categories')."</td>
	   <td><center>&nbsp;".get_name($row['cp_dwname'],'dw')."</td>
	   <td><center>&nbsp;￥".$row['cp_jj']."</td>
	   <td>".$row['cp_gys']."</td>
	   <td><center>".$pstyle."</td>
	   <td><center>".$row['cp_helpword']."</td>
	   <td><a href=system_basic_edit.php?id=".$row['id'].">修改</a> | <a href=system_basic_del.php?id=".$row['id'].">删除</a></td>
	   </tr>";
	   }
	   echo "<tr><td colspan='8'>&nbsp;".$dlist->GetPageList($cfg_record)."</td></tr></table>";
	  
	   $csql->close();
   echo " </td></tr></table>
 </td></tr><tr>
    <td id=\"table_style\" class=\"l_b\">&nbsp;</td>
    <td>&nbsp;</td>
    <td id=\"table_style\" class=\"r_b\">&nbsp;</td>
  </tr>
</table>";
 }
 else{
?>
<script language="javascript">
function check(e){
var e = window.event ? window.event : e;
    if(e.keyCode == 13){
    document.forms[0].cp_name.focus();
	return false;
    }
}
function checkForm(){
document.forms[0].submit();
}
</script>
<body onload="form1.cp_tm.focus()">
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
      <td><strong>&nbsp;产品基本信息管理</strong>(注:橙色背景为必填选项)&nbsp;&nbsp;- <a href="system_basic_cp.php">新产品登记</a> - <a href="system_basic_cp.php?action=seek">产品基本信息查询</a></td>
     </tr>
     <tr>
      <td bgcolor="#FFFFFF">
 <table width="100%" border="0" cellspacing="0" cellpadding="0" id="table_border">
 <form action="system_basic_cp.php?action=save" method="post" name="form1">
   <tr>
    <td class="cellcolor">产品货号:</td>
    <td>&nbsp;<input type="text" name="cp_number" value="<?php echo GetMkTime(time()) ?>" style="color:red;"></td>
  </tr>
  <tr>
    <td class="cellcolor" width="30%">产品条形码:<br>(如有条码扫描仪可直接扫描)</td>
    <td>&nbsp;<input type="text" name="cp_tm" onkeydown="check(event);">&nbsp;如使用条形码,销售时可直接使用</td>
  </tr>  
  <tr>
    <td class="cellcolor" width="30%">产品名称:</td>
    <td>&nbsp;<input type="text" name="cp_name" id="need" onblur="pinyin(this.value)"></td>
  </tr>
  <tr>
    <td class="cellcolor">产品规格:</td>
    <td>&nbsp;<input type="text" name="cp_gg" id="need"></td>
  </tr>
  <tr>
    <td class="cellcolor">产品所属分类:</td>
    <td>&nbsp;
	<?php
    getcategories(0,'');
	?>	</td>
  </tr>
  <tr>
    <td class="cellcolor">单位:</td>
    <td>&nbsp;<?php getdw() ?></td>
  </tr>
  <tr>
   <td class="cellcolor">产品类型:</td>
   <td>&nbsp;<select name="cp_style"><option selected value="1">正常销售产品</option><option value="0">非销售产品</option></select>&nbsp;非销售产品将不会出现在销售列表中
   </td>
  </tr>
  <tr>
    <td class="cellcolor">进货价格:<br>(入库时可自行修改或输入)</td>
    <td>&nbsp;<input type="text" name="cp_jj" id="need"></td>
  </tr>
  <tr>
    <td class="cellcolor">建议零售价格:</td>
    <td>&nbsp;<input type="text" name="cp_sale" id="need"></td>
  </tr>
  <tr>
    <td class="cellcolor">建议批发价格:</td>
    <td>&nbsp;<input type="text" name="cp_saleall"></td>
  </tr>
  <tr>
   <td class="cellcolor">自定义价格:</td>
   <td>&nbsp;<input type="text" name="cp_sale1">
  </tr>
  <tr>
    <td class="cellcolor">生产日期:</td>
    <td>&nbsp;<input type="text" name="cp_sdate" onclick="setday(this)">
	&nbsp;单击输入框选择时间	</td>
  </tr>
  <tr>
    <td class="cellcolor">作废日期:</td>
    <td>&nbsp;<input type="text" name="cp_edate" onclick="setday(this)">&nbsp;单击输入框选择时间</td>
  </tr>
  <tr>
    <td class="cellcolor">供应商:</td>
    <td>&nbsp;<input type="text" name="cp_gys" readonly>&nbsp;<img src="images/up.gif" border="0" align="absmiddle" style="cursor:hand;" onclick="window.open('select_gys.php?form=form1&field=cp_gys','selected','directorys=no,toolbar=no,status=no,menubar=no,resizable=no,width=250,height=270,top=200,left=520,scrollbars=yes')" />点击选择供应商</td>
  </tr>

  <tr>
    <td class="cellcolor">助记词:</td>
    <td>&nbsp;<input type="text" name="cp_helpword">&nbsp;(用于快速搜寻产品用,如不输入则按拼间首字字母记录)</td>
  </tr>    
  <tr>
    <td class="cellcolor">备注:</td>
    <td>&nbsp;
      <textarea rows="5" cols="30" name="cp_bz"></textarea></td>
  </tr>
  <tr>
    <td class="cellcolor">&nbsp;</td>
    <td>&nbsp;<input type="button" value=" 登记新产品 " onclick="checkForm()"></td>
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
}
copyright();
?>
</body>
</html>
