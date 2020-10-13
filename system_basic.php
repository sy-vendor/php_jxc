<?php
require(dirname(__FILE__)."/include/config_base.php");
require(dirname(__FILE__)."/include/config_rglobals.php");
require_once(dirname(__FILE__)."/include/checklogin.php");
check_grant('system_basic.php',GetCookie('rank'));
if($action=='save')
{
$configfile = dirname(__FILE__)."/include/config_hand.php";
$configfile_bak = dirname(__FILE__)."/include/config_hand_bak.php";
if(!is_writeable($configfile)){
	echo "配置文件'{$configfile}'不支持写入，严禁修改系统配置参数！";
	exit();
}
$savesql = new DedeSql(false);
foreach($_POST as $k=>$v){
	if(preg_match("/^edit___/",$k)){
		$v = ${$k};

	}else continue;
	$k = preg_replace("/^edit___/","",$k);
		if(strlen($v) > 250){
			showmsg("$k 太长，不能超过250字节",'-1');
			exit;
		}
		$savesql->ExecuteNoneQuery("Update #@__config set `config_value`='$v' where `config_name`='$k' ");
		}
	$savesql->SetQuery("Select `config_name`,`config_value` From `#@__config` order by `id` asc");
  $savesql->Execute();
  if($savesql->GetTotalRow()<=0){
		$savesql->Close();
		ShowMsg("成功保存变量但从数据库读取所有数据时失败，无法更新配置文件！","javascript:;");
	  exit();
	}
  @copy($configfile,$configfile_bak);
	$fp = @fopen($configfile,'w');
	@flock($fp,3);
	@fwrite($fp,"<"."?php\r\n") or die("配置文件'{$configfile}'不支持写入，本次操作无效！<a href='system_basic.php'>返回</a>");
  while($row = $savesql->GetArray()){
  	$row['value'] = str_replace("'","\\'",$row['config_value']);
  	fwrite($fp,"\${$row['config_name']} = '".$row['config_value']."';\r\n");
  }
  fwrite($fp,"?>");
  fclose($fp);
    $message="成功修改了系统配置文件config_base.php";
	$logindate=getdatetimemk(time());;
	$loginip=getip();
	$username=str_replace($cfg_cookie_encode,'',$_COOKIE["VioomaUserID"]);
	$savesql->Close();
	WriteNote($message,$logindate,$loginip,$username);
	ShowMsg("成功更改系统配置！","system_basic.php");
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link href="style/main.css" rel="stylesheet" type="text/css" />
<title><?php echo $cfg_softname;?>系统设置</title>
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
      <td><strong>&nbsp;系统基本信息设置</strong></td>
     </tr><form action="system_basic.php?action=save" method="post">
     <tr>
      <td bgcolor="#FFFFFF">
       <table width="100%" cellspacing="0" cellpadding="0" border="0" id="table_border">
	    <tr>
	      <td class="cellcolor" width="50%">公司名称: </td>
	      <td>&nbsp;<input type="" name="edit___cfg_webname" value="<?php echo $cfg_webname;?>" size="50"/></td></tr>
		<tr>
	    <tr>
	      <td class="cellcolor">联系地址: </td>
	      <td>&nbsp;<input type="" name="edit___cfg_address" value="<?php echo $cfg_address;?>" size="50"/></td></tr>
		<tr>
	    <tr>
	      <td class="cellcolor">联系人姓名: </td>
	      <td>&nbsp;<input type="" name="edit___cfg_conact" value="<?php echo $cfg_conact;?>" size="20"/></td></tr>
		<tr>
	    <tr>
	      <td class="cellcolor">联系电话: </td>
	      <td>&nbsp;<input type="" name="edit___cfg_phone" value="<?php echo $cfg_phone;?>" size="20"/></td></tr>
		<tr>				
		  <td class="cellcolor">进销存根路径: <br>(也即进销存的URL,在安装时系统会自动获取.)</td>
		  <td>&nbsp;<input type="" name="edit___cfg_basehost" value="<?php echo $cfg_basehost;?>" size="50"/></td></tr>
		<tr>
		  <td class="cellcolor">进销存安装目录:<br>(如果是非子目录安装不需要理会) </td>
		  <td>&nbsp;<input type="" name="edit___cfg_cmspath" value="<?php echo $cfg_cmspath;?>" size="20"/></td></tr>
		<tr>
		  <td class="cellcolor">Cookie加密字符串: <br>(为保证安全,此系统Cookie进行了加密,请设定尽可能复杂的加密字符串)</td>
		  <td>&nbsp;<input type="" name="edit___cfg_cookie_encode" value="<?php echo $cfg_cookie_encode;?>" size="20"/></td></tr>
		<tr>
		  <td class="cellcolor">登陆保持时间(单位:小时): </td>
		  <td>&nbsp;<input type="" name="edit___cfg_keeptime" value="<?php echo $cfg_keeptime;?>" size="5"/>&nbsp;小时</td></tr>
		<tr>
		  <td class="cellcolor">是否启用会员等级: </td>
		  <td>
		  &nbsp;
		  <?php 
		  if($cfg_islevel==1) 
		  echo "<input type=\"radio\" name=\"edit___cfg_islevel\" checked value=\"1\">是&nbsp;<input type=\"radio\" name=\"edit___cfg_islevel\" value=\"0\">否" ;
		  else 
		  echo "<input type=\"radio\" name=\"edit___cfg_islevel\" value=\"1\">是&nbsp;<input checked type=\"radio\" name=\"edit___cfg_islevel\" value=\"0\">否";
		  ?></td></tr>
		<tr>
		  <td class="cellcolor">是否按会员等级进行预定打折销售: </td>
		  <td>
		  &nbsp;
		  <?php 
		  if($cfg_isdiscount==1) 
		  echo "<input type=\"radio\" name=\"edit___cfg_isdiscount\" checked value=\"1\">是&nbsp;<input type=\"radio\" name=\"edit___cfg_isdiscount\" value=\"0\">否" ;
		  else 
		  echo "<input type=\"radio\" name=\"edit___cfg_isdiscount\" value=\"1\">是&nbsp;<input checked type=\"radio\" name=\"edit___cfg_isdiscount\" value=\"0\">否";
		  ?></td></tr>
		<tr>
		  <td class="cellcolor">是否启用库存报警设置: </td>
		  <td>
		  &nbsp;
		  <?php 
		  if($cfg_isalarm==1) 
		  echo "<input type=\"radio\" name=\"edit___cfg_isalarm\" checked value=\"1\">是&nbsp;<input type=\"radio\" name=\"edit___cfg_isalarm\" value=\"0\">否" ;
		  else 
		  echo "<input type=\"radio\" name=\"edit___cfg_isalarm\" value=\"1\">是&nbsp;<input checked type=\"radio\" name=\"edit___cfg_isalarm\" value=\"0\">否";
		  ?></td></tr>
		<tr>
		<tr>
		  <td class="cellcolor">是否在打印报表时显示公司详细信息: </td>
		  <td>
		  &nbsp;
		  <?php 
		  if($cfg_isshow==1) 
		  echo "<input type=\"radio\" name=\"edit___cfg_isshow\" checked value=\"1\">是&nbsp;<input type=\"radio\" name=\"edit___cfg_isshow\" value=\"0\">否" ;
		  else 
		  echo "<input type=\"radio\" name=\"edit___cfg_isshow\" value=\"1\">是&nbsp;<input checked type=\"radio\" name=\"edit___cfg_isshow\" value=\"0\">否";
		  ?></td></tr>
		<tr>
		  <td class="cellcolor">是否启用员工业务提成功能: </td>
		  <td>
		  &nbsp;
		  <?php 
		  if($cfg_way==1) 
		  echo "<input type=\"radio\" name=\"edit___cfg_way\" checked value=\"1\">是&nbsp;<input type=\"radio\" name=\"edit___cfg_way\" value=\"0\">否" ;
		  else 
		  echo "<input type=\"radio\" name=\"edit___cfg_way\" value=\"1\">是&nbsp;<input checked type=\"radio\" name=\"edit___cfg_way\" value=\"0\">否";
		  ?></td></tr>		  
		<tr>		
		  <td class="cellcolor">显示多少条记录/页: </td>
		  <td>&nbsp;<input type="" name="edit___cfg_record" value="<?php echo $cfg_record;?>" size="5"/>&nbsp;条/页</td></tr>
		  <tr>		
		  <td class="cellcolor">数据备份目录: </td>
		  <td>&nbsp;<input type="" name="edit___cfg_backup_dir" value="<?php echo $cfg_backup_dir;?>" size="20"/>&nbsp;</td></tr>
		<tr><td>&nbsp;</td><td><input type="submit" value=" 保存设置 "></td></tr>
	   </table>
	  </td>
     </tr>
    </table>
	</td>
    <td>&nbsp;</td>
  </tr></form>
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
