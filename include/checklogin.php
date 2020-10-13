<?php
require_once(dirname(__FILE__)."/config_base.php");
if (Getcookie("VioomaUserID")=='')
echo "<script language='javascript'>parent.window.location.href='login.php';</script>";
require_once(dirname(__FILE__)."/cryption.php");
require_once(dirname(__FILE__)."/a_code.php");
check_key(false);
?>