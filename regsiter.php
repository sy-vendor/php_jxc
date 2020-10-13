<?php
require_once(dirname(__FILE__)."/include/config_base.php");
require_once(dirname(__FILE__)."/include/a_code.php");
require_once(dirname(__FILE__)."/include/cryption.php");
require(dirname(__FILE__)."/include/config_rglobals.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link href="style/main.css" rel="stylesheet" type="text/css" />
<title>WEB ERP SYSTEM REGISTER</title>
</head>
<body>
<?
function GetBackAlert($msg,$isstop=0)
{
	$msg = str_replace('"','`',$msg);
  if($isstop==1) $msg = "<script>\r\n<!--\r\n alert(\"{$msg}\");\r\n-->\r\n</script>\r\n";
  else $msg = "<script>\r\n<!--\r\n alert(\"{$msg}\");history.go(-1);\r\n-->\r\n</script>\r\n";
  $msg = "<meta http-equiv=content-type content='text/html; charset=utf8'>\r\n".$msg;
  return $msg;
}
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
	<table width="100%" border="0" cellpadding="8" cellspacing="1">
	<form action="regsiter.php?action=sure" method="post">
     <tr>
      <td>
       <b>WEB ERP SYSTEM REGISTER</b>
	  </td>
     </tr>
	 <tr bgcolor="#FFFFFF">
	  <td style="line-height:150%">
	  <?php
	  //授权操作存储过程
	  if ($action=='sure'){
	   $sql=new dedesql(false);
	   $query="select * from #@__boss";
	   $sql->SetQuery($query);
	   $row=$sql->GetOne();
	   if ($rkey!=$row['key']){
	   echo "<script language='javascript'>alert('你的注册码不符合标准，请确认!咨询QQ：2901558410');history.go(-1);</script>";
	   exit();
	   }
	   if($rfile==''){
	   echo "<script language='javascript'>alert('请输入授权文件的正确路径！');history.go(-1);</script>";
	   exit();
	   }
	   $errstring=GetBackAlert("读取或写入授权文件失败，请检查系统安装目录是否可读取或写入！");
	   $fp = fopen(dirname(__FILE__)."/".$rfile,"r") or die($errstring);
       $key_string1 = fread($fp,filesize($rfile));
       fclose($fp);
	   $aes = new AES(true);
	   $key = "this is a 32 byte key";
	   $keys = $aes->makeKey($key);
	   $key_string = $aes->decryptString($key_string1, $keys);//第一次解密
	   $password='userma';
	   $ct = new Crypto;//第二次解密
	   $strtoencrypt = $ct->decrypt ($password,$key_string);
	   $nowfilename=cn_substr($strtoencrypt,6,0);
	   $php_code_string="/*  注册说明:
WEB ERP SYSTEM 2019 适应中小企业及个体用户使用，功能实用，操作简单，是您自动管理“进、销及存”不可缺少的帮手，唯一官方网站：https://www.suyi1995.com 咨询QQ：2901558410，注册事项及系统定制等请联系我！ */
{}rkey='#request_code#'; //注册码
{}start_date='#date#'; //开始时间
{}end_faq='#faq#'; //试用天数
{}request_file='#keyfile#'; //授权文件
{}request_code='#code#'; //授权码
{}pay_body='#company_name#'; //授权用户
{}rnd_string='#r_name#';//私人密钥
/*  注册说明:
WEB ERP SYSTEM 2019 适应中小企业及个体用户使用，功能实用，操作简单，是您自动管理“进、销及存”不可缺少的帮手，唯一官方网站：https://www.suyi1995.com 咨询QQ：2901558410，，注册事项及系统定制等请联系我！ */";
        $php_code_string=str_replace('#request_code#',$rkey,$php_code_string);
		$php_code_string=str_replace('#date#',GetDateTimeMk(time()),$php_code_string);
		$php_code_string=str_replace('#faq#',15,$php_code_string);
		$php_code_string=str_replace('#keyfile#',$rfile,$php_code_string);
		$php_code_string=str_replace('#code#',$key_string,$php_code_string);
		$php_code_string=str_replace('#company_name#',$company,$php_code_string);
		$php_code_string=str_replace('#r_name#',$nowfilename,$php_code_string);
		$php_code_string=str_replace('{}','$',$php_code_string);
	   $fp1 = fopen(dirname(__FILE__)."/include/".$nowfilename.".php","w") or die($errstring);
  	   fwrite($fp1,"<?php\r\n".$php_code_string."\r\n?>");
	   fclose($fp1);
	   $sql1=new dedesql(false);
	   $query1="update #@__boss set code='$key_string'";
	   $sql1->setquery($query1);
	   $sql1->execute();
	   $sql1->close();
	   header("Location:regsiter.php");
	  }
	  ?>
	  &nbsp;&nbsp;<font color="red">注册说明:</font><br>
	  WEB ERP SYSTEM 2019 适应中小企业及个体用户使用，功能实用，操作简单，是您自动管理“进、销及存”不可缺少的帮手，唯一官方网站：<a href="https://www.suyi1995.com" target="_blank">https://www.suyi1995.com</a>&nbsp;咨询QQ：<a href="http://wpa.qq.com/msgrd?V=1&Uin=2901558410&Site=ioshenmue&M">2901558410</a>，注册事项及系统定制等请联系我！
	  </td>
	 </tr>
	 <?php
	 $sql=new dedesql(false);
	 $query="select * from #@__boss";
	 $sql->setquery($query);
	 $row=$sql->getone();
	 ?>
	 <tr>
	  <td bgcolor="#EFEFEF">
	  WEB ERP SYSTEM REGISTER CODE：<input type="text" name="rkey" size="20" value="<?php echo $row['key'];?>" onclick="this.select()" readonly>
	  </td>
	 </tr>
	 <?php
	   $password='userma';
	   $ct = new Crypto;//第二次解密
	   $strtoencrypt = $ct->decrypt ($password,$row['code']);
	   $filename=cn_substr($strtoencrypt,6,0);
	 if($row['key']==str_replace($filename."-",'',$strtoencrypt) && file_exists(dirname(__FILE__)."/include/".$filename.".php")){
	 require(dirname(__FILE__)."/include/".$filename.".php");
	  if($rkey==$row['key'] && $request_code==$row['code'])
	  $Flag=True;
	  else
	  $Flag=False;
	 }
	 else
	 $Flag=False;
	 
	 if($Flag){
	 ?>
	 <tr>
	  <td bgcolor="#FFFFFF">
	  授权码：<?php echo $request_code;?>
	  <br>私人密钥：<?php echo $rnd_string;?>
	  <br>授权时间：<?php echo $start_date;?>
	  <br>授权给：<?php echo $pay_body;?>
	  </td>
	 </tr>
	 <?php
	 }
	 else{
	 ?>
	 <tr>
	  <td bgcolor="#EFEFEF">
	  授权文件名：<input type="text" name="rfile" size="15">&nbsp;授权文件由官方产生的扩展名为.dat的文件，请至文件于服务器根目录！
	  </td>
	 </tr>
	 <tr>
	  <td bgcolor="#EFEFEF">
	  公司信息：<input type="text" name="company" size="30">&nbsp;贵公司名称及联系电话等
	  </td>
	 </tr>
	 <tr>
	  <td bgcolor="#FFFFFF">
	  <center><input type="submit" value="  立即注册成正式版  ">
	  </td>
	 </tr>
	 <?php
	 }
	 $sql->close();
	 ?>
	 </form>
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
