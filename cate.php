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
<title><?php echo $cfg_softname;?>财务分类管理</title>
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
      <td><strong>&nbsp;财务分类管理</strong>&nbsp;&nbsp;<a href="cate.php?action=new">添加财务分类</a> | <a href="cate.php">查看分类列表</a></td>
     </tr>
	 <form action="cate.php?action=save" method="post">
     <tr>
      <td bgcolor="#FFFFFF">
              <table width="100%" cellspacing="0" cellpadding="0" border="0" id="table_border">
<tr class='row_color_head'>
<td>ID</td><td>名称</td><td>操作</td>
</tr>
<tr><td>ID号:1</td><td><img src=images/cate.gif align=absmiddle>&nbsp;收入</td><td>本系统不支持自定义财务分类</td></tr>
<tr><td>ID号:2</td><td><img src=images/cate.gif align=absmiddle>&nbsp;支出</td><td>&nbsp;</td></tr>
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
copyright();
?>
</body>
</html>
