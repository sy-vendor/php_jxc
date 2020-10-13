<?php
require(dirname(__FILE__)."/config_passport.php");
Function CopyRight(){
echo "<div id='copyright'>Powered By www.suyi1995.com &copy; 2019~2030</div>";
}

Function WriteNote($msg,$date,$ip,$user){
$nsql=New Dedesql();
$notesql="insert into #@__recordline(message,date,ip,userid) values('{$msg}','{$date}','{$ip}','$user')";
$nsql->ExecuteNoneQuery($notesql);
$nsql->close();
}

Function getcategories($id,$reid,$event){
	$dsql=New Dedesql(false);
	$query="select * from #@__categories where reid=0";
	$dsql->SetQuery($query);
	$dsql->Execute();
	$rowcount=$dsql->GetTotalRow();
	if ($rowcount==0) {
	echo "<a href='system_class.php?action=new'>请先添加产品分类</a>";}
	else{
	echo "<select name=\"cp_categories\" onchange=\"getCity(this.value)\"><option value=''>选择分类</option>";
	$i=1;
	while ($row=$dsql->GetArray()){
	if($reid==''){
    	if($i==1)$initid=$row['id'];}
	else
		$initid=$id;
	if ($id==$row['id'])
	echo "<option value='".$row['id']."' selected>".$row['categories']."</option>";
	else
	echo "<option value='".$row['id']."'>".$row['categories']."</option>";
	$i++;
	}
	$dsql->close();
	echo "</select>";
	//读取子分类
	 $esql=New Dedesql(false);
	 $esql->SetQuery("select * from #@__categories where reid='$initid'");
	 $esql->Execute();
	 echo " -> <select name=\"cp_categories_down\" $event><option value=''>选择子分类</option>";;
	 while ($row1=$esql->GetArray()){
	  if($row1['id']==$reid)
	  echo "<option value='".$row1['id']."' selected>".$row1['categories']."</option>";
	  else
	  echo "<option value='".$row1['id']."'>".$row1['categories']."</option>";
	 }
 	 echo "</select>";
	 $esql->close();
	}
}

function getlab($id){
$gsql=New Dedesql(false);
$query="select * from #@__lab";
$gsql->setquery($query);
$gsql->execute();
$rowcount=$gsql->gettotalrow();
if($rowcount==0)return "没有仓库,请添加";
else{
 echo "<select name='labid'>";
 while ($row=$gsql->getarray()){
 if($id==''){
  if($row['l_default'])
   echo "<option selected value='".$row['id']."'>".$row['l_name']."</option>";
   else
   echo "<option value='".$row['id']."'>".$row['l_name']."</option>";
   }
   else{
    if($id==$row['id'])
	echo "<option selected value='".$row['id']."'>".$row['l_name']."</option>";
    else
    echo "<option value='".$row['id']."'>".$row['l_name']."</option>";
   }
  }
   echo "</select>";
   }
  $gsql->close();
}

