<?php
require_once(dirname(__FILE__)."/include/config_base.php");
require_once(dirname(__FILE__)."/include/config_rglobals.php");
require_once(dirname(__FILE__)."/include/pub_db_mysql.php");
require_once(dirname(__FILE__)."/include/checklogin.php"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/2019/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<head>
<title>WEB ERP SYSTEM MENU</title>
<style type="text/css">
body {background-color:#3179bd;}
</style>
<link href="style/menu.css" rel="stylesheet" type="text/css" />
</head>
<script language="javascript">
function getObject(objectId) {
 if(document.getElementById && document.getElementById(objectId)) {
 // W3C DOM
 return document.getElementById(objectId);
 }
 else if (document.all && document.all(objectId)) {
 // MSIE 4 DOM
 return document.all(objectId);
 }
 else if (document.layers && document.layers[objectId]) {
 // NN 4 DOM.. note: this won't find nested layers
 return document.layers[objectId];
 }
 else {
 return false;
 }
}

function showHide(objname){
    var obj = getObject(objname);
    if(obj.style.display == "none"){
		obj.style.display = "block";
	}else{
		obj.style.display = "none";
	}
}
</script>
<base target="main">
<body>
<div class="menu">
<?php 

/**if($c=='')$c=1; */
$csql=new Dedesql(false);
$countSql = "SELECT COUNT(*) As num FROM #@__menu WHERE reid = 0";
$total=$csql->getOne($countSql);
$total = $total[0]['num'];
$csql->close();

$total<1 && ($total=1); 
$endmenus = "

";
for($c = 1; $c <= $total; $c ++) {
	
$iteminfo ="";

$msql=new Dedesql(false);
$query="select name from #@__menu where id='$c'";
$menuinfo=$msql->GetOne($query);
$menus="
<dl>
    <dt><a href='###' onclick=showHide('items".$c."') target='_self' class='top'>".$menuinfo['name']."</a></dt>
    <dd id='items".$c."' style='display:none;'>
			<ul>
~Item~
  			</ul>
		</dd>
	</dl>
";
$msql->Setquery("select * from #@__menu where reid='$c'");
$msql->Execute();
while($row=$msql->GetArray())
{
$s=new Dedesql(false);
$q="select * from #@__usertype where rank='".GetCookie('rank')."'";
$rs1=$s->getone($q);
$tmparray = explode($rs1['content'],$row['rank']);
if(count($tmparray)>1)
$iteminfo=$iteminfo."<li><a href='".$row['url']."' target='main'>".$row['name']."</a></li>";
$s->close();
}
$menus=str_replace("~Item~",$iteminfo,$menus);
echo $menus.$endmenus;
$msql->close();
}
?>
</div>
</body>
</html>