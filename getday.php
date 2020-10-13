<html> 
<head> 
<title>Date</title> 
<style type=text/css> 
<!-- 
body,td {
      margin-left:0;
	  margin-top:0;
	  font-size:12px;
}
a:link {color:#000000;text-decoration: none} 
a:visited {color:#000000;text-decoration: none} 
a:active {color:#000000;text-decoration: none} 
a:hover { color:#ff3333;text-decoration: none} 
--> 
</style> 
<Script Language="JavaScript"> 
function getDay(v){ 
window.opener.document.<?php echo $_GET['form']; ?>.<?php echo $_GET['field']; ?>.value=v; 
window.close(); 
return false; 
} 
</Script> 
</head> 
<body bgcolor=#ffffff onBlur="window.focus()"> 
<?php 
$oldDate=$_GET[['oldDate'];
if (!isDate($oldDate)) $oldDate=getdate(); 
yy=year(cdate(oldDate)) 
mm=month(cdate(oldDate)) 
if request("yy")<>"" then yy=request("yy") 
if request("mm")<>"" then mm=request("mm") 
if yy="" then yy=year(date) 
if mm="" then mm=month(date) 
if mm>12 then mm=1:yy=yy+1 
if mm<1 then mm=12:yy=yy-1 

dim m(12) 
m(1)=31 
m(3)=31 
m(5)=31 
m(7)=31 
m(8)=31 
m(10)=31 
m(12)=31 
m(2)=28 
m(4)=30 
m(6)=30 
m(9)=30 
m(11)=30 
if (yy mod 4=0 and yy mod 100<>0) or yy mod 400=0 then m(2)=29 
mms=m(mm) 
week1=(weekday(cdate(yy & "-" & mm & "-1"))-1) 
 ?> 
<table width=250 cellspacing=1 cellpadding=0 bgcolor=#FFDFDF align=center> 
<tr> 
<td colspan=7 align=center> 
<table width=100% height=20 cellspacing=0 cellpadding=0> 
<tr height=20> 
<td width=30 align=center> 
<a href=getday.php?form=<?php echorequest("form") ?>&field=<?php echo $_GET['form']; ?>&yy=<?php echo (yy-1) ?>&mm=<?php echo mm ?>> 
<font face=webdings style=color:#000000 title="上一年">7</font> 
</a> 
<td width=30 align=center> 
<a href=getday.php?form=<?php echorequest("form") ?>&field=<?php echo $_GET['form']; ?>&mm=<?php echo (mm-1)?>&yy=<?php echo yy ?>> 
<font face=webdings style=color:#000000 title="上一月">3</font> 
</a> 
<td width=130 align=center style="FONT:9pt Verdana,Geneva,sans-serif;color:#CD0101"> 
<b><?php echoyy ?> 年 &nbsp; <?php echomm ?> 月</b> 
<td width=30 align=center> 
<a href=getday.php?form=<?php echo $_GET['form']; ?>&field=<?php echo $_GET['field']; ?>&mm=<?php echo (mm+1)?>&yy=<?php echo yy ?>> 
<font face=webdings style=color:#000000 title="下一月">4</font> 
</a> 
<td width=30 align=center> 
<a href=getday.php?form=<?php echo $_GET['form']; ?>&field=<?php echo $_GET['field']; ?>&yy=<?php echo (yy+1)?>&mm=<?php echo mm ?>> 
<font face=webdings style=color:#000000 title="下一年">8</font> 
</a> 
</table> 
<tr bgcolor=#ffffff height=20> 
<td width=35 align=center bgcolor=#FFF4F4 style="color:#ff6633;">日 
<td width=35 align=center bgcolor=#FFF4F4>一 
<td width=35 align=center bgcolor=#FFF4F4>二 
<td width=35 align=center bgcolor=#FFF4F4>三 
<td width=35 align=center bgcolor=#FFF4F4>四 
<td width=35 align=center bgcolor=#FFF4F4>五 
<td width=35 align=center bgcolor=#FFF4F4>六 
<% 
if week1<>0 then 
response.write "<tr>" 
for i=1 to week1 
response.write "<td width=35 height=20 bgcolor=#ffffff>&nbsp;" 
next 
end if 
for i=1 to mms 
if (i+week1-1) mod 7=0 then response.write "<tr>" 
response.write "<td width=35 height=20 align=center bgcolor=#ffffff onmousemove=this.bgColor='#ececec' onmouseout=this.bgColor='#ffffff'>" 
if cdate(yy & "-" & mm & "-" & i)=date() then 
 ?> 
<input type=button value=<?php echoi ?> 
style="BORDER:#CD0101 1px groove;width:30;height:16;font-size:9pt;background-color:#FFD9D9;color:#CD0101" 
onclick="javascript:getDay('<?php echo yy ?>-<?php echo mm ?>-<?php echo i ?>');" title="<?php echo yy ?>年<?php echo mm ?>月<?php echo i ?>日（今天）"> 
<% 
else 
 ?> 
<input type=button value=<?php echo i ?> 
style="BORDER:#000000 1px groove;width:30;height:16;font-size:9pt;background-color:#ffffff;color:#000000" 
onclick="javascript:getDay('<?php echo yy ?>-<?php echo mm ?>-<?php echo i ?>');" title="<?php echo yy ?>年<?php echo mm ?>月<?php echo i ?>日"> 
<% 
end if 
next 
if (mms+week1) mod 7<>0 then 
for i=1 to (7-((mms+week1) mod 7)) 
response.write "<td width=35 height=20 bgcolor=#ffffff>&nbsp;" 
next 
end if 
 ?> 
</table>
</body> 
</html>