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
<title>报表管理</title>
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
      <td><strong>&nbsp;报表管理</strong>&nbsp;&nbsp;<a href="report_rk.php">采购报表</a> | <a href="report_sale.php">销售报表</a> | <a href="report_b_gys.php">采购退货报表</a> | <a href="report_s_back.php">客户退货报表</a> | <a href="report_none.php">报废报表</a> | <a href="report_boss.php">业务员销售</a> | <a href="report_member.php">会员销售</a> | <a href="report_none.php">报损报表</a> | <a href="report_gys.php">供应商往来</a> | <a href="report_all.php">营业分析</a></td>
     </tr>
     <tr>
      <td bgcolor="#FFFFFF">
	  <br />
       <table width="100%" cellspacing="0" cellpadding="0" border="0">
	    <tr><td colspan="3" align="center"><a href="report_galob.php"><img src="images/report_8.gif" border="0" align="absmiddle"/></a></td></tr>
	    <tr>
		 <td align="right" width="35%">
		  <table height="100%" border="0">
		   <tr height="80"><td><a href="report_rk.php?type=day"><img src="images/report_1.gif" border="0" align="absmiddle"/></a></td></tr>
		   <tr height="80"><td><a href="report_b_gys.php?type=day"><img src="images/report_3.gif" border="0" align="absmiddle"/></a></td></tr>
		   <tr height="80"><td><a href="report_gys.php"><img src="images/report_5.gif" border="0" align="absmiddle"/></a></td></tr>
		  </table>
		 </td>
		 <td width="30%" align="center" style="background:url(images/bg.gif) no-repeat center"><a href="system_kc.php"><img src="images/database.gif" border="0" align="absmiddle"/></a></td>
		 <td width="35%">
		 <table height="100%">
		   <tr height="60"><td><a href="report_sale.php?type=day"><img src="images/report_2.gif" border="0" align="absmiddle"/></a></td></tr>
		   <tr height="60"><td><a href="report_s_back.php?type=day"><img src="images/report_4.gif" border="0" align="absmiddle"/></a></td></tr>
		   <tr height="60"><td><a href="report_member.php"><img src="images/report_6.gif" border="0" align="absmiddle"/></a></td></tr>
		   <tr height="60"><td><a href="report_boss.php"><img src="images/report_7.gif" border="0" align="absmiddle"/></a></td></tr>
		  </table>
		 </td>
	    </tr>
		 <tr><td colspan="3" align="center"><a href="report_none.php"><img src="images/report_9.gif" border="0" align="absmiddle"/></a></td></tr>
	   </table><br>
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
