<?php
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/config_rglobals.php");
require_once(dirname(__FILE__)."/include/checklogin.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link href="style/main.css" rel="stylesheet" type="text/css" />
<title><?php echo $cfg_softname;?>选择会员</title>
<script language="javascript">
function selectgys(value,pay,id){
window.opener.document.<?php echo $form ?>.<?php echo $field ?>.value=value; 
if(document.sel("sel_"+id).checked)
window.opener.document.<?php echo $form ?>.payed.value=pay; 
else
window.opener.document.<?php echo $form ?>.payed.value=0; 
window.close(); 
return false; 
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
     <tr><form action="member_list.php?form=<?php echo $form?>&field=<?php echo $field;?>"  name="sel" method="post">
      <td><strong>&nbsp;选择你要的客户</strong></td>
	  <td align="right">
	  客户搜索：<input type="text" value="<?php echo ($helpw=='')?'输入名称或首字拼音':$helpw?>" onclick="this.value='';" name="helpw">&nbsp;<input type="submit" value="搜索">&nbsp;&nbsp;
	  </td>
     </tr>
     <tr>
      <td bgcolor="#FFFFFF" colspan="2">
       <?php
       echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" id=\"table_border\">";
       $csql=New Dedesql(false);
	   $csql->SetQuery("select * from #@__guest where g_name LIKE '%".$helpw."%' or g_helpword LIKE '%".$helpw."%'");
	   $csql->Execute();
	   $rowcount=$csql->GetTotalRow();
	   if($rowcount==0)
	   echo "<tr><td>&nbsp;没有会员,请先<a href=system_guest.php?action=new>添加会员</a>。</td></tr>";
	   else{
	   echo "<tr class='row_color_head'>
	   <td>ID</td>
	   <td>名称</td>
	   <td>预存</td>
	   <td>使用预存</td>
	   </tr>";
	   while($row=$csql->GetArray()){
	   echo "<tr ondblclick=\"selectgys('$row[g_name]',$row[g_pay],$row[id])\"><td><center>".$row['id']."</td>
	   <td><center>".$row['g_name']."</td>
	   <td><center>".$row['g_pay']."</td>
	   <td><center><input type='checkbox' name='sel_".$row['id']."' value='".$row['id']."'></td></tr>";
	   }
	   }
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
