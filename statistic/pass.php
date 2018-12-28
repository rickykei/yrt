<?php
$realm = 'Restricted area';

//user => password
$users = array('yrt' => '98014380', 'yui' => '172081');


if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Digest realm="'.$realm.
           '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');

    die('Text to send if user hits Cancel button');
}


// analyze the PHP_AUTH_DIGEST variable
if (!($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) ||
    !isset($users[$data['username']]))
    die('Wrong Credentials!');


// generate the valid response
$A1 = md5($data['username'] . ':' . $realm . ':' . $users[$data['username']]);
$A2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
$valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);

if ($data['response'] != $valid_response)
    die('Wrong Credentials!');

$_SERVER['HTTP_USER_AGENT']="yrt_y_4";
include("statistic.php");

// function to parse the http auth header
function http_digest_parse($digest) {
                     # edit needed parts, as you  want
    preg_match_all('@(username|nonce|uri|nc|cnonce|qop|response)'.
                    '=[\'"]?([^\'",]+)@', $digest, $t);
    $data = array_combine($t[1], $t[2]);
                     # all parts found?
    return (count($data)==7) ? $data : false;
} 
?>
