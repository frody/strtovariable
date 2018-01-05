<?php
require_once './strtovar.php';
$myvar = new stdClass;
$myvar->username = 'John';
$myvar->subvar = Array(Array('a','b','c'), Array(width=>100,height=>200));

$yourvar = Array(Array(w=>30,h=>50),'y','z');

$var1 = '$myvar->username';
$var2 = '$myvar->subvar[0][1]';
$var3 = '$myvar->subvar[1][width]'; 

$var4 = '$yourvar[0][w]';

echo strtovar($var1);  //-> 'John'
echo strtovar($var2);  //-> 'b'
echo strtovar($var3);  //-> 100
echo strtovar($var4);  //-> 30
?>