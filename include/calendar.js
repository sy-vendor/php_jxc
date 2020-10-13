/**//*
  ****************************************************
  功    能：时间选择控件
  说    明：
  ***************************************************
  */
  
 <!--
 var bMoveable=true;
 var strFrame;
 document.writeln('<iframe bgcolor="#000000" id=meizzDateLayer  frameborder=0 style="position: absolute;  width: 186; height: 247; z-index: 9998; display: none"></iframe>');
 strFrame='<style>';
 strFrame+='INPUT.button{BORDER-RIGHT: #B3C9E1 1px solid;BORDER-TOP: #B3C9E1 1px solid;BORDER-LEFT: #B3C9E1 1px solid;';
 strFrame+='BORDER-BOTTOM: #ff9900 1px solid;BACKGROUND-COLOR: #EDF2F8;font-family:宋体;}';
 strFrame+='TD{FONT-SIZE: 9pt;font-family:宋体;}';
 strFrame+='</style>';
 strFrame+='<scr'+'ipt>';
 strFrame+='var datelayerx,datelayery;';
 strFrame+='var bDrag;    ';
 strFrame+='function document.onmousemove()    ';
 strFrame+='{if(bDrag && window.event.button==1)';
 strFrame+='    {var DateLayer=parent.document.all.meizzDateLayer.style;';
 strFrame+='        DateLayer.posLeft += window.event.clientX-datelayerx;';
 strFrame+='        DateLayer.posTop += window.event.clientY-datelayery;}}';
 strFrame+='function DragStart()        ';
 strFrame+='{var DateLayer=parent.document.all.meizzDateLayer.style;';
 strFrame+='    datelayerx=window.event.clientX;';
 strFrame+='    datelayery=window.event.clientY;';
 strFrame+='    bDrag=true;}';
 strFrame+='function DragEnd(){        ';
 strFrame+='    bDrag=false;}';
 strFrame+='</scr'+'ipt>';
 strFrame+='<div style="z-index:9999;position: absolute; left:0; top:0;" onselectstart="return false"><span id=tmpSelectYearLayer  style="z-index: 9999;position: absolute;top: 3; left: 19;display: none"></span>';
 strFrame+='<span id=tmpSelectMonthLayer  style="z-index: 9999;position: absolute;top: 3; left: 78;display: none"></span>';
 strFrame+='<table style="FILTER:dropshadow(color=#EDEDF8,offx=3.3,offy=3.3,positive=1);" cellSpacing="0" cellPadding="0" width="100%" border="0"><tr><td>';
 strFrame+='<table border=1 cellspacing=0 cellpadding=0 width=182 height=160 bgColor="#FFFFFF" borderColorLight=#7197CA borderColorDark="#ffffff"  >';
 strFrame+='  <tr ><td width=182 height=23  bgcolor=#FFFFFF><table border=0 cellspacing=1 cellpadding=0 width=180  height=23>';
 strFrame+='      <tr align=center ><td width=16 align=center bgcolor=#B6CAE4 style="font-size:12px;cursor: hand;color: #ffffff" ';
 strFrame+='        onclick="parent.meizzPrevM()" title="向前翻 1 月" ><b >&lt;</b>';
 strFrame+='        </td><td width=60 align=center style="font-size:12px;cursor:hand;"  ';
 strFrame+='onmouseover="style.backgroundColor=\'#D7E1F0\'" onmouseout="style.backgroundColor=\'white\'" ';
 strFrame+='onclick="parent.tmpSelectYearInnerHTML(this.innerText.substring(0,4))" title="点击这里选择年份"><span  id=meizzYearHead></span></td>';
 strFrame+='<td width=48 align=center style="font-size:12px;cursor:hand;"  onmouseover="style.backgroundColor=\'#D7E1F0\'" ';
 strFrame+=' onmouseout="style.backgroundColor=\'white\'" onclick="parent.tmpSelectMonthInnerHTML(this.innerText.length==3?this.innerText.substring(0,1):this.innerText.substring(0,2))"';
 strFrame+='        title="点击这里选择月份"><span id=meizzMonthHead ></span></td>';
 strFrame+='        <td width=16 bgcolor=#B6CAE4 align=center style="font-size:12px;cursor: hand;color: #ffffff" ';
 strFrame+='         onclick="parent.meizzNextM()" title="向后翻 1 月" ><b >&gt;</b></td></tr>';
 strFrame+='    </table></td></tr>';
 strFrame+='  <tr ><td width=180 height=18 >';
 strFrame+='<table border=1 cellspacing=0 cellpadding=0 bgcolor=#618BC5 ' + (bMoveable? 'onmousedown="DragStart()" onmouseup="DragEnd()"':'');
 strFrame+=' BORDERCOLORLIGHT=#3677b1 bgcolor=#5168C8 BORDERCOLORDARK=#FFFFFF width="100%" height=25  style="cursor:' + (bMoveable ? 'move':'default') + '">';
 strFrame+='<tr  valign="middle" align="center"><td style="font-size:12px;color:#FFFFFF" ><b>日</b></td>';
 strFrame+='<td style="font-size:12px;color:#FFFFFF"  ><b>一</b></td><td style="font-size:12px;color:#FFFFFF" ><b>二</b></td>';
 strFrame+='<td style="font-size:12px;color:#FFFFFF" ><b>三</b></td><td style="font-size:12px;color:#FFFFFF" ><b>四</b></td>';
 strFrame+='<td style="font-size:12px;color:#FFFFFF"   ><b>五</b></td><td style="font-size:12px;color:#FFFFFF" ><b>六</b></td></tr>';
 strFrame+='</table></td></tr>';
 strFrame+='  <tr ><td width="100%" height=120 >';
 strFrame+='    <table border=1 cellspacing=2 cellpadding=0 borderColorDark=#ffffff bgColor=#FFFFFF borderColorLight=#83A4D1 width="100%" height=120 >'; var n=0; for (j=0;j<5;j++){ 
 strFrame+= ' <tr align=center >'; for (i=0;i<7;i++){
 strFrame+='<td width=25 height=25 id=meizzDay'+n+' style="font-size:12px"  onclick=parent.meizzDayClick(this.innerText,0)></td>';n++;}
 strFrame+='</tr>';}
 strFrame+='      <tr align=center >';for (i=35;i<39;i++)
 strFrame+='<td width=25 height=25 id=meizzDay'+i+' style="font-size:12px"  onclick="parent.meizzDayClick(this.innerText,0)"></td>';
 strFrame+='        <td colspan=3 align=right ><span onclick=parent.closeLayer() style="font-size:12px;cursor: hand"';
 strFrame+='          title="关闭时间选择"><u>关闭</u></span>&nbsp;</td></tr>';
 strFrame+='    </table></td></tr><tr ><td >';
 strFrame+='        <table border=0 cellspacing=1 cellpadding=0 width=100%  bgcolor=#FFFFFF>';
 strFrame+='          <tr ><td  align=left><input  type=button class=button style="cursor:hand" value="<<" title="向前翻 1 年" onclick="parent.meizzPrevY()" ';
 strFrame+='             onfocus="this.blur()" style="font-size: 12px; height: 20px"><input  class=button title="向前翻 1 月" type=button ';
 strFrame+='             value="< " style="cursor:hand" onclick="parent.meizzPrevM()" onfocus="this.blur()" style="font-size: 12px; height: 20px"></td><td ';
 strFrame+='              align=center><input  style="cursor:hand"  type=button class=button value="今日" onclick="parent.meizzToday()" ';
 strFrame+='             onfocus="this.blur()" title="当前日期" style="font-size: 12px; height: 20px; cursor:hand"></td><td ';

 strFrame+='              align=center><input  style="cursor:hand"  type=button class=button value="清空" onclick="parent.ClearDate()" ';
 strFrame+='             onfocus="this.blur()" title="清除日期" style="font-size: 12px; height: 20px; cursor:hand"></td><td ';
 
 strFrame+='              align=right><input  type=button class=button value=" >" style="cursor:hand" onclick="parent.meizzNextM()" ';
 strFrame+='             onfocus="this.blur()" title="向后翻 1 月" class=button style="font-size: 12px; height: 20px"><input ';
 strFrame+='              type=button class=button style="cursor:hand" value=">>" title="向后翻 1 年" onclick="parent.meizzNextY()"';
 strFrame+='             onfocus="this.blur()" style="font-size: 12px; height: 20px"></td>';
 strFrame+='</tr></table></td></tr></table></td></tr></table></div>';
 window.frames.meizzDateLayer.document.writeln(strFrame);
 window.frames.meizzDateLayer.document.close();
 var outObject;
 var outButton;
 var outDate="";
 var odatelayer=window.frames.meizzDateLayer.document.all;
 
 function setday(tt,obj){
     if (arguments.length >  2){alert("对不起！传入本控件的参数太多！");return;}
     if (arguments.length == 0){alert("对不起！您没有传回本控件任何参数！");return;}
     var dads  = document.all.meizzDateLayer.style;
     var th = tt;
     var ttop  = tt.offsetTop;     
     var thei  = tt.clientHeight;  
    var tleft = tt.offsetLeft;    
    var ttyp  = tt.type;          
    while (tt = tt.offsetParent){ttop+=tt.offsetTop; tleft+=tt.offsetLeft;}
    dads.top  = (ttyp=="image")? ttop+thei : ttop+thei+6;
    dads.left = tleft;
    outObject = (arguments.length == 1) ? th : obj;
    outButton = (arguments.length == 1) ? null : th;    
    var reg = /^(\d+)-(\d{1,2})-(\d{1,2})$/; 
    var r = outObject.value.match(reg); 
    if(r!=null){
        r[2]=r[2]-1; 
        var d= new Date(r[1], r[2],r[3]); 
        if(d.getFullYear()==r[1] && d.getMonth()==r[2] && d.getDate()==r[3]){
            outDate=d;
        }
        else outDate="";
            meizzSetDay(r[1],r[2]+1);
    }
    else{
        outDate="";
        meizzSetDay(new Date().getFullYear(), new Date().getMonth() + 1);
    }
    dads.display = '';
    event.returnValue=false;
}
var MonHead = new Array(12);
    MonHead[0] = 31; MonHead[1] = 28; MonHead[2] = 31; MonHead[3] = 30; MonHead[4]  = 31; MonHead[5]  = 30;
    MonHead[6] = 31; MonHead[7] = 31; MonHead[8] = 30; MonHead[9] = 31; MonHead[10] = 30; MonHead[11] = 31;
