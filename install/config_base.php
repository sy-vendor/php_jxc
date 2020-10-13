<?php 
/*************************************************
本文件的信息不建议用户自行更改，否则发生意外自行负责
**************************************************/
error_reporting(E_ALL || ~E_NOTICE);

define('VIOOMAINC',dirname(__FILE__));

$ckvs = Array('_GET','_POST','_COOKIE','_FILES');
$ckvs4 = Array('HTTP_GET_VARS','HTTP_POST_VARS','HTTP_COOKIE_VARS','HTTP_POST_FILES');

//PHP小于4.1版本的兼容性处理
$phpold = 0;
foreach($ckvs4 as $_k=>$_v){ 
	if(!@is_array(${$_v})) continue;
	if(!@is_array(${$ckvs[$_k]})){ 
		${$ckvs[$_k]} = ${$_v}; unset(${$_v}); $phpold=1;
	}
}
//全局安全检测
foreach($ckvs as $ckv){
   foreach($$ckv AS $_k => $_v){ 
      if(preg_match("/^(_|globals|cfg_)/i",$_k)) unset(${$ckv}[$_k]);
   }
}

//载入用户配置的系统变量
require_once(VIOOMAINC."/config_hand.php");

//php5.1版本以上时区设置
if(PHP_VERSION > '5.1') {
	$time51 = 'Etc/GMT'.($cfg_cli_time > 0 ? '+' : '-').abs($cfg_cli_time);
	function_exists('date_default_timezone_set') ? @date_default_timezone_set($time51) : '';
}


//Session保存路径
$sessSavePath = VIOOMAINC."/../data/sessions/";
if(is_writeable($sessSavePath) && is_readable($sessSavePath)){ session_save_path($sessSavePath); }

//数据库连接信息
$cfg_dbhost = '~dbhost~';
$cfg_dbname = '~dbname~';
$cfg_dbuser = '~dbuser~';
$cfg_dbpwd = '~dbpwd~';
$cfg_dbprefix = '~dbprefix~';
$cfg_db_language = '~db_language~';

//软件摘要信息，****请不要删除本项**** 否则系统无法正确接收系统漏洞或升级信息
//-----------------------------
$cfg_softname = "ERP SYSTEM";
$cfg_soft_enname = "SUYANG2019版";
$cfg_soft_devteam = "suyang";
$cfg_version = 'v2013';
$cfg_ver_lang = 'utf8'; //严禁手工修改此项

//引入数据库类和常用函数
require_once(VIOOMAINC.'/config_passport.php');
require_once(VIOOMAINC.'/config.php');
if(!$__ONLYCONFIG) include_once(VIOOMAINC.'/pub_db_mysql.php');
if(!$__ONLYDB) include_once(VIOOMAINC.'/inc_functions.php');
?>