<?php
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/config_rglobals.php");
require_once(dirname(__FILE__)."/include/checklogin.php");
if($id=='')
ShowMsg('非法参数，请正确执行此文件。','-1');
if($action=='save'){
 if($groupname=='') {
 showmsg('请输入客户分组名称','-1');
 exit();
 }
 if(!is_numeric($sub) || $sub=='' || $sub>10 || $sub<1){
  showmsg('折扣只能是1到10之间的数,包括小数','-1');
 exit();
 }
 $addsql="update #@__group set groupname='$groupname',sub='$sub',groupmem='$groupname',staffid='$staff' where id='$id'";
 $message= "修改客户分组".$groupname."成功";
 $loginip=getip();
 $logindate=getdatetimemk(time());
 $username=str_replace($cfg_cookie_encode,'',$_COOKIE["VioomaUserID"]);
 $asql=New Dedesql(false);
 $asql->ExecuteNoneQuery($addsql);
 WriteNote($message,$logindate,$loginip,$username);
 $asql->close();
 showmsg('成功修改客户分组资料','guest_group.php');
 exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link href="style/main.css" rel="stylesheet" type="text/css" />
<title><?php echo $cfg_softname;?>计量单位管理</title>
</head>
<body>
<?php
$esql=New Dedesql(false);
$query="select * from #@__group where id='$id'";
$esql->SetQuery($query);
$esql->Execute();
if($esql->GetTotalRow()==0){
ShowMsg('非法调用参数,请重试','-1');
exit();
}
$row=$esql->GetOne($query);
$esql->close();
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
     <tr>
      <td><strong>&nbsp;客户分组修改</strong></td>
     </tr>
     <tr>
      <td bgcolor="#FFFFFF"><form action="group_edit.php?action=save" method="post">
       <table width="100%" cellspacing="0" cellpadding="0" border="0" id="table_border">
	    <tr>
		 <td id="row_style" width="25%">&nbsp;客户分组名称:<br>(可按地理位置、客户性质等进行分组)</td>
		 <td>
		 &nbsp;<input type="text" name="groupname" size="20" value="<?php echo $row['groupname'] ?>">
		 <input type="hidden" name="id" value="<?php echo $id; ?>">
		 </td>
	    </tr>
		<tr>
		 <td id="row_style">&nbsp;此分组可享受折扣:</td>
		 <td>
		 &nbsp;<input type="text" name="sub" size="2" value="<?php echo $row['sub'] ?>"> 折</td>
	    </tr>
		<tr>
		 <td id="row_style">
		 &nbsp;客户分组说明：
		 </td>
		 <td>&nbsp;<textarea cols="40" rows="3" name="groupmem"><?php echo $row['groupmem'];?></textarea>
		</tr>
		<tr>
		 <td id="row_style">
		 &nbsp;此分组负责人：
		 </td>
		 <td>
		 &nbsp;<?php echo getstaff($row['staffid'],'')?>
		 </td>
		</tr>
		<tr>
		 <td id="row_style">&nbsp;</td>
		 <td>&nbsp;<input type="submit" name="submit" value=" 修改客户分组 "></td>
	    </tr>
	   </table></form>
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
copyright();
?>
</body>
</html>