Function getdw($id){
	$dw=New Dedesql(false);
	$query1="select * from #@__dw";
	$dw->SetQuery($query1);
	$dw->Execute();
	$rowcount=$dw->GetTotalRow();
	if ($rowcount==0) 
	echo "<a href='system_dw.php?action=new'>请先添加产品基本计量单位</a>";
	else{
	echo "<select name=\"cp_dwname\">";
	while ($row1=$dw->GetArray()){
	if($id=='' || $row1['id']!=$id)
	echo "<option value='".$row1['id']."'>".$row1['dwname']."</option>";
	else
	echo "<option value='".$row1['id']."' selected>".$row1['dwname']."</option>";
	}
	echo "</select>";
	}
	$dw->close();
 }
 
 Function getgroup($id,$type=""){
	$dw=New Dedesql(false);
	$query1="select * from #@__group";
	$dw->SetQuery($query1);
	$dw->Execute();
	$rowcount=$dw->GetTotalRow();
	if ($rowcount==0) 
	echo "<a href='guest_group.php?action=new'>请先添加客户分组</a>";
	else{
	if($type!=''){
	$dw->setquery("select * from #@__group where id='$id'");
	$dw->execute();
	$row1=$dw->getone();
	return $row1['groupname'];}
	else{
	echo "<select name=\"g_group\">";
	while ($row1=$dw->GetArray()){
	if($id=='' || $row1['id']!=$id)
	echo "<option value='".$row1['id']."'>".$row1['groupname']."</option>";
	else
	echo "<option value='".$row1['id']."' selected>".$row1['groupname']."</option>";
	}
	echo "</select>";
	}
	}
	$dw->close();
 }
 
  Function getstaff($id,$type=""){
	$staff_sql=New Dedesql(false);
	$query1="select * from #@__staff";
	$staff_sql->SetQuery($query1);
	$staff_sql->Execute();
	$rowcount=$staff_sql->GetTotalRow();
	if ($rowcount==0) 
	echo "<a href='system_worker.php?action=new'>请先添加公司员工</a>";
	else{
	if($type!=''){
	$staff_sql->setquery("select * from #@__staff where id='$id'");
	$staff_sql->execute();
	$row1=$staff_sql->getone();
	return $row1['s_name'];}
	else{
	echo "<select name=\"staff\">";
	while ($row1=$staff_sql->GetArray()){
	if($id=='' || $row1['id']!=$id)
	echo "<option value='".$row1['id']."'>".$row1['s_name']."</option>";
	else
	echo "<option value='".$row1['id']."' selected>".$row1['s_name']."</option>";
	}
	echo "</select>";
	}
	}
	$staff_sql->close();
 }
 
 Function get_name($id,$type){
 $getrs=New Dedesql(falsh);
 switch($type){
 case "dw":
 $query="select dwname from #@__dw where id='$id'";
 $getrs->Setquery($query);
 $getrs->execute();
 $row=$getrs->GetOne();
 return $row['dwname'];
 break;
 case "categories":
 $query="select categories from #@__categories where id='$id'";
 $getrs->Setquery($query);
 $getrs->execute();
 $row=$getrs->GetOne();
 return $row['categories'];
 break;
 case "name":
 $query="select cp_name from #@__basic where cp_number='$id'";
 $getrs->Setquery($query);
 $getrs->execute();
 $row=$getrs->GetOne();
 return $row['cp_name'];
 break;
 case "gg":
 $query="select cp_gg from #@__basic where cp_number='$id'";
 $getrs->Setquery($query);
 $getrs->execute();
 $row=$getrs->GetOne();
 return $row['cp_gg'];
 break;
 case "gys":
 $query="select cp_gys from #@__basic where cp_number='$id'";
 $getrs->Setquery($query);
 $getrs->execute();
 $row=$getrs->GetOne();
 return $row['cp_gys'];
 break;
 case "dwname":
 $query="select cp_dwname from #@__basic where cp_number='$id'";
 $getrs->Setquery($query);
 $getrs->execute();
 $row=$getrs->GetOne();
 return $row['cp_dwname'];
 break;
 case "staff":
 $query="select s_name from #@__staff where id='$id'";
 $getrs->setquery($query);
 $getrs->execute();
 $row=$getrs->getone();
 return $row['s_name'];
 break;
 case "lab":
 $query="select l_name from #@__lab where id='$id'";
 $getrs->Setquery($query);
 $getrs->execute();
 $row=$getrs->GetOne();
 return $row['l_name'];
 break;
 case "bcate":
 $query="select cp_categories from #@__basic where cp_number='$id'";
 $getrs->Setquery($query);
 $getrs->execute();
 $row=$getrs->GetOne();
 return $row['cp_categories'];
 break;
 case "scate":
 $query="select cp_categories_down from #@__basic where cp_number='$id'";
 $getrs->Setquery($query);
 $getrs->execute();
 $row=$getrs->GetOne();
 return $row['cp_categories_down'];
 break;
 }
 $getrs->close();
 }
 
 Function getusertype($rank,$type=0){
	$dw=New Dedesql(false);
	if($rank=='')
	$query1="select distinct * from #@__usertype where rank!=1 order by rank";
	else{
	 if($type==0) //单项输出
	$query1="select distinct * from #@__usertype where rank='$rank'";
	 else
	$query1="select distinct * from #@__usertype where rank!=1";
	}
	$dw->SetQuery($query1);
	$dw->Execute();
	$rowcount=$dw->GetTotalRow();
	if ($rowcount==0) 
	echo "用户类型表为空,请重新安装系统";
	else{
	if($rank!=''){
	 if($type==1){
	echo "<select name=\"s_utype\">";
	while ($row1=$dw->GetArray()){
	 if($row1['rank']==$rank)
    echo "<option value='".$row1['rank']."' selected>".$row1['typename']."</option>";
	 else
	echo "<option value='".$row1['rank']."'>".$row1['typename']."</option>";
	}
	echo "</select>";
	 }
	 else{
	$rs=$dw->GetArray();
	return $rs['typename'];
	}
	}
	else	{
	echo "<select name=\"s_utype\">";
	while ($row1=$dw->GetArray()){
	echo "<option value='".$row1['rank']."'>".$row1['typename']."</option>";}
	echo "</select>";
	}
	}
	$dw->close();
 }
 
function getjj($id){
	$dsql=New Dedesql(false);
	$query="select * from #@__basic where cp_number='$id'";
	$dsql->SetQuery($query);
	$dsql->Execute();
	$rowcount=$dsql->GetTotalRow();
	if($rowcount>0){
	$row=$dsql->getone();
	return $row['cp_jj'];
	}
	$dsql->close();
}

function getsale($id){
	$s=New Dedesql(false);
	$query="select * from #@__basic where cp_number='$id'";
	$s->SetQuery($query);
	$s->Execute();
	$rowcount=$s->GetTotalRow();
	if($rowcount>0){
	$row=$s->getone();
	return $row['cp_sale'];
	}
	$s->close();
}

