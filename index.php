<title>WEB ERP SYSTEM-Powered By www.suyi1995.com</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<?PHP
	if(!file_exists("install/install.finish"))
	{
		echo "<b><div style=\"text-align:center;margin-top:150px;color:red;font-size:18px;\"> ERP SYSTEM未安装，请点击下面的链接安装...</div></b>";
		echo "<b><div style=\"text-align:center;margin-top:50px;color:red;font-size:18px;\"><a href=\"install\">点击我安装WEB ERP SYSTEM!</a></div></b>";
		echo "<div style=\"text-align:center;margin-top:320px;font-size:13px;\">本系统由：www.suyi1995.com <a href=\"https://www.suyi1995.com\">管理员</a> 倾情提供！。</div>";
	}
?>
<frameset rows="90,*,27" cols="*" frameborder="0" framespacing="0">
 <frame src="top.php" frameborder="0" noresize="noresize" scrolling="no"/>
 <frameset cols="180,*" frameborder="0">
  <frame src="menu.php" name="menu" noresize="noresize" frameborder="0" scrolling="no"/>
  <frame src="main.php" name="main" noresize="noresize" frameborder="0"/>
 </frameset>
 <frame src="footer.php" frameborder="0" noresize="noresize" scrolling="no" />
</frameset><noframes></noframes>