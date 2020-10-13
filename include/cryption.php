<?php 
$ralphabet = 

"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-"; 

$alphabet = $ralphabet . $ralphabet; 
class Crypto { 

function decrypt ($password,$strtodecrypt) { 
global $ralphabet; 
global $alphabet; 
for( $i=0; $i<strlen($password); $i++ ) { 
$cur_pswd_ltr = substr($password,$i,1); 
$pos_alpha_ary[] = substr(strstr($alphabet,$cur_pswd_ltr),0,strlen($ralphabet)); 
} 
$i=0; 
$n = 0; 
$nn = strlen($password); 
$c = strlen($strtodecrypt); 
while($i<$c) { 
$decrypted_string .= substr($ralphabet,strpos($pos_alpha_ary[$n],substr($strtodecrypt,$i,1)),1); 
$n++; 
if($n==$nn) $n = 0; 
$i++; 
} 
return $decrypted_string; 
} 


} // end class Crypto 
?>