<?
$mph = 0;
$kph = 0;
$mps = 0;
$mph=$_GET['mph'];
define('MPH_TO_KPH',1.609344);
define('MPH_TO_MPS',0.44704);

$kph = $mph * MPH_TO_KPH;
$mps = $mph * MPH_TO_MPS;

echo '<item><name>kph</name><value>'.$kph.'</value></item><item><name>mps</name><value>'.$mps.'</value></item>';

