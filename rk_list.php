<?php
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/config_rglobals.php");
require(dirname(__FILE__)."/include/page.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link href="style/main.css" rel="stylesheet" type="text/css" />
<title><?php echo $cfg_softname;?>选择产品</title>
<script language="javascript">
function selectpro(value,id,gg,dw,price){
window.opener.document.<?php echo $form ?>.<?php echo $field ?>.value=value; 
window.opener.document.<?php echo $form ?>.seek_number.value=id; 
window.opener.document.<?php echo $form ?>.showinfo.value="产品名称："+value+"  规格："+gg; 
window.opener.document.<?php echo $form ?>.showdw.value=dw; 
window.opener.document.<?php echo $form ?>.rk_price.value=price;
window.close(); 
return false; 
}
</script>
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
    document.form1.cp_categories_down.options[0] = new Option('选择子分类',''); 
    for (i=0;i < onecount; i++) 
    { 
        if (subcat[i][1] == locationid) 
        { 
        document.form1.cp_categories_down.options[document.form1.cp_categories_down.length] = new Option(subcat[i][0], subcat[i][2]);
        } 
    } 
  window.location.href="rk_list.php?form=<?php echo $form;?>&field=<?php echo $field;?>&cp_categories="+locationid;
} 

function chgurl(cid){
cp_cate=document.forms[0].cp_categories.value;
if(cp_cate=='')
window.location.href="rk_list.php?form=<?php echo $form;?>&field=<?php echo $field;?>&cp_categories=&cp_categories_down="+cid;
else
window.location.href="rk_list.php?form=<?php echo $form;?>&field=<?php echo $field;?>&cp_categories="+cp_cate+"&cp_categories_down="+cid;
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
      <td>
	   <table width="100%" border="0" cellspacing="0">
	    <tr><form action="rk_list.php?action=seek&form=<?php echo $form; ?>&field=<?php echo $field; ?>" name="form1" method="post">
		 <td>
	  <strong>&nbsp;选择你要的产品</strong>
	     </td>
		 <td align="right">所在分类：
		 <?php
		 getcategories($cp_categories,$cp_categories_down," onchange=chgurl(this.value)");
	     ?>
		 <select name="sort">
		 <option value="1" <?php if ($sort==1)echo "selected"?>>按货号查询</option>
		 <option value="2" <?php if ($sort==2)echo "selected"?>>按条码查询</option>
		 <option value="3" <?php if ($sort==3)echo "selected"?>>按名称查询</option>
		 <option value="4" <?php if ($sort==4)echo "selected"?>>按助记词查询</option>
		 </select>
		 <input type="text" name="stext" size="15" value="<?php echo $stext; ?>"><input type="submit" value="开始检索">
		 &nbsp;&nbsp;
		 </td>
		</tr></form>
	   </table>
	  </td>
     </tr>
	 <form method="post" name="sel">
     <tr>
      <td bgcolor="#FFFFFF">
       <?php
       echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" id=\"table_border\">";
	   if($cp_categories=='')$catestring1='';
	   else
	   $catestring1=" and #@__basic.cp_categories='$cp_categories'";
	   if($cp_categories_down=='')$catestring2='';
	   else
	   $catestring2=" and #@__basic.cp_categories_down='$cp_categories_down'";
	   $catestring=$catestring1.$catestring2;
	   if($action=='seek'){
	   switch($sort){
	    case "1"://按货号
		$query="select * from #@__basic where cp_number LIKE  '%".$stext."%'".$catestring." order by id desc";
		break;
		case "2"://按条码
		$query="select * from #@__basic where cp_tm='$stext'".$catestring." order by id desc";
		break;
		case "3"://按名称
		$query="select * from #@__basic where cp_name LIKE '%".$stext."%'".$catestring." order by id desc";
		break;
		case "4"://按肋记词
		$query="select * from #@__basic where cp_helpword LIKE '%".$stext."%'".$catestring." order by id desc";
		break;
		}
	   }
	   else
       $query="select * from #@__basic where id>0".$catestring." order by id desc";
$csql=New Dedesql(false);
$dlist = new DataList();
$dlist->pageSize = $cfg_record;
$dlist->SetParameter("form",$form);
$dlist->SetParameter("field",$field);//设置GET参数表
$dlist->SetParameter("cp_categories",$cp_categories);
$dlist->SetParameter("cp_categories_down",$cp_categories_down);
if($action=='seek'){
$dlist->SetParameter("action",$action);
$dlist->SetParameter("sort",$sort);
$dlist->SetParameter("stext",$stext);
}
$dlist->SetSource($query);
	   echo "<tr class='row_color_head'>
	   <td>货号</td>
	   <td>名称</td>
	   <td>规格</td>
	   <td>分类</td>
	   <td>单位</td>
	   <td>供应商</td>
	   <td>助记词</td>
	   <td>选择</td>
	   </tr>";
	   $mylist = $dlist->GetDataList();
       while($row = $mylist->GetArray('dm')){
	   echo "<tr onMouseMove=\"javascript:this.bgColor='#EBF1F6';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">\r\n
	   <td><center>".$row['cp_number']."</td>
	   <td><center>".$row['cp_name']."</td>
	   <td><center>".$row['cp_gg']."</td>
	   <td><center>".get_name($row['cp_categories'],'categories').">".get_name($row['cp_categories_down'],'categories')."</td>
	   <td><center>".get_name($row['cp_dwname'],'dw')."</td>
	   <td><center>".$row['cp_gys']."</td>
	   <td><center>".$row['cp_helpword']."</td>
	   <td><center><input type='checkbox' name='sel_pro".$row['id']."' value='".$row['cp_name']."' onclick=\"selectpro(this.value,".$row['cp_number'].",'".$row['cp_gg']."','".get_name($row['cp_dwname'],'dw')."','".$row['cp_jj']."')\"></td>\r\n
	   </tr>";
	   }
	   echo "<tr><td colspan='8'>&nbsp;".$dlist->GetPageList($cfg_record)."</td></tr>";
	   echo "</table>";
	   $csql->close();
	   ?>
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
</body>
</html>
