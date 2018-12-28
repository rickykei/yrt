<?
$fname=dirname(__FILE__).'/readme.html';
$f=fopen($fname,'r');
$fcnt=fread($f,filesize($fname));
echo nl2br($fcnt).'<br/><br/>';
include('demo/index.php');