var meizzTheYear=new Date().getFullYear(); 
var meizzTheMonth=new Date().getMonth()+1; 
var meizzWDay=new Array(39);

//判断是否隐藏显示出来的时间显示层
//function document.onclick()
//{ 
//    with(window.event)
 //   { 
 //       if (srcElement != outObject && srcElement != outButton)
 //           closeLayer();
 //   }
//}

document.onclick()=function() //任意点击时关闭该控件 //ie6的情况可以由下面的切换焦点处理代替
{ 
  with(window.event)
  { if (srcElement != outObject && srcElement != outButton)
    closeLayer();
  }
}


document.onkeyup() = function(){
    if (window.event.keyCode==27){
        if(outObject)outObject.blur();
        closeLayer();
    }
    else if(document.activeElement)
        if(document.activeElement != outObject && document.activeElement != outButton)
        {closeLayer();}
}
function meizzWriteHead(yy,mm){
    odatelayer.meizzYearHead.innerText  = yy + " 年";
    odatelayer.meizzMonthHead.innerText = mm + " 月";
}
function tmpSelectYearInnerHTML(strYear){
if (strYear.match(/\D/)!=null){alert("年份输入参数不是数字！");return;}
var m = (strYear) ? strYear : new Date().getFullYear();
if (m < 1000 || m > 9999) {alert("年份值不在 1000 到 9999 之间！");return;}
//年份选择起始
var n = m - 65;
if (n < 1000) n = 1000;
if (n + 71 > 9999) n = 9929;
var s = "&nbsp;&nbsp;&nbsp;    <select  name=tmpSelectYear style='font-size: 12px' "
    s += "onblur='document.all.tmpSelectYearLayer.style.display=\"none\"' "
    s += "onchange='document.all.tmpSelectYearLayer.style.display=\"none\";"
    s += "parent.meizzTheYear = this.value; parent.meizzSetDay(parent.meizzTheYear,parent.meizzTheMonth)'>\r\n";
var selectInnerHTML = s;
for (var i = n; i < n + 71; i++){
    if (i == m)
    {selectInnerHTML += "<option  value='" + i + "' selected>" + i + "年" + "</option>\r\n";}
    else {selectInnerHTML += "<option  value='" + i + "'>" + i + "年" + "</option>\r\n";}
}
selectInnerHTML += "</select>";
odatelayer.tmpSelectYearLayer.style.display="";
odatelayer.tmpSelectYearLayer.innerHTML = selectInnerHTML;
odatelayer.tmpSelectYear.focus();
}
function tmpSelectMonthInnerHTML(strMonth){
if (strMonth.match(/\D/)!=null){alert('月份输入参数不是数字！');return;} 
var m = (strMonth) ? strMonth : new Date().getMonth() + 1;
var s = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select  name=tmpSelectMonth style='font-size: 12px' "
    s += "onblur='document.all.tmpSelectMonthLayer.style.display=\"none\"' "
    s += "onchange='document.all.tmpSelectMonthLayer.style.display=\"none\";"
    s += "parent.meizzTheMonth = this.value; parent.meizzSetDay(parent.meizzTheYear,parent.meizzTheMonth)'>\r\n ";
var selectInnerHTML = s;
for (var i = 1; i < 13; i++){
    if (i == m)
    {selectInnerHTML += "<option  value='"+i+"' selected>"+i+"月"+"</option>\r\n";}
    else {selectInnerHTML += "<option  value='"+i+"'>"+i+"月"+"</option>\r\n";}
}
selectInnerHTML += "</select>";
odatelayer.tmpSelectMonthLayer.style.display="";
odatelayer.tmpSelectMonthLayer.innerHTML = selectInnerHTML;
odatelayer.tmpSelectMonth.focus();
}
function closeLayer(){
    document.all.meizzDateLayer.style.display="none";
}
function IsPinYear(year){
    if (0==year%4&&((year%100!=0)||(year%400==0))) return true;else return false;
}
function GetMonthCount(year,month){
    var c=MonHead[month-1];if((month==2)&&IsPinYear(year)) c++;return c;
}
function GetDOW(day,month,year){
    var dt=new Date(year,month-1,day).getDay()/7; return dt;
}
function meizzPrevY(){
    if(meizzTheYear > 999 && meizzTheYear <10000){meizzTheYear--;}
    else{alert("年份超出范围（1000-9999）！");}
    meizzSetDay(meizzTheYear,meizzTheMonth);
}
function meizzNextY(){
    if(meizzTheYear > 999 && meizzTheYear <10000){meizzTheYear++;}
    else{alert("年份超出范围（1000-9999）！");}
    meizzSetDay(meizzTheYear,meizzTheMonth);
}
function meizzToday(){
    var today;
    meizzTheYear = new Date().getFullYear();
    meizzTheMonth = new Date().getMonth()+1;
    today=new Date().getDate();
    if(outObject){
        outObject.value=meizzTheYear + "-" + meizzTheMonth + "-" + today;
    }
    closeLayer();
}

