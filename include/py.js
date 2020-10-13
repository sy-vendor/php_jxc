var py=new Array(20319, 
20283, 
19775, 
19218, 
18710, 
18526, 
18239, 
17922, 
17922, 
17417, 
16474, 
16212, 
15640, 
15165, 
14922, 
14914, 
14630, 
14149, 
14090, 
13318, 
13318, 
13318, 
12838, 
12556, 
11847, 
11055,0); 
function getPinYin(index){ 
var i; 
if(index==0x1534) return 'y'; 
if(index>0x4F5F||index<0x2807) return ''; 
i=0;while(py[i]>=index)i++; 
if (i==9) i--; 
if(i==21 || i==22) i=20; 
return vbChr(96+i); 
} 

function pinyin(s){ 
var i,s2=''; 
for (i=0;i<s.length;i++)s2+=(getPinYin(0-vbAsc(s.charAt(i)))); 
document.forms[0].cp_helpword.value=s2;
//return s2; 
} 