function getadid($id){
	$s=New Dedesql(false);
	$query="select * from #@__staff";
	$s->SetQuery($query);
	$s->Execute();
	$rowcount=$s->GetTotalRow();
	if ($rowcount==0) 
	echo "<a href='system_worker.php?action=new'>请先添加员工</a>";
	else{
	echo "<select name=\"staff\"><option value=''>=请选择业务员=</option>";
	while ($row1=$s->GetArray()){
	if($id=='' || $row1['id']!=$id)
	echo "<option value='".$row1['s_name']."'>".$row1['s_name']."</option>";
	else
	echo "<option value='".$row1['s_name']."' selected>".$row1['s_name']."</option>";
	}
	echo "</select>";
	}
	$s->close();
}

function checkbank(){
$banksql=new dedesql(false);
$banksql->SetQuery("select * from #@__bank where bank_default='1'");
$banksql->Execute();
$bankr=$banksql->gettotalrow();
if($bankr==0){
echo "<script language='javascript'>alert('没有默认的银行账户,请先添加!');history.go(-1);</script>";
exit();
}
else{
$brs=$banksql->getone();
define('BANKID',$brs['id']);
}
$banksql->close();
}

function getbank($id){
$banksql=new dedesql(false);
$banksql->SetQuery("select * from #@__bank where id='$id'");
$banksql->Execute();
$bankr=$banksql->gettotalrow();
if($bankr==1){
$rs=$banksql->getone();
return $rs['bank_name'];
}
else
return "<font color=red>已删除银行</font>";
$banksql->close();
}

function checkbossexist($bname){
$bsql=new dedesql(false);
$bsql->SetQuery("select * from #@__boss where boss='$bname'");
$bsql->Execute();
$br=$bsql->gettotalrow();
if($br==0){
$rs=$bsql->getone();
return true;
}
else
return false;
$bsql->close();
}

function getgyslist($gys,$type){
$getsql=new dedesql(false);
$getsql->setquery("select distinct cp_gys from #@__basic");
$getsql->execute();
 echo "<select name='gys'><option value=''>=请选择供应商=</option>";
while($row=$getsql->getArray()){
 if($type=='')//仅列表
 echo "<option value='".$row['cp_gys']."'>".$row['cp_gys']."</option>";
 else{
  if($gys==$row['cp_gys'])
  echo "<option value='".$row['cp_gys']."' selected>".$row['cp_gys']."</option>";
   else
  echo "<option value='".$row['cp_gys']."'>".$row['cp_gys']."</option>"; 
 }
 }
 echo "</select>";
 $getsql->close();
}

function Out_money($type,$dh,$member=''){
$sql=new dedesql(false);
switch($type){
 case 'sale':
 if($member=='')
$query="select * from #@__sale where rdh='$dh'";
 else
$query="select * from #@__sale where rdh='$dh' and member='$member'";
$sql->setquery($query);
$sql->execute();
while($rs=$sql->getArray()){
$money=$money+$rs['sale']*$rs['number'];
}
return $money;
break;
 case 'rk':
 if($member=='')
$query="select * from #@__kc,#@__basic where #@__kc.rdh='$dh' and #@__basic.cp_number=#@__kc.productid";
 else
$query="select * from #@__kc,#@__basic where #@__kc.rdh='$dh' and #@__basic.cp_number=#@__kc.productid and #@__basic.cp_gys='$member'";
$sql->setquery($query);
$sql->execute();
while($rs=$sql->getArray()){
$money=$money+$rs['rk_price']*$rs['number'];
}
return $money;
break;
}
$sql->close();
}

function check_grant($file,$rank){
$s=new dedesql(false);
$q="select * from #@__usertype where rank='$rank'";
$rs1=$s->getone($q);
$rankstring=$rs1['content'];
$q="select * from #@__menu where url='$file'";
$rs2=$s->getone($q);
$tmparray = explode($rankstring,$rs2['rank']);
if(count($tmparray)<=1){
showMsg("你的权限将不能操作此项，请联系管理员！",'-1');
exit();
}
$s->close();
}

function check_key($flag1=true){

}

function get__list($table,$formname,$id,$fieldid,$fieldname,$event){
	$sql=new dedesql(false);
	$query="select * from $table";
	$sql->setquery($query);
	$sql->execute();
	if($sql->gettotalrow()<1)
	echo "<select name='$formname'><optin value=''>请选择</option></select>";
	else{
		echo "<select name='$formname' ".$event."><option value=''>请选择</option>";
		while($row=$sql->getArray()){
			if($id==$row[$fieldid])
			echo "<option value='".$row[$fieldid]."' selected>".$row[$fieldname]."</option>";
			else
			echo "<option value='".$row[$fieldid]."'>".$row[$fieldname]."</option>";
		}
		echo "</select>";
	}
}

//获取通用ID号数据
function get__id($table,$id,$fieldid,$fieldname){
	$sql=new dedesql(false);
	$query="select * from $table where $fieldname='$id'";
	$sql->setquery($query);
	$sql->execute();
	if($sql->gettotalrow()<1)
	return 0;
	else{
	$row=$sql->getone();
	return $row[$fieldid];
	}
}

?>