//added by wayne 050816
//ClearDate
function ClearDate(){
    if(outObject){
        outObject.value="";
    }
    closeLayer();
}

function meizzPrevM(){
    if(meizzTheMonth>1){meizzTheMonth--}else{meizzTheYear--;meizzTheMonth=12;}
    meizzSetDay(meizzTheYear,meizzTheMonth);
}
function meizzNextM(){
    if(meizzTheMonth==12){meizzTheYear++;meizzTheMonth=1}else{meizzTheMonth++}
    meizzSetDay(meizzTheYear,meizzTheMonth);
}
function meizzSetDay(yy,mm){
meizzWriteHead(yy,mm);
meizzTheYear=yy;
meizzTheMonth=mm;
for (var i = 0; i < 39; i++){meizzWDay[i]=""}; 
var day1 = 1,day2=1,firstday = new Date(yy,mm-1,1).getDay();
for (i=0;i<firstday;i++)meizzWDay[i]=GetMonthCount(mm==1?yy-1:yy,mm==1?12:mm-1)-firstday+i+1
for (i = firstday; day1 < GetMonthCount(yy,mm)+1; i++){meizzWDay[i]=day1;day1++;}
for (i=firstday+GetMonthCount(yy,mm);i<39;i++){meizzWDay[i]=day2;day2++}
for (i = 0; i < 39; i++)
{ var da = eval("odatelayer.meizzDay"+i)
    if (meizzWDay[i]!=""){ 
        da.borderColorLight="#76A0CF";
        da.borderColorDark="#76A0CF";
        if(i<firstday){
            da.innerHTML="<font style=' color: #B5C5D2;'>" + meizzWDay[i] + "</font>";
            da.title=(mm==1?12:mm-1) +"月" + meizzWDay[i] + "日";
            da.onclick=Function("meizzDayClick(this.innerText,-1)");
            if(!outDate)
                da.style.backgroundColor = ((mm==1?yy-1:yy) == new Date().getFullYear() && 
                   (mm==1?12:mm-1) == new Date().getMonth()+1 && meizzWDay[i] == new Date().getDate()) ?
                    "#E4E3F2":"#FFFFFF";
            else{
                da.style.backgroundColor =((mm==1?yy-1:yy)==outDate.getFullYear() && (mm==1?12:mm-1)== outDate.getMonth() + 1 && 
                meizzWDay[i]==outDate.getDate())? "#E8F5E7" : 
                (((mm==1?yy-1:yy) == new Date().getFullYear() && (mm==1?12:mm-1) == new Date().getMonth()+1 && 
                meizzWDay[i] == new Date().getDate()) ? "#E4E3F2":"#FFFFFF"); 
               if((mm==1?yy-1:yy)==outDate.getFullYear() && (mm==1?12:mm-1)== outDate.getMonth() + 1 && 
                meizzWDay[i]==outDate.getDate())
                {}
            }
        }
       else if (i>=firstday+GetMonthCount(yy,mm)){
           da.innerHTML="<font style=' color: #B5C5D2;'>" + meizzWDay[i] + "</font>";
            da.title=(mm==12?1:mm+1) +"月" + meizzWDay[i] + "日";
           da.onclick=Function("meizzDayClick(this.innerText,1)");
            if(!outDate)
                da.style.backgroundColor = ((mm==12?yy+1:yy) == new Date().getFullYear() && 
                   (mm==12?1:mm+1) == new Date().getMonth()+1 && meizzWDay[i] == new Date().getDate()) ?
                   "#E4E3F2":"#FFFFFF";
            else{
               da.style.backgroundColor =((mm==12?yy+1:yy)==outDate.getFullYear() && (mm==12?1:mm+1)== outDate.getMonth() + 1 && 
                meizzWDay[i]==outDate.getDate())? "#E8F5E7" : 
                (((mm==12?yy+1:yy) == new Date().getFullYear() && (mm==12?1:mm+1) == new Date().getMonth()+1 && 
                meizzWDay[i] == new Date().getDate()) ? "#E4E3F2":"#FFFFFF"); 
               if((mm==12?yy+1:yy)==outDate.getFullYear() && (mm==12?1:mm+1)== outDate.getMonth() + 1 && 
                meizzWDay[i]==outDate.getDate()){
                    da.borderColorLight="#E4E3F2";
                    da.borderColorDark="#E4E3F2";  
                }
            }
       }
        else{
            da.innerHTML="<font style=' color: #3E5468;'>" + meizzWDay[i] + "</FONT>";
            da.title=mm +"月" + meizzWDay[i] + "日";
            da.onclick=Function("meizzDayClick(this.innerText,0)");
           if(!outDate)
               da.style.backgroundColor = (yy == new Date().getFullYear() && mm == new Date().getMonth()+1 && meizzWDay[i] == new Date().getDate())?
                   "#FFFFFF":"#FFFFFF";
            else{
                da.style.backgroundColor =(yy==outDate.getFullYear() && mm== outDate.getMonth() + 1 && meizzWDay[i]==outDate.getDate())?
                    "#D5ECD2":((yy == new Date().getFullYear() && mm == new Date().getMonth()+1 && meizzWDay[i] == new Date().getDate())?
                    "#E4E3F2":"#F8F8FC"); 
            }
        }
        da.style.cursor="hand"
        da.onmouseover=Function("this.backgroundColor='#000000';this.borderColorDark='#000099';this.borderColorLight='#000099';");
        da.onmouseout=Function("this.bgColor='#000000';this.borderColorDark='#9CBADE';this.borderColorLight='#9CBADE';");
    }
    else{da.innerHTML="";da.style.backgroundColor="";da.style.cursor="default";da.onmouseover=Function("this.backgroundColor='#000000';this.borderColorDark='#000099';this.borderColorLight='#000099';");
        da.onmouseout=Function("this.bgColor='#000000';this.borderColorDark='#9CBADE';this.borderColorLight='#9CBADE';");}
}}
function meizzDayClick(n,ex){
var yy=meizzTheYear;
var mm = parseInt(meizzTheMonth)+ex;    
    if(mm<1){
        yy--;
        mm=12+mm;
    }
    else if(mm>12){
        yy++;
        mm=mm-12;
    }
if (mm < 10){mm = "0" + mm;}
if (outObject){
    if (!n) { 
    return;}
    if ( n < 10){n = "0" + n;}
    outObject.value= yy + "-" + mm + "-" + n ;
    closeLayer();
    outObject.onchange();
}
else {closeLayer(); alert("您所要输出的控件对象并不存在！");}
}
//